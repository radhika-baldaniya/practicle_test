Laravel 12 Project Installation Guide
1. Clone the Project
git clone [git@github.com:radhika-baldaniya/practicle_test.git](https://github.com/radhika-baldaniya/practicle_test.git)
cd practicle_test

2. Install Dependencies
composer install

3. Setup Environment File
cp .env.example .env

Now open .env and update database settings:

DB_DATABASE=practicle_test
DB_USERNAME=root
DB_PASSWORD=

4. Generate App Key
php artisan key:generate

5. Run Migrations
php artisan migrate

If you want a fresh database every time:

php artisan migrate:fresh

6. Seed the Database
php artisan db:seed

7. Start the Server
php artisan serve


Your project will run at:

http://127.0.0.1:8000