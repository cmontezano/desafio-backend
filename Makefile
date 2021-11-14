install: env build up composer key

env:
	cp .env.example .env

build:
	docker-compose build

key:
	docker-compose exec app php artisan key:generate

clean:
	docker-compose exec app php artisan optimize:clear

composer:
	docker-compose exec app composer install

down:
	docker-compose down --remove-orphans

dump:
	docker-compose exec app composer dump

logs:
	docker-compose logs -ft --tail 100 app

migrate:
	docker-compose exec app php artisan migrate

shell:
	docker-compose exec app /bin/sh

test:
	docker-compose exec app php artisan test

up:
	docker-compose up -d
