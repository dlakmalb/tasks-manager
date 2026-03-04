# Task Manager

A Laravel Breeze + Blade web app for managing projects and tasks with authentication, validation, and ownership-based authorization.

## Tech Stack

- PHP 8.2 / Laravel 12
- Blade (server-rendered UI)
- MySQL 
- Laravel Breeze (auth)

## Features

- Register / login / logout
- Project CRUD
- Task CRUD inside each project
- Mark task done / undo
- Project/task ownership checks (users can only access their own data)
- Form Request validation
- Seed data for quick review

## Setup

1. Clone and install dependencies:

```bash
composer install
npm install
```

2. Copy env and generate app key:

```bash
cp .env.example .env
php artisan key:generate
```

3. Update `.env` database settings for your local MySQL.

4. Run migrations and seeders:

```bash
php artisan migrate:fresh --seed
```

5. Start the app:

```bash
php artisan serve
npm run dev
```

## Database Seeding

Seeder creates:

- 2 users (User A and User B)
- 2 projects per user
- 5 tasks per project
- Mixed done/todo task states
- Optional due dates

### Seeded Credentials

- User A
  - Email: `usera@example.com`
  - Password: `password`
- User B
  - Email: `userb@example.com`
  - Password: `password`

## Run Tests

```bash
php artisan test
```
