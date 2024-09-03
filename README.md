# RESTful API with Laravel

## Overview

This project involves building a RESTful API for a market system using the Laravel framework. The API aims to address the most challenging features of APIs with Laravel, offering a robust and efficient solution for market-related operations.

## Features

-   **Authentication**: Secure endpoints using Laravel Passport or Sanctum.
-   **API Rate Limiting**: Implement rate limiting to manage traffic.
-   **Data Transformation**: Use Spatie Laravel Fractal to format API responses.
-   **HTTP Client**: Utilize Symfony HTTP Client for external API requests.
-   **Email Integration**: Configure Symfony Mailgun Mailer for email functionality.

## Technology Stack

-   **Laravel Framework**: 11.21.0
-   **PHP**: 8.2.18
-   **Composer**: 2.7.7
-   **Node.js**: v16.13.0
-   **npm**: 8.12.1
-   **guzzlehttp/guzzle**: ^7.9
-   **laravel/homestead**: ^15.0
-   **laravel/passport**: ^12.3
-   **laravel/sanctum**: ^4.0
-   **laravel/tinker**: ^2.9
-   **laravel/ui**: ^4.5
-   **spatie/laravel-fractal**: ^6.2
-   **symfony/http-client**: ^7.1
-   **symfony/mailgun-mailer**: ^7.1

## Installation

Follow these steps to get the project up and running on your local machine:

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/Divyamurali-k/RESTful-API-for-a-market-system-laravel.git
    cd restfulapi

    ```

2. **Install PHP Dependencies:**
    ```bash
    composer install
    ```
3. **Set Up Environment File:**
  - Copy the .env.example file to .env and configure your environment variables:

    ```bash
    cp .env.example .env
    ```
4. **Configure Database:**
  - Open the .env file and set your database connection details:

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password

    ```
5. **Import the Database:**
  - Import the database from the provided SQL file: 
    - Locate the SQL file in the database folder: database/restfulapi.sql
    - Import it into your MySQL database. You can use a tool like phpMyAdmin 
    
6. **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```
7. **Install Node.js Dependencies:**
    ```bash
    npm install
    ```
8. **Build Assets:**
    ```bash
    npm run dev
    ```
9. **Start the Development Server:**
	```bash 
	php artisan serve
	```
## Usage

You can access the API through `http://localhost:8000` (or whichever port Laravel is serving on). The API endpoints are documented within the codebase and can be tested using tools like Postman.
