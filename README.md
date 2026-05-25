# BriBooks PHP Developer Assignment

## Project Setup

```bash
git clone <your-github-repo>
cd bribooks-assignment
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

## Database Setup

Create database:

```sql
CREATE DATABASE bribooks_assignment;
```

Import SQL dump:

```bash
bribooks_assignment.sql
```

Update `.env`:

```env
DB_DATABASE=bribooks_assignment
DB_USERNAME=root
DB_PASSWORD=
```

Run:

```bash
php artisan migrate
php artisan serve
```

## Authentication APIs

### Register

POST `/api/auth/register`

### Login

POST `/api/auth/login`

### Profile

GET `/api/auth/profile`

Requires Bearer Token.

---

## Books APIs

### Add Book

POST `/api/books`

### Get Books List

GET `/api/books`

### Search Books

GET `/api/books?search=keyword`

### Get Book By ID

GET `/api/books/{id}`

### Update Book

PUT `/api/books/{id}`

### Soft Delete Book

DELETE `/api/books/{id}`

---

## Features Implemented

- JWT Authentication
- Protected APIs
- CRUD APIs
- Search
- Pagination
- Validation
- SQL Injection Prevention
- Soft Delete
- JSON Responses
- MVC Architecture

## Tech Stack

- Laravel 10
- MySQL
- JWT Auth
- REST API