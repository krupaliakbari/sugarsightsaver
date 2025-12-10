# Production Deployment Guide

## Prerequisites
- PHP 8.1+ with required extensions
- Composer installed
- Node.js and NPM (for asset compilation)
- MySQL/MariaDB database
- Web server (Apache/Nginx)

## Step 1: Upload Files

1. Upload your Laravel application files to the server
2. **Important**: Upload the `HTML` folder to one of these locations:
   - **Recommended**: `public/HTML/` (copy HTML folder inside public directory)
   - Alternative: Root of Laravel project as `HTML/`
   - Alternative: Parent directory as `../HTML/`

## Step 2: Environment Setup

1. Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```

2. Update `.env` file with production settings:
   ```env
   APP_NAME="Sugar Sight Saver"
   APP_ENV=production
   APP_KEY=
   APP_DEBUG=false
   APP_URL=https://sssp.wethedevelopers.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password

   # Wati WhatsApp API (if using)
   WATI_API_ENDPOINT=
   WATI_API_TOKEN=
   WATI_WHATSAPP_NUMBER=

   # 2Factor.in SMS API (if using)
   TWOFACTOR_API_KEY=
   SMS_SENDER_ID=SUGAR
   ```

3. Generate application key:
   ```bash
   php artisan key:generate
   ```

## Step 3: Install Dependencies

1. Install PHP dependencies:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

2. Install NPM dependencies and build assets:
   ```bash
   npm install
   npm run build
   ```

## Step 4: Database Setup

1. Run migrations:
   ```bash
   php artisan migrate --force
   ```

2. (Optional) Seed default settings:
   ```bash
   php artisan db:seed --class=SettingsSeeder
   ```

## Step 5: Storage and Permissions

1. Create storage link:
   ```bash
   php artisan storage:link
   ```

2. Set proper permissions:
   ```bash
   chmod -R 755 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```
   (Replace `www-data` with your web server user if different)

3. Create temp directory for PDFs:
   ```bash
   mkdir -p storage/app/temp
   chmod 755 storage/app/temp
   ```

## Step 6: Clear and Optimize Caches

1. Clear all caches:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   ```

2. Optimize for production:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## Step 7: Verify File Structure

Ensure your file structure looks like this:
```
your_laravel_root/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── HTML/          ← HTML folder should be here
│   │   ├── index.html
│   │   ├── diabetes.html
│   │   └── assets/
│   │       ├── css/
│   │       ├── js/
│   │       ├── images/
│   │       └── video/
│   ├── index.php
│   └── .htaccess
├── resources/
├── routes/
├── storage/
├── .env
└── composer.json
```

## Step 8: Web Server Configuration

### Apache (.htaccess in root)

Ensure your root `.htaccess` contains:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} !=on
    RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    RewriteBase /
    RewriteRule (.*) public/$1 [L]
    Options -Indexes 
</IfModule>
```

### Nginx Configuration

Add to your Nginx server block:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    include fastcgi_params;
}
```

## Step 9: Test the Application

1. Visit `https://sssp.wethedevelopers.com/` - Should show home page
2. Visit `https://sssp.wethedevelopers.com/diabetes.html` - Should show diabetes page
3. Test doctor registration links
4. Test login functionality
5. Verify assets (CSS, JS, images) are loading

## Step 10: Setup Cron Jobs

Add to crontab (if using scheduled tasks):
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Troubleshooting

### Home page redirects to login
- Check if `HTML/index.html` exists in `public/HTML/` or other checked paths
- Verify file permissions (755 for directories, 644 for files)
- Check Laravel logs: `storage/logs/laravel.log`

### Assets not loading
- Verify `HTML/assets/` folder exists in correct location
- Check file permissions
- Clear route cache: `php artisan route:clear`

### 500 Internal Server Error
- Check file permissions on `storage/` and `bootstrap/cache/`
- Review error logs in `storage/logs/laravel.log`
- Ensure `.env` is configured correctly

### Database Connection Error
- Verify database credentials in `.env`
- Ensure database exists
- Check database user has proper permissions

## Security Checklist

- [ ] `APP_DEBUG=false` in `.env`
- [ ] `APP_ENV=production` in `.env`
- [ ] Strong database passwords
- [ ] Secure file permissions (no 777)
- [ ] HTTPS enabled
- [ ] `.env` file not publicly accessible
- [ ] Regular backups configured

## Post-Deployment

1. Test all major functionalities
2. Monitor error logs
3. Set up regular backups
4. Configure monitoring/alerting (optional)
5. Update any API keys/tokens if needed

