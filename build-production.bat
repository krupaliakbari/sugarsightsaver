@echo off
REM Production Build Script for Sugar Sight Saver (Windows)
REM This script creates a production-ready build that can be uploaded directly to the server

echo 🚀 Starting Production Build...

REM Step 1: Clean previous builds
echo 📦 Cleaning previous builds...
if exist build-production rmdir /s /q build-production
mkdir build-production

REM Step 2: Copy Laravel files (using robocopy for better control)
echo 📁 Copying Laravel files...
robocopy . build-production /E /XD .git node_modules build-production storage\logs storage\framework\cache storage\framework\sessions storage\framework\views storage\app\public tests .phpunit.result.cache /XF .env .env.example .gitignore package-lock.json yarn.lock phpunit.xml build-production.bat build-production.sh DEPLOYMENT.md

REM Step 3: Navigate to build directory
cd build-production

REM Step 4: Install Composer dependencies (production only)
echo 📦 Installing Composer dependencies (production)...
call composer install --no-dev --optimize-autoloader --no-interaction
if errorlevel 1 (
    echo ❌ Composer install failed!
    cd ..
    exit /b 1
)

REM Step 5: Build frontend assets
echo 🎨 Building frontend assets...
call npm ci
if errorlevel 1 (
    echo ⚠️  npm ci failed, trying npm install...
    call npm install
)
call npm run build
if errorlevel 1 (
    echo ❌ npm build failed!
    cd ..
    exit /b 1
)

REM Step 6: Copy HTML folder to public directory (if exists)
echo 📄 Copying HTML folder...
if exist ..\HTML (
    xcopy /E /I /Y ..\HTML public\HTML
    echo ✅ HTML folder copied to public\HTML
    echo ✅ Assets will be accessible at /assets/css/, /assets/images/, etc.
) else if exist HTML (
    xcopy /E /I /Y HTML public\HTML
    echo ✅ HTML folder copied from HTML\ to public\HTML
    echo ✅ Assets will be accessible at /assets/css/, /assets/images/, etc.
) else (
    echo ⚠️  Warning: HTML folder not found!
    echo    Make sure to copy HTML folder manually to public\HTML on server
    echo    Structure should be: public\HTML\assets\css\, public\HTML\assets\images\, etc.
)

REM Step 7: Create storage directories
echo 📁 Creating storage directories...
if not exist storage\app\public mkdir storage\app\public
if not exist storage\app\temp mkdir storage\app\temp
if not exist storage\framework\cache\data mkdir storage\framework\cache\data
if not exist storage\framework\sessions mkdir storage\framework\sessions
if not exist storage\framework\views mkdir storage\framework\views
if not exist storage\logs mkdir storage\logs
type nul > storage\logs\.gitkeep

REM Step 8: Create deployment instructions file
echo 📋 Creating deployment instructions...
(
echo ===========================================
echo PRODUCTION DEPLOYMENT INSTRUCTIONS
echo ===========================================
echo.
echo 1. Upload all files from this build to your server
echo.
echo 2. Set proper permissions:
echo    chmod -R 755 storage bootstrap/cache
echo    chown -R www-data:www-data storage bootstrap/cache
echo.
echo 3. Create .env file on server:
echo    cp .env.example .env
echo    # Then edit .env with your production settings
echo.
echo 4. Generate application key:
echo    php artisan key:generate
echo.
echo 5. Run database migrations:
echo    php artisan migrate --force
echo.
echo 6. Create storage link:
echo    php artisan storage:link
echo.
echo 7. Clear and cache:
echo    php artisan config:cache
echo    php artisan route:cache
echo    php artisan view:cache
echo.
echo 8. Verify HTML folder exists at: public/HTML/
echo.
echo 9. Test the application:
echo    - Visit: https://yourdomain.com/
echo    - Should show home page (not redirect to login)
echo.
echo ===========================================
) > DEPLOY_INSTRUCTIONS.txt

cd ..
echo.
echo ✅ Build completed successfully!
echo 📦 Production build is in: build-production\
echo.
echo Next steps:
echo 1. Zip the build-production folder
echo 2. Upload the ZIP file to your server
echo 3. Extract it to your web root
echo 4. Follow instructions in build-production\DEPLOY_INSTRUCTIONS.txt
echo.

