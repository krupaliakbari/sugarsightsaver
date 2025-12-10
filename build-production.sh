#!/bin/bash

# Production Build Script for Sugar Sight Saver
# This script creates a production-ready build that can be uploaded directly to the server

echo "🚀 Starting Production Build..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Step 1: Clean previous builds
echo -e "${YELLOW}📦 Cleaning previous builds...${NC}"
rm -rf build-production
mkdir -p build-production

# Step 2: Copy Laravel files (excluding development files)
echo -e "${YELLOW}📁 Copying Laravel files...${NC}"
rsync -av \
    --exclude='.git' \
    --exclude='.env' \
    --exclude='.env.example' \
    --exclude='node_modules' \
    --exclude='storage/logs/*' \
    --exclude='storage/framework/cache/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    --exclude='storage/app/public/*' \
    --exclude='build-production' \
    --exclude='.gitignore' \
    --exclude='.editorconfig' \
    --exclude='.php_cs' \
    --exclude='package-lock.json' \
    --exclude='yarn.lock' \
    --exclude='tests' \
    --exclude='phpunit.xml' \
    --exclude='.phpunit.result.cache' \
    --exclude='DEPLOYMENT.md' \
    --exclude='build-production.sh' \
    ./ build-production/

# Step 3: Install Composer dependencies (production only)
echo -e "${YELLOW}📦 Installing Composer dependencies (production)...${NC}"
cd build-production
composer install --no-dev --optimize-autoloader --no-interaction

# Step 4: Build frontend assets
echo -e "${YELLOW}🎨 Building frontend assets...${NC}"
npm ci --production=false
npm run build

# Step 5: Copy HTML folder to public directory (if exists)
echo -e "${YELLOW}📄 Copying HTML folder...${NC}"
if [ -d "../HTML" ]; then
    cp -r ../HTML public/HTML
    echo -e "${GREEN}✅ HTML folder copied to public/HTML${NC}"
else
    echo -e "${RED}⚠️  Warning: ../HTML folder not found!${NC}"
    echo -e "${YELLOW}   Make sure to copy HTML folder manually to public/HTML on server${NC}"
fi

# Step 6: Create storage directories
echo -e "${YELLOW}📁 Creating storage directories...${NC}"
mkdir -p storage/app/public
mkdir -p storage/app/temp
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
touch storage/logs/.gitkeep

# Step 7: Create .htaccess files if missing
echo -e "${YELLOW}📝 Creating .htaccess files...${NC}"
if [ ! -f "public/.htaccess" ]; then
    cat > public/.htaccess << 'EOF'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOF
fi

# Step 8: Create deployment instructions file
echo -e "${YELLOW}📋 Creating deployment instructions...${NC}"
cat > DEPLOY_INSTRUCTIONS.txt << 'EOF'
===========================================
PRODUCTION DEPLOYMENT INSTRUCTIONS
===========================================

1. Upload all files from this build to your server

2. Set proper permissions:
   chmod -R 755 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache

3. Create .env file on server:
   cp .env.example .env
   # Then edit .env with your production settings

4. Generate application key:
   php artisan key:generate

5. Run database migrations:
   php artisan migrate --force

6. Create storage link:
   php artisan storage:link

7. Clear and cache:
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache

8. Verify HTML folder exists at: public/HTML/

9. Test the application:
   - Visit: https://yourdomain.com/
   - Should show home page (not redirect to login)

===========================================
EOF

# Step 9: Create zip file
cd ..
echo -e "${YELLOW}🗜️  Creating ZIP archive...${NC}"
zip -r sugar-sight-saver-production-$(date +%Y%m%d-%H%M%S).zip build-production/ -x "*.git*" "*.DS_Store"

echo -e "${GREEN}✅ Build completed successfully!${NC}"
echo -e "${GREEN}📦 Production build is in: build-production/${NC}"
echo -e "${GREEN}📦 ZIP file created in current directory${NC}"
echo ""
echo -e "${YELLOW}Next steps:${NC}"
echo "1. Upload the ZIP file to your server"
echo "2. Extract it to your web root"
echo "3. Follow instructions in build-production/DEPLOY_INSTRUCTIONS.txt"

