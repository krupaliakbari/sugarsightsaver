# Production Assets Deployment Checklist

## Quick Fix for Missing Assets

If assets like `SSSPGraphic1-1.png` are not loading, follow these steps:

### Step 1: Verify HTML Folder Location on Server

**SSH into your production server and check:**

```bash
# Check if HTML folder exists in public directory
ls -la /path/to/laravel/public/HTML/

# Check if assets folder exists
ls -la /path/to/laravel/public/HTML/assets/

# Check if images folder exists
ls -la /path/to/laravel/public/HTML/assets/images/

# Check if the specific file exists
ls -la /path/to/laravel/public/HTML/assets/images/SSSPGraphic1-1.png
```

### Step 2: If HTML Folder is Missing

**Option A: Copy HTML folder manually**

1. On your local machine, locate the `HTML` folder (usually at `../HTML/` or `HTML/`)
2. Upload the entire `HTML` folder to `public/HTML/` on the server via FTP/cPanel
3. Ensure the structure is:
   ```
   public/
   └── HTML/
       └── assets/
           ├── css/
           ├── js/
           ├── images/
           └── video/
   ```

**Option B: Use the build script**

1. Run `build-production.bat` (Windows) or `build-production.sh` (Linux/Mac) locally
2. This will create a `build-production` folder with HTML copied to `public/HTML/`
3. Upload the entire `build-production` folder contents to your server

### Step 3: Verify File Permissions

```bash
# Set correct permissions
chmod -R 755 /path/to/laravel/public/HTML
chmod -R 644 /path/to/laravel/public/HTML/assets/css/*
chmod -R 644 /path/to/laragon/public/HTML/assets/js/*
chmod -R 644 /path/to/laravel/public/HTML/assets/images/*
```

### Step 4: Test Asset URL

Test the asset directly in browser:
```
https://sssp.wethedevelopers.com/assets/images/SSSPGraphic1-1.png
```

### Step 5: Use Diagnostic Route (Temporary)

Visit this URL to see what paths are being checked:
```
https://sssp.wethedevelopers.com/debug-assets
```

This will show:
- Which paths exist
- Which paths are being checked
- Directory locations
- File permissions

**⚠️ Remove or protect this route in production after fixing!**

### Step 6: Check Laravel Logs

If still not working, check logs for detailed error:
```bash
tail -f /path/to/laravel/storage/logs/laravel.log
```

Look for "Asset not found" warnings with detailed path information.

## Common Issues

### Issue: "Asset not found: images/SSSPGraphic1-1.png"
**Cause**: HTML folder not in `public/HTML/`
**Fix**: Copy HTML folder to `public/HTML/` (see Step 2)

### Issue: "404 Not Found" 
**Cause**: Route not matching or file permissions
**Fix**: 
1. Clear route cache: `php artisan route:clear`
2. Check file permissions (Step 3)
3. Verify `.htaccess` isn't blocking requests

### Issue: Assets load but CSS doesn't apply
**Cause**: MIME type or CORS issue
**Fix**: Verify Content-Type headers in route (already set correctly)

### Issue: Some images load, others don't
**Cause**: Case sensitivity on Linux servers or missing files
**Fix**: 
- Verify exact file names match (case-sensitive)
- Ensure all image files were uploaded

## Verification Commands

```bash
# 1. Check if HTML folder exists
test -d public/HTML && echo "✅ HTML folder exists" || echo "❌ HTML folder missing"

# 2. Check if assets folder exists  
test -d public/HTML/assets && echo "✅ Assets folder exists" || echo "❌ Assets folder missing"

# 3. Check if images folder exists
test -d public/HTML/assets/images && echo "✅ Images folder exists" || echo "❌ Images folder missing"

# 4. Check if specific file exists
test -f public/HTML/assets/images/SSSPGraphic1-1.png && echo "✅ File exists" || echo "❌ File missing"

# 5. Check file permissions
ls -l public/HTML/assets/images/SSSPGraphic1-1.png

# 6. Check route cache
php artisan route:list | grep assets
```

## Expected File Structure

```
public/
├── HTML/
│   ├── assets/
│   │   ├── css/
│   │   │   ├── styles.css
│   │   │   ├── fontawesome.all.min.css
│   │   │   └── ...
│   │   ├── js/
│   │   │   ├── jquery.min.3.7.1.js
│   │   │   └── ...
│   │   ├── images/
│   │   │   ├── logo.png
│   │   │   ├── SSSPGraphic1-1.png  ← This file must exist
│   │   │   ├── SSSPGraphic1-2.png
│   │   │   └── ...
│   │   └── video/
│   └── manifest.json (if exists)
└── index.php
```

## Quick Test Script

Create a test file `test-assets.php` in public directory:

```php
<?php
$file = 'images/SSSPGraphic1-1.png';
$paths = [
    'public/HTML/assets/' . $file => __DIR__ . '/HTML/assets/' . $file,
    'public/assets/' . $file => __DIR__ . '/assets/' . $file,
];

echo "Checking for: $file\n\n";
foreach ($paths as $label => $path) {
    $exists = file_exists($path);
    $real = realpath($path);
    echo "$label: " . ($exists ? "✅ EXISTS" : "❌ NOT FOUND") . "\n";
    if ($real) echo "   Real path: $real\n";
}
```

Access via: `https://sssp.wethedevelopers.com/test-assets.php`

