# Ticket Management System

A simple ticket management app built with **Laravel 12** and **jQuery/AJAX**.
Features: user login, ticket CRUD, mark-as-resolved, and delete — all without page reloads.

## Requirements

- PHP 8.2+
- Composer
- MySQL
- Node.js & npm

## Setup

1. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Then set your MySQL credentials in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=betternship_test
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Create the database**
   ```bash
   mysql -uroot -e "CREATE DATABASE IF NOT EXISTS betternship_test;"
   ```

4. **Run migrations and seed a login user**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

## Running the app

In two separate terminals:

```bash
php artisan serve     # http://127.0.0.1:8000
```
```bash
npm run dev           # Vite dev server (assets)
```

Then open **http://127.0.0.1:8000/login**.

## Login

| Email            | Password   |
|------------------|------------|
| test@test.com   | password   |

## Routes

- `/login` — login page
- `/tickets` — list, create, edit, resolve, and delete tickets
