test:
	docker-compose exec php vendor/bin/phpunit

start:
	docker-compose up -d

down:
	docker-compose down

init:
	docker-compose up --build -d
	docker-compose exec php npm install
	docker-compose exec php npm run build

asset:
	docker-compose exec php npm run build

refresh:
	docker-compose exec php php artisan migrate:fresh --seed


migratetest:
	docker-compose exec php php artisan migrate:fresh --env=testing --seed