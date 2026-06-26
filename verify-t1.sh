#!/bin/bash
php artisan route:list | grep -E 'GET.*/' | head -1 > /dev/null && \
curl -s http://localhost:8000/ | grep -q '<html'
