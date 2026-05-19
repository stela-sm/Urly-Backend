# Urly 🔗 — Elegant & Lightweight URL Shortener

[![PHP Version](https://img.shields.io/badge/php-%3E%3D%208.3-8892BF.svg?style=flat-squared&logo=php)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/laravel-%5E13.8-FF2D20.svg?style=flat-squared&logo=laravel)](https://laravel.com/)
[![License](https://img.shields.io/badge/license-MIT-green.svg?style=flat-squared)](https://opensource.org/licenses/MIT)

**Urly** is a high-performance, minimalist URL shortening service built on **Laravel** and powered by **Hashids**. It provides a simple, clean, and highly secure REST API to generate non-sequential, YouTube-like shortcodes for long URLs and dynamically redirect clients to their destination.

---

## ✨ Features

- **⚡ Instant Redirection**: Fast 302 redirection matching shortcodes back to their original destination.
- **🛡️ Secure Shortcodes**: Generates shortcodes using **Hashids** with a customizable salt (`HASHIDS_SALT`) to keep IDs obfuscated and non-sequential.
- **📡 RESTful API**: Single endpoint to programmatically create short URLs via JSON payloads.
- **🏗️ Solid Architecture**: Adheres strictly to the Service layer pattern (`UrlsService`) and modern PHP 8 attributes in Eloquent models.
- **🗃️ Robust Persistence**: Pre-configured for relational databases (like PostgreSQL) to track and load entries efficiently.

---

## 🛠️ Tech Stack & Requirements

- **PHP**: `^8.3`
- **Framework**: `Laravel 13.x`
- **Database**: PostgreSQL (or any other relational database supported by Laravel)
- **Library**: `hashids/hashids (5.x)` for generating secure hashes.
- **Server Environment**: Laragon, Laravel Herd, XAMPP, or PHP CLI.

---

## 🚀 Installation & Local Setup

Follow these steps to set up Urly on your local machine:

### 1. Clone & Navigate
Navigate to your web directory (e.g., Laragon's `www` root or your standard workspace):
```bash
cd c:/laragon/www/urly
```

### 2. Install PHP Dependencies
Download the required Composer packages:
```bash
composer install
```

### 3. Environment Configuration
Copy the environment template file:
```bash
cp .env.example .env
```

Open `.env` and configure your environment variables:
- Set your database connection details (PostgreSQL, MySQL, etc.):
  ```ini
  DB_CONNECTION=pgsql
  DB_HOST=127.0.0.1
  DB_PORT=5432
  DB_DATABASE=urly
  DB_USERNAME=postgres
  DB_PASSWORD=your_password
  ```
- Define a secure, custom salt for the shortcode generator:
  ```ini
  HASHIDS_SALT=your_custom_secret_salt_here
  ```

### 4. Generate App Key & Migrate Database
Initialize your application and set up the schema:
```bash
php artisan key:generate
php artisan migrate
```

### 5. Run the Application
Start the Laravel development server:
```bash
php artisan serve
# OR run the full developer suite (Server + Queue listener + Assets)
composer run dev
```
The application will be accessible at [http://localhost:8000](http://localhost:8000).

---

## 💾 Database Schema

The core table `urls` is designed for lightning-fast lookups and keeps a minimal memory footprint:

| Column | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT` | Primary Key, Auto-increment | Unique record identifier (internal) |
| `shortcode` | `VARCHAR` | Unique Index | The obfuscated unique hash (e.g. `yL8aX`) |
| `url` | `VARCHAR` | Required | The long destination URL |
| `created_at` | `TIMESTAMP` | Default: Current Time | When the shortcode was created |

> [!NOTE]
> Database lookups on the `shortcode` column are incredibly fast due to the unique index. Eloquent attributes hide the internal sequential `id` from JSON outputs to preserve system obscurity.

---

## 📡 API Reference

### 1. Shorten a URL
Create a new shortcode for a long URL.

- **Endpoint**: `POST /api/shorten`
- **Content-Type**: `application/json`
- **Request Body**:
  ```json
  {
      "url": "https://laravel.com/docs/eloquent"
  }
  ```
- **Response (`200 OK`)**:
  ```json
  {
      "url": "https://laravel.com/docs/eloquent",
      "shortcode": "o1rM6X",
      "shortUrl": "http://localhost:8000/o1rM6X",
      "created_at": "2026-05-19 01:25:00"
  }
  ```

### 2. Follow Shortcode Redirect
Redirect a shortcode to the original URL destination.

- **Endpoint**: `GET /{shortcode}`
- **Example URL**: `http://localhost:8000/o1rM6X`
- **Response**: `302 Found` (redirects the browser automatically to the original `url`).

---

## 📁 Architecture Overview

```mermaid
graph TD
    Client[Client / Web Browser] -->|POST /api/shorten| ApiRoute[api.php]
    Client -->|GET /{shortcode}| WebRoute[web.php]
    
    ApiRoute -->|createShortUrl| Controller[UrlsController]
    WebRoute -->|getUrlByShortcode| Controller
    
    Controller -->|Calls service method| Service[UrlsService]
    Service -->|Uses Hashids Library| Hashids[Hashids Library]
    Service -->|Performs CRUD operations| Model[Urls Model]
    Model -->|Queries / Inserts| Database[(PostgreSQL DB)]
```

- **`App\Models\Urls`**: Clean model representing short URLs using modern declarative PHP 8 Eloquent attributes.
- **`App\Services\UrlsService`**: Centralized domain logic that manages URL searches and handles unique shortcode encoding using salt and dynamic random factors.
- **`App\Http\Controllers\UrlsController`**: Lightweight controller that coordinates HTTP requests/responses, validates API requests, and issues browser redirects.

---

## 📄 License

The Urly application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
