# Link.it - URL Shortener API

A Laravel-based URL shortening service that provides simple API endpoints to encode and decode links.

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL/SQLite

## Local Setup

1. Clone the repository
```bash
git clone <repository-url>
cd link.it
```

2. Install PHP dependencies
```bash
composer install
```

3. Set up environment file
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Configure your database in `.env` file
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run database migrations and seed default domains
```bash
php artisan migrate --seed
```

This will create 5 random test domains and set the first one as default. 

To add more domains or customize existing ones, you can use Laravel Tinker:

```bash
php artisan tinker
```

Then in the tinker console:
```php
// Create a new domain
\App\Models\Domain::create(['name' => 'your-domain.com']);

// List all domains
\App\Models\Domain::all();
```

7. Start the development server
```bash
php artisan serve
```

## API Documentation

### 1. Encode URL

Convert a long URL into a shortened link.

**Endpoint:** `POST /encode`

**Request Body:**
```json
{
    "url": "https://example.com/very/long/url",
    "domain": "optional-custom-domain.com"  // Optional
}
```

**Validation Rules:**
- `url`: Required, must be a valid URL
- `domain`: Optional, must exist in the domains table

**Response Example:**
```json
{
    "data": {
        "link": "https://volkman.com/NuPr6V",
        "url": "https://example.com/very/long/url",
        "expires_at": null
    }
}
```

### 2. Decode URL

Retrieve the original URL from a shortened link.

**Endpoint:** `POST /decode`

**Request Body:**
```json
{
    "link": "https://volkman.com/NuPr6V"
}
```

**Validation Rules:**
- `link`: Required, must exist in the links table

**Response Example:**
```json
{
    "data": {
        "link": "https://volkman.com/NuPr6V",
        "url": "https://example.com/very/long/url",
        "expires_at": null
    }
}
```

## Testing

Run the test suite using PEST:

```bash
php artisan test
```

## License

This project is open-sourced software licensed under the MIT license.
