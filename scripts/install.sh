echo "Installing Project..."

composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate:fresh --seed
php artisan serve

echo "Project Installed!"
