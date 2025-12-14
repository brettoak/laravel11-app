# Laravel App

A modern Laravel 11 application featuring a robust tech stack including Jetstream for authentication, Filament for the admin panel, and Reverb for real-time WebSocket capabilities.

## Features

- **Authentication & Security**: Built on [Laravel Jetstream](https://jetstream.laravel.com/) and [Sanctum](https://laravel.com/docs/sanctum).
- **Admin Panel**: Powered by [Filament v4](https://filamentphp.com/), including [Filament Shield](https://github.com/bezhanSalleh/filament-shield) for Role-Based Access Control (RBAC).
- **Real-Time Updates**: Integrated with [Laravel Reverb](https://reverb.laravel.com/) for WebSocket broadcasting.
- **Frontend**: Reactive UI components using [Livewire](https://livewire.laravel.com/) and [Alpine.js](https://alpinejs.dev/), styled with [Tailwind CSS](https://tailwindcss.com/).
- **Content Management**: Manage Articles and Comments directly from the admin dashboard.

## Prerequisites

Ensure you have the following installed:
- PHP 8.2+
- Composer
- Node.js & NPM
- Docker (optional, for database/Reverb)

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laravel11-app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   Copy the example environment file and configure your database settings:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Note: Ensure your database credentials in `.env` match your local setup.*

5. **Database Migration**
   Run migrations to set up the database schema:
   ```bash
   php artisan migrate
   ```

6. **Create Admin User**
   Create a user to access the Filament admin panel:
   ```bash
   php artisan make:filament-user
   ```

## Usage

### Development Server
Start the Laravel development server:
```bash
php artisan serve
```

### Frontend Assets
Compile assets in watch mode:
```bash
npm run dev
```

### Real-Time Server (Reverb)
Start the Reverb WebSocket server:
```bash
php artisan reverb:start
```

### Queue Worker
Process background jobs:
```bash
php artisan queue:listen
```

Access the application at `http://localhost:8000` and the admin panel at `http://localhost:8000/admin`.

## Testing

Run the test suite using PHPUnit / Pest:
```bash
php artisan test
```
