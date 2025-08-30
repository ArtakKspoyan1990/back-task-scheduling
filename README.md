# Task Scheduler Backend (Laravel 11)

This is the **backend API** for the Task Scheduler project. It handles user authentication, task management, and notifications.

---

## Features

- Task CRUD (Create, Read, Update, Delete)
- User roles: manager / customer
- Task assignment with notifications
- Filtering & searching tasks
- Pagination support
- Real-time notifications via **Pusher**

---

## Prerequisites

- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Pusher account (for notifications)

---

## Installation

 Clone the repo: https://github.com/ArtakKspoyan1990/back-task-scheduling.git

```bash
git clone <backend-repo-url> backend
cd backend
```


 Install dependencies:

```bash
composer install
```
 Copy .env.example to .env
 
 ```bash
cp .env.example .env
 ```
 
 Set your environment variables in .env
    
```bash
APP_NAME=TaskScheduler
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

BROADCAST_DRIVER=pusher
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=

QUEUE_CONNECTION=sync
```

 Generate app key

 ```bash
php artisan key:generate
 ```
 
 Run migrations and seeders
 
  ```bash
 php artisan migrate --seed
  ```
  
## Running the Backend

  ```bash
 php artisan serve
  ```
  The API will run at: http://localhost:8000
  
  
  ## If you want run in Docker
  
  Start Docker containers
```bash
docker-compose up -d
 ```
 
 Enter the app container to run migrations and seeders
 
 ```bash
docker exec -it task_app bash
php artisan migrate --seed
  ```
  
  The backend API is accessible at: http://localhost:8000/api
 
 