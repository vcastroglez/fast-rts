#!/bin/bash
nvm use node
npm run build
php artisan serve
php artisan queue:listen
php artisan reverb:start
npm run dev
