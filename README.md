# Laravel Project Setup with Docker (Sail)

## Install Dependencies
```bash
composer install
```

## Start Laravel Sail
```bash
./vendor/bin/sail up -d
```

## Run Migrations
```bash
./vendor/bin/sail artisan migrate --seed
```
In storage/logs/laravel.log file should be API TOKEN KEY. Use it to authenticate when sending requests to API

## Start queue worker
```bash
./vendor/bin/sail artisan queue:work
```

## Access the Application
http://localhost

# API

## Authentication
Add to header Bearer Token
```bash
"Authorization": "Bearer {YOUR_AUTH_KEY}"
```

## POST /api/subscriptions/1/transition

### Body example
```json
{
   "phase": "active" 
}
```

## GET /api/subscriptions/1/amount?usedUntil=2025-09-17
