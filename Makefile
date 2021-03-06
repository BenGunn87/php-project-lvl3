start:
	php artisan serve --host 0.0.0.0

install:
	composer install

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	php artisan migrate
	php artisan db:seed

setup-for-auto-test:
	composer install
	cp -n .env.ci .env|| true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed

setup-start: setup
	php artisan serve --host 0.0.0.0

watch:
	npm run watch

migrate:
	php artisan migrate

console:
	php artisan tinker

log:
	tail -f storage/logs/laravel.log

test:
	php artisan test

deploy:
	git push heroku

lint:
	composer phpcs -- --standard=PSR12 app

lint-fix:
	composer phpcbf

compose:
	docker-compose up

compose-test:
	docker-compose run app make test

compose-bash:
	docker-compose run app bash

compose-setup: compose-build
	docker-compose run app make setup

compose-start: compose-build
	docker-compose up -d
	docker-compose run app make setup-start

compose-build:
	docker-compose build app

compose-db:
	docker-compose exec db psql -U postgres

compose-down:
	docker-compose down
