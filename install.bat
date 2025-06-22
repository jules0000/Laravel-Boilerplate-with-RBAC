@echo off
echo ========================================
echo   Laravel Boilerplate Installation
echo ========================================
echo.

echo Step 1: Installing Composer dependencies...
composer install
if errorlevel 1 (
    echo Error: Failed to install dependencies
    pause
    exit /b 1
)

echo.
echo Step 2: Copying environment file...
if not exist .env (
    copy env.example .env
    echo Environment file created
) else (
    echo Environment file already exists
)

echo.
echo Step 3: Generating application key...
php artisan key:generate
if errorlevel 1 (
    echo Error: Failed to generate key
    pause
    exit /b 1
)

echo.
echo Step 4: Creating storage directories...
if not exist storage\app mkdir storage\app
if not exist storage\framework mkdir storage\framework
if not exist storage\framework\cache mkdir storage\framework\cache
if not exist storage\framework\sessions mkdir storage\framework\sessions
if not exist storage\framework\views mkdir storage\framework\views
if not exist storage\logs mkdir storage\logs

echo.
echo ========================================
echo   Installation Complete!
echo ========================================
echo.
echo Next steps:
echo 1. Configure your database in .env file
echo 2. Create database: CREATE DATABASE laravel_boilerplate;
echo 3. Run: php artisan migrate
echo 4. Run: php artisan db:seed
echo 5. Run: php artisan serve
echo.
echo Default login credentials:
echo Admin: admin@example.com / password
echo Manager: manager@example.com / password
echo User: user@example.com / password
echo.
pause 