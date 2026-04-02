# Explain Hub

Explain Hub is a Questions and Answers (Q&A) platform built on the Laravel Lumen framework. Users can register, ask questions, provide answers, and administrators can manage users, questions, and answers.

## Requirements

- PHP 8.1 or higher
- Composer
- PostgreSQL
- (Optional) Docker for containerization

## Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd explain-hub
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy the environment file and configure it:
   ```bash
   cp .env.example .env
   ```
   Configure the database parameters in `.env`:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=explain_hub
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. (Optional) Run seeders for test data:
   ```bash
   php artisan db:seed
   ```

## Running

### Locally
```bash
php -S localhost:8000 -t public
```

### Via Docker
The project includes Docker configuration. Use `docker-compose` to run:
```bash
docker-compose up -d
```

## Project Structure

- `app/` - Main application code (controllers, models, providers)
- `packages/` - Modular packages:
  - `admin/` - Admin panel for management
  - `questions/` - Questions and answers logic
  - `users/` - Authentication and user profiles
- `database/` - Migrations, factories, seeders
- `public/` - Public files (CSS, JS, index.php)
- `resources/views/` - Blade templates
- `routes/` - Routes
- `tests/` - Tests

## Main Routes

### Public
- `GET /` - Home page
- `GET /login` - Login form
- `POST /login` - Login
- `GET /register` - Registration form
- `POST /register` - Registration
- `GET /logout` - Logout

### Protected (require authentication)
- `GET /profile` - User profile

### Admin Panel (require admin role)
- `GET /admin` - Dashboard
- `GET /admin/users` - User management
- `POST /admin/users/{id}/ban` - Ban user
- `POST /admin/users/{id}/unban` - Unban user
- `GET /admin/users/{id}/edit` - Edit user
- `POST /admin/users/{id}/update` - Update user
- `GET /admin/questions` - Question management
- `POST /admin/questions/{id}/delete` - Delete question
- `GET /admin/answers` - Answer management
- `POST /admin/answers/{id}/delete` - Delete answer

## Testing

Run tests with PHPUnit:
```bash
./vendor/bin/phpunit
```

## Security

- Uses Eloquent ORM for SQL injection protection.
- CSRF protection on forms.
- Rate limiting on login.
- Middleware for role checking.