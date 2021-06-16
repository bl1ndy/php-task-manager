start:
	php artisan serve

setup:
	composer install --prefer-source
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	npm install
	touch database/database.sqlite
	php artisan migrate

watch:
	npm run watch

console:
	php artisan tinker

log:
	tail -f storage/logs/laravel.log

test:
	php artisan test

deploy:
	git push heroku

lint:
	composer phpcs

test-coverage:
	composer test -- --coverage-clover build/logs/clover.xml