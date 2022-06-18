install:
	git clone --depth=1 --branch=develop https://github.com/Toycu27/BugTrax-API.git &&
	cd BugTrax-API &&
	composer install --optimize-autoloader --no-dev &&
	php artisan config:cache &&
	php artisan route:cache &&
	php artisan view:cache &&
	php artisan storage:link &&
	php artisan migrate:fresh --seed

update:
	git clone --depth=1 --branch=develop https://github.com/Toycu27/BugTrax-API.git tmpBugTrax/ &&
	rsync -r tmpBugTrax/* ./ &&
	composer install --optimize-autoloader --no-dev &&
	php artisan config:cache &&
	php artisan route:cache &&
	php artisan view:cache &&
	php artisan storage:link

cache:
	php artisan config:cache &&
	php artisan route:cache &&
	php artisan view:cache &&
	php artisan storage:link

seed:
	php artisan migrate:fresh --seed