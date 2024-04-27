<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About MY Project

An employee management system is technology designed to streamline core HR services and improve workforce productivity. It accomplishes these goals largely by automating labor-intensive, administrative tasks and using analytics to drive business decisions.


# Employee Management System  

## Setup Instructions  

1. Clone the repository to your local machine  
shell

git clone <repository_url>
2. Install dependencies  
shell

composer install  
npm install  
3. Copy the .env.example file and rename it to .env
shell

cp .env.example .env
4. Generate application key  
shell

php artisan key:generate
5. Create a new database and update the .env file with your database credentials

6. Migrate the database  
shell

php artisan migrate
7. Seed the database 
shell

php artisan db:seed
8. Start the development server  
shell

php artisan serve
