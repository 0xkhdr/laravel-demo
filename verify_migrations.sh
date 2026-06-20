#!/bin/sh
docker exec laravel-demo-app-1 sh -c 'php artisan migrate:fresh && php artisan tinker -e "echo DB::table('\''roles'\'')->count();"'
