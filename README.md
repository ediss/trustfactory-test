# TrustFactory Shop - E-Commerce Shopping Cart

A simple e-commerce shopping cart system built with Laravel, Livewire, and Tailwind CSS.

## Features

- **Product Browsing**: View products with search functionality
- **Shopping Cart**: Add, update, and remove items from cart
- **User Authentication**: Built with Laravel Breeze (Livewire stack)
- **Checkout**: Complete orders with stock validation
- **Low Stock Notifications**: Automated email alerts when products are running low
- **Daily Sales Reports**: Scheduled job sends daily sales summary to admin

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Livewire 4
- **Styling**: Tailwind CSS
- **Database**: MariaDB (Docker) / SQLite (local)
- **Queue**: Database driver
- **Mail Testing**: MailHog

## Prerequisites

- Docker & Docker Compose
- Git

## Installation with Docker

1. Clone the repository:
```bash
git clone <repository-url>
cd trustFactory
```

2. Copy environment file:
```bash
cp .env.example .env
```

3. Update `.env` for Docker (MariaDB):
```env
DB_CONNECTION=mysql
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=trustfactory
DB_USERNAME=user
DB_PASSWORD=secret

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
```

4. Start Docker containers:
```bash
docker-compose up -d --build
```

5. Install PHP dependencies:
```bash
docker-compose run --rm composer install
```

6. Generate application key:
```bash
docker-compose run --rm artisan key:generate
```

7. Run migrations and seeders:
```bash
docker-compose run --rm artisan migrate --seed
```

8. Install Node dependencies and build assets:
```bash
docker-compose run --rm npm install
docker-compose run --rm npm run build
```

9. For development with hot reload:
```bash
docker-compose run --rm --service-ports npm run dev
```

The application will be available at: **http://localhost:8000**

## Docker Services

| Service   | Port  | Description              |
|-----------|-------|--------------------------|
| app       | 8000  | Nginx web server         |
| mariadb   | 3306  | MariaDB database         |
| php       | 9010  | PHP-FPM                  |
| mailhog   | 8025  | MailHog web interface    |
| mailhog   | 1025  | MailHog SMTP             |
| npm       | 5173  | Vite dev server          |

## Docker Commands

```bash
# Start all services
docker-compose up -d

# Stop all services
docker-compose down

# Run artisan commands
docker-compose run --rm artisan <command>

# Run composer commands
docker-compose run --rm composer <command>

# Run npm commands
docker-compose run --rm npm <command>

# View logs
docker-compose logs -f app

# Access PHP container shell
docker-compose exec php sh
```

## Local Installation (Without Docker)

1. Clone the repository:
```bash
git clone <repository-url>
cd trustFactory
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node dependencies:
```bash
npm install
```

4. Copy environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Create SQLite database:
```bash
touch database/database.sqlite
```

7. Run migrations and seeders:
```bash
php artisan migrate --seed
```

8. Build assets:
```bash
npm run build
```

9. Start the development server:
```bash
php artisan serve
```

## Default Users

After seeding, the following users are available:

| Role  | Email              | Password  |
|-------|-------------------|-----------|
| Admin | admin@example.com | password  |
| User  | user@example.com  | password  |

## Queue Worker

For the low stock notifications to work, run the queue worker:

```bash
# Docker
docker-compose run --rm artisan queue:work

# Local
php artisan queue:work
```

## Scheduled Tasks

The daily sales report runs at 6:00 PM daily. To enable the scheduler:

**Docker:**
```bash
docker-compose run --rm artisan schedule:work
```

**Local (cron entry):**
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## Project Structure

### Models
- `User` - User authentication with admin flag
- `Product` - Product catalog with stock management
- `Cart` - Shopping cart per user
- `CartItem` - Items in cart with quantities
- `Order` - Completed orders
- `OrderItem` - Items in completed orders

### Livewire Components
- `ProductList` - Product browsing with search and add-to-cart
- `CartView` - Shopping cart management
- `CartIcon` - Navigation cart indicator
- `Checkout` - Order completion

### Jobs
- `CheckLowStockJob` - Sends email when product stock is low
- `SendDailySalesReportJob` - Daily sales summary email

### Mail
- `LowStockNotification` - Low stock alert email
- `DailySalesReport` - Daily sales summary email

## Testing

Run the test suite:
```bash
# Docker
docker-compose run --rm artisan test

# Local
php artisan test
```

## MailHog

MailHog captures all outgoing emails for testing. Access the web interface at:
**http://localhost:8025**

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
