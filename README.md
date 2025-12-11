# Project Installation Guide

## 1. Clone the Project
```bash
git clone https://github.com/YOUR-USERNAME/YOUR-REPO.git
cd YOUR-REPO

composer install

cp .env.example .env

DB_DATABASE=practicle_test
DB_USERNAME=root
DB_PASSWORD=

php artisan key:generate

php artisan migrate:fresh

php artisan db:seed

php artisan serve
