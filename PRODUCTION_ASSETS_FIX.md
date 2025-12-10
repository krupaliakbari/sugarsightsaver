# Production Assets Not Loading - Fix Guide

## Problem
CSS and images are not loading in production. The page displays but without styling.

## Root Cause
The `/assets/{path}` route cannot find the HTML/assets folder in production.

## Solution

### Step 1: Ensure HTML Folder is in Correct Location

**The HTML folder MUST be at: `public/HTML/`**

Structure should be:
```
public/
├── HTML/
│   ├── index.html
│   ├── diabetes.html
│   └── assets/
│       ├── css/
│       │   ├── styles.css
│       │   ├── fontawesome.all.min.css
│       │   └── ...
│       ├── js/
│       │   ├── jquery.min.3.7.1.js
│       │   ├── owl.carousel.min.js
│       │   └── script.js
│       ├── images/
│       │   ├── logo.png
│       │   ├── SSSPGraphic1-1.png
│       │   └── ...
│       └── video/
│           └── ...
├── index.php
└── .htaccess
```

### Step 2: Upload HTML Folder to Server

**Option A: Manual Upload**
1. Copy the `HTML` folder from your local machine
2. Upload it to `public/HTML/` on the server via FTP/cPanel
3. Ensure all subfolders (css, js, images, video) are included

**Option B: Using Build Script**
1. Run `build-production.bat` (Windows) or `build-production.sh` (Linux/Mac)
2. The script automatically copies HTML folder to `public/HTML/`
3. Upload the entire `build-production` folder to server

### Step 3: Verify File Permissions

On the server, set proper permissions:
```bash
chmod -R 755 public/HTML
chmod -R 644 public/HTML/assets/css/*
chmod -R 644 public/HTML/assets/js/*
chmod -R 644 public/HTML/assets/images/*
```

### Step 4: Test Asset Routes

After uploading, test these URLs:
- `https://sssp.wethedevelopers.com/assets/css/styles.css` - Should load CSS
- `https://sssp.wethedevelopers.com/assets/images/logo.png` - Should show logo
- `https://sssp.wethedevelopers.com/assets/js/jquery.min.3.7.1.js` - Should load JS

If these return 404, the HTML folder is not in the correct location.

### Step 5: Check Laravel Logs

If assets still don't load, check the logs:
```bash
tail -f storage/logs/laravel.log
```

Look for "Asset not found" warnings which will show which paths were checked.

### Step 6: Alternative - Use Symbolic Link

If you prefer to keep HTML outside public:
```bash
# On server
ln -s /path/to/HTML /path/to/laravel/public/HTML
```

## Quick Fix Checklist

- [ ] HTML folder exists at `public/HTML/`
- [ ] `public/HTML/assets/css/` exists and contains CSS files
- [ ] `public/HTML/assets/images/` exists and contains image files
- [ ] `public/HTML/assets/js/` exists and contains JS files
- [ ] File permissions are set correctly (755 for folders, 644 for files)
- [ ] Route cache is cleared: `php artisan route:clear`
- [ ] Test asset URLs directly in browser

## Common Issues

**Issue**: Assets return 404
- **Fix**: Verify HTML folder is at `public/HTML/` (not `public/assets/` or root)

**Issue**: Assets load but CSS doesn't apply
- **Fix**: Check browser console for CORS or MIME type errors
- **Fix**: Verify CSS files are complete (not truncated during upload)

**Issue**: Some images load, others don't
- **Fix**: Check file names match exactly (case-sensitive on Linux servers)
- **Fix**: Verify all image files were uploaded

## Verification Commands

On the server, run:
```bash
# Check if HTML folder exists
ls -la public/HTML/

# Check if assets folder exists
ls -la public/HTML/assets/

# Check CSS files
ls -la public/HTML/assets/css/

# Check image files
ls -la public/HTML/assets/images/

# Check file permissions
stat public/HTML/assets/css/styles.css
```

