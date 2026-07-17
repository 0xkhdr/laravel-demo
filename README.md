# Todo App

A minimal yet complete todo web application with full CRUD operations, filtering, persistence, and intuitive UI.

## Features

- Create, read, update, and delete tasks
- Filter tasks by status (todo, in-progress, done)
- Responsive web interface for mobile, tablet, and desktop
- RESTful JSON API
- Persistent storage with MySQL/SQLite
- Real-time UI updates without page reloads

## Tech Stack

- **Backend**: Laravel 11 (PHP framework)
- **Frontend**: HTML5 + CSS3 + Vanilla JavaScript
- **Database**: MySQL (configurable to SQLite for development)
- **Web Server**: Laravel built-in dev server or Nginx/Apache

## Installation

### Prerequisites

- PHP 8.3+
- Composer
- Docker & Docker Compose (optional, for containerized setup)
- MySQL 8.0+ or SQLite

### Setup Steps

1. **Clone the repository**
   ```bash
   cd laravel-demo
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   ```
   
   Edit `.env` and set:
   - `APP_KEY` (should be auto-generated if not present)
   - `DB_CONNECTION` (mysql or sqlite)
   - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` (for MySQL)

   Generate APP_KEY if needed:
   ```bash
   php artisan key:generate
   ```

4. **Create database** (MySQL only)
   ```bash
   mysql -u root -p -e "CREATE DATABASE laravel;"
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed sample data**
   ```bash
   php artisan db:seed
   ```
   or
   ```bash
   php artisan migrate:fresh --seed
   ```

## Running the Application

### Development Server

Start the built-in development server:

```bash
php artisan serve
```

Server will run on `http://localhost:8000`

### With Docker

Start all services using docker-compose:

```bash
docker-compose up -d
```

Access the application at `http://localhost`

## API Endpoints

### List all tasks
```bash
GET /api/tasks
GET /api/tasks?status=todo
```

Response:
```json
{
  "data": [
    {
      "id": 1,
      "title": "Buy groceries",
      "description": "Milk, eggs, bread",
      "status": "todo",
      "created_at": "2026-07-17T10:30:00Z",
      "updated_at": "2026-07-17T10:30:00Z"
    }
  ]
}
```

### Create task
```bash
POST /api/tasks
```

Request:
```json
{
  "title": "Buy groceries",
  "description": "Milk, eggs, bread",
  "status": "todo"
}
```

Response (201 Created):
```json
{
  "id": 1,
  "title": "Buy groceries",
  "description": "Milk, eggs, bread",
  "status": "todo",
  "created_at": "2026-07-17T10:30:00Z",
  "updated_at": "2026-07-17T10:30:00Z"
}
```

### Get single task
```bash
GET /api/tasks/{id}
```

### Update task
```bash
PUT /api/tasks/{id}
```

Request:
```json
{
  "title": "Updated title",
  "status": "done"
}
```

Response (200 OK):
```json
{
  "id": 1,
  "title": "Updated title",
  "description": "Milk, eggs, bread",
  "status": "done",
  "created_at": "2026-07-17T10:30:00Z",
  "updated_at": "2026-07-17T11:45:00Z"
}
```

### Delete task
```bash
DELETE /api/tasks/{id}
```

Response (204 No Content)

## Testing

Run all tests:
```bash
php artisan test
```

Run only API tests:
```bash
php artisan test tests/Feature/TaskApiTest.php
```

Run with coverage:
```bash
php artisan test --coverage
```

Test coverage includes:
- CRUD operations (create, read, update, delete)
- Validation (required fields, max lengths, valid statuses)
- Error handling (not found, validation errors)
- Edge cases (null descriptions, concurrent updates, soft deletes)

## Database Schema

### tasks table
- `id` - Primary key (bigint)
- `title` - Task title (string, 255 chars, required)
- `description` - Task description (text, optional)
- `status` - Task status (enum: 'todo', 'in-progress', 'done', default: 'todo')
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp
- `deleted_at` - Soft delete timestamp (nullable)

## Environment Configuration

### Required environment variables:

```
APP_NAME="Laravel Demo"
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:...
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

### Optional:

```
DB_EXTERNAL_PORT=3307  # For docker-compose
```

## Deployment

### Production Setup

1. Set environment variables:
   ```
   APP_ENV=production
   APP_DEBUG=false
   ```

2. Install composer dependencies with production flag:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. Cache configuration:
   ```bash
   php artisan config:cache
   php artisan route:cache
   ```

4. Optimize autoloader:
   ```bash
   composer dump-autoload --optimize
   ```

5. Set up web server (Nginx or Apache) pointing to `public/` directory

6. Ensure storage and bootstrap/cache directories are writable:
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

## Troubleshooting

### Database connection issues

- Verify MySQL is running: `mysql -u root -p`
- Check `.env` database credentials
- Ensure database user has proper permissions
- For Docker: `docker-compose logs mysql`

### Permission errors

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Cache issues

Clear caches:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Migrations not running

```bash
php artisan migrate:reset
php artisan migrate
```

## Development

### Adding new tasks

1. Create migration: `php artisan make:migration add_field_to_tasks_table`
2. Create model method/scope as needed
3. Add tests in `tests/Feature/TaskApiTest.php`
4. Run tests: `php artisan test`

### Code style

Follow PSR-12 standard. Check code with:
```bash
php artisan lint
```

## License

MIT
