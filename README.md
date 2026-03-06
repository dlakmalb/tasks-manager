<div align="center">
    <h1>
        📋 Tasks Manager<br/>
        <sub><sup><sub>Plan projects. Track tasks. Stay organized.</sub></sup></sub><br/>
    </h1>
</div>
<br/>

## 📝 Summary
A Laravel Breeze + Blade web app for managing projects and tasks with authentication, validation, and ownership-based authorization.

## 🧱 Tech Stack

- PHP 8.2+
- Laravel 12
- Blade + Tailwind CSS
- Laravel Breeze (authentication scaffolding)
- MySQL
- Vite (frontend asset bundler)
- Docker (Nginx + PHP-FPM + MySQL)

## 📌 Features

- [x] User authentication (register, login, logout) using Laravel Breeze
- [x] Project CRUD (create, view, edit, delete)
- [x] Task CRUD within each project
- [x] Mark tasks as done / undo completion
- [x] Task due date support
- [x] Ownership-based authorization (users can only access their own projects and tasks)
- [x] Form Request validation for project and task inputs
- [x] Database seeders with sample users, projects, and tasks

## 🚀 Running the Project

### 🐳 Run With Docker (Recommended)
This project includes a complete Docker setup (Nginx, PHP-FPM, MySQL, Vite, and Mailpit) so it can run without installing PHP or MySQL locally.

#### 1. Clone the repository
```bash
git clone https://github.com/dlakmalb/tasks-manager.git
cd tasks-manager
```

#### 2. Build and start the containers
```bash
docker compose up -d --build
````

#### 3. Create the environment file
```bash
cp .env.docker.example .env
```

#### 4. Install dependencies and generate the application key
```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
```

#### 5. Run database migrations and seed data
```bash
docker compose exec app php artisan migrate:fresh --seed
```

#### 6. Start the Vite dev server
```bash
docker compose up -d vite
```

#### 7. Access the application
- App: `http://localhost:8080`
- Vite dev server: `http://localhost:5173`
- Mailpit inbox: `http://localhost:8025`
- MySQL host port: `127.0.0.1:3307` (container port `3306`)

#### 8. Useful Commands
```bash
docker compose down
docker compose logs -f app web db
docker compose exec app php artisan test
```

### 💻 Run Locally (Without Docker)

#### Prerequisites
- PHP 8.2+
- Composer
- Node.js + npm
- MySQL

#### 1. Clone the repository and install dependencies
```bash
git clone https://github.com/dlakmalb/tasks-manager.git
cd tasks-manager
composer install
npm install
```

#### 2. Create the environment file and generate the app key
```bash
cp .env.example .env
php artisan key:generate
```

#### 3. Configure database credentials
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tasks_manager
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### 4. Create the database and run migrations
Create an empty MySQL database named `tasks_manager` (recommended), then run:
```bash
php artisan migrate --seed
```
If you already have tables and want a clean reset:
```bash
php artisan migrate:fresh --seed
```

#### 5. Start the app:
```bash
php artisan serve
npm run dev
```

## 🌱 Database Seeding

The seeder creates:

- 2 users (User A and User B)
- 2 projects per user
- 5 tasks per project
- Tasks with mixed done / todo states
- Optional due dates for some tasks

### Seeded Credentials
You can log in using the following accounts:
- User A
  - Email: `usera@example.com`
  - Password: `password`
- User B
  - Email: `userb@example.com`
  - Password: `password`

## ✅ Run Tests
The project includes automated tests to verify core functionality.

Run the test suite with:
```bash
php artisan test
```

## 🏗 Architecture

This application follows a standard Laravel MVC architecture with server-rendered Blade views.

- **Controllers** handle HTTP requests and coordinate application logic.
- **Models (Eloquent)** represent Projects and Tasks and manage database relationships.
- **Form Requests** handle validation for project and task inputs.
- **Blade Views** render the user interface on the server.
- **Policies / Query Scoping** enforce ownership so users can only access their own projects and tasks.

### Main Relationships

- A **User** has many **Projects**
- A **Project** has many **Tasks**
