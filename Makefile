.ONESHELL:
SHELL := /bin/bash

install:
	git clone --depth=1 --branch=develop https://github.com/Toycu27/BugTrax-API.git &&
	rsync -r BugTrax-API/* ./ &&
	rm -r BugTrax-API/
	composer install --optimize-autoloader &&
	php artisan config:cache &&
	php artisan route:cache &&
	php artisan view:cache &&
	php artisan storage:link &&
	php artisan migrate:fresh --seed

update: install

cache:
	php artisan config:cache &&
	php artisan route:cache &&
	php artisan view:cache &&
	php artisan storage:link

seed:
	php artisan migrate:fresh --seed