test:
	docker compose exec php vendor/bin/phpunit

start:
	docker compose up -d

down:
	docker compose down

init:
	docker compose up --build -d
	docker compose exec php npm install
	docker compose exec php npm run build
	docker compose exec php composer install
	docker compose exec php cp .env.example .env
	docker compose exec php php artisan key:generate; php artisan migrate --seed
	docker compose exec php php artisan scout:import App\\Models\\Advert
	docker compose exec php chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache; chmod -R 775 /var/www/storage /var/www/bootstrap/cache
	docker compose exec php php artisan storage:link  

asset:
	docker compose exec php npm run build

refresh:
	docker compose exec php php artisan migrate:fresh --seed


migratetest:
	docker compose exec php php artisan migrate:fresh --env=testing --seed