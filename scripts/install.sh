echo "Installing Project..."

composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

echo "Project Installed!"
