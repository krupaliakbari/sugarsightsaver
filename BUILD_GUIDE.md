# Production Build Guide

## Quick Build and Deploy Process

Yes, you can create a build and upload it directly! Follow these steps:

### Option 1: Automated Build (Recommended)

#### Windows:
```bash
# Run the build script
build-production.bat
```

#### Linux/Mac:
```bash
# Make script executable
chmod +x build-production.sh

# Run the build script
./build-production.sh
```

This will create a `build-production` folder with everything ready to upload.

### Option 2: Manual Build

1. **Install Production Dependencies**
   ```bash
   composer install --no-dev --optimize-autoloader
   npm install && npm run build
   ```

2. **Copy HTML Folder**
   ```bash
   # Copy HTML folder to public directory
   cp -r HTML public/HTML
   ```

3. **Create Build Package**
   - Copy all files except:
     - `.git`, `node_modules`, `.env`, `tests`
     - `storage/logs/*`, `storage/framework/cache/*`
   - Zip everything

### What Gets Included in Build

✅ **Included:**
- All application code
- `vendor/` folder (Composer dependencies)
- Compiled assets (from `npm run build`)
- `public/HTML/` folder (your static HTML files)
- Configuration files
- Database migrations
- `.env.example` (template)

❌ **Excluded:**
- `.env` file (create on server)
- `node_modules/` (not needed in production)
- `storage/logs/*` (will be created on server)
- `.git/` folder
- Development files

### Upload Process

1. **Create the build** (using script or manual)
2. **Zip the `build-production` folder**
3. **Upload to server** via FTP/cPanel/SSH
4. **Extract** to your web root directory
5. **Follow post-deployment steps** (see below)

### Post-Deployment Steps (On Server)

```bash
# 1. Set permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 2. Create .env file
cp .env.example .env
nano .env  # Edit with your production settings

# 3. Generate app key
php artisan key:generate

# 4. Run migrations
php artisan migrate --force

# 5. Create storage link
php artisan storage:link

# 6. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### File Structure After Build

```
build-production/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── HTML/          ← HTML files here
│   │   ├── index.html
│   │   ├── assets/
│   │   └── ...
│   ├── index.php
│   └── build/         ← Compiled assets
├── resources/
├── routes/
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
├── vendor/            ← Composer packages
├── .env.example
├── composer.json
└── DEPLOY_INSTRUCTIONS.txt
```

### Important Notes

1. **HTML Folder**: Must be at `public/HTML/` for the home page to work
2. **.env File**: Never upload your `.env` file. Create it on the server.
3. **Permissions**: Always set proper file permissions on the server
4. **Database**: Make sure database credentials in `.env` are correct

### Verification Checklist

After deployment, verify:
- [ ] Home page (`/`) loads (not redirecting to login)
- [ ] `diabetes.html` page works
- [ ] Assets (CSS, JS, images) load correctly
- [ ] Doctor registration links work
- [ ] Login functionality works
- [ ] Database connection works

### Troubleshooting

**Home page redirects to login:**
- Check if `public/HTML/index.html` exists
- Verify file permissions
- Clear caches: `php artisan route:clear`

**Assets not loading:**
- Check `public/HTML/assets/` exists
- Verify file permissions
- Check Laravel logs: `storage/logs/laravel.log`

**500 Errors:**
- Check file permissions on `storage/` and `bootstrap/cache/`
- Verify `.env` is configured correctly
- Check error logs: `storage/logs/laravel.log`

