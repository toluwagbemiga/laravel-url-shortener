# Laravel URL Shortener Backend

A Laravel-based URL shortener with both web interface (Blade templates) and API endpoints.

## Features

- URL shortening with custom short codes
- Click tracking and analytics
- Optional expiration dates
- SQLite database
- Web interface with Blade templates
- RESTful API endpoints
- CORS enabled for frontend integration

## Installation

1. Install dependencies:
```bash
composer install
```

2. Set up environment:
```bash
cp .env.example .env
php artisan key:generate
```

3. Run migrations:
```bash
php artisan migrate
```

4. Start the server:
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## API Endpoints

- `GET /api/v1/urls` - List all URLs
- `POST /api/v1/urls` - Create a new short URL
- `GET /api/v1/urls/{shortCode}` - Get URL details
- `GET /api/v1/urls/{shortCode}/stats` - Get URL statistics

## Web Routes

- `GET /` - Home page with URL list
- `GET /create` - Create new URL form
- `POST /urls` - Store new URL
- `GET /stats/{shortCode}` - URL statistics page
- `GET /{shortCode}` - Redirect to original URL

## Database Schema

The `urls` table contains:
- `id` - Primary key
- `original_url` - The original long URL
- `short_code` - The generated short code
- `clicks` - Number of times the URL was accessed
- `expires_at` - Optional expiration timestamp
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp