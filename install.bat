@echo off
echo ================================================
echo   InspeksiKu - Setup Script
echo ================================================

echo.
echo [1/6] Installing PHP dependencies...
composer install --no-interaction

echo.
echo [2/6] Copying .env file...
if not exist .env copy .env.example .env

echo.
echo [3/6] Generating application key...
php artisan key:generate

echo.
echo [4/6] Running database migrations...
php artisan migrate --force

echo.
echo [5/6] Running seeders...
php artisan db:seed --force

echo.
echo [6/6] Installing Node dependencies & building assets...
npm install
npm run build

echo.
echo [7/7] Creating storage symlink...
php artisan storage:link

echo.
echo ================================================
echo   Setup selesai!
echo   Buka: http://inspeksi.test
echo ================================================
pause
