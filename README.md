# Simple E-commerce Shopping Cart (Laravel + Livewire)

A small e-commerce shopping cart system built with **Laravel** and **Livewire** using **Laravel Breeze** authentication and **Tailwind CSS**.

Users can browse products, add them to a cart, update quantities, remove items, and checkout.  
The shopping cart is stored in the **database** and always associated with the **authenticated user** (no session/local storage).

---

## Tech Stack

- Backend: Laravel
- Frontend: Livewire (Laravel Breeze starter kit)
- Styling: Tailwind CSS
- Queue: Laravel Queues (database driver)
- Mail: Laravel Mail (configured to `log` by default)

---

## Features

### Core
- Product listing (name, price, stock quantity)
- Auth (Laravel Breeze)
- Cart per authenticated user (DB-backed)
- Add to cart / update quantity / remove item
- Checkout creates Orders + Order Items and reduces stock

### Background Jobs
- **Low stock notification**
  - After checkout reduces a product stock to at/below threshold, a queued Job sends an email to a dummy admin user.
  - Uses `low_stock_notified_at` to avoid spamming.

### Scheduled Task
- **Daily sales report**
  - Scheduled command sends a daily report of products sold to the dummy admin email.

---

## Data Model

- `products` (name, price_cents, stock_quantity, low_stock_threshold, low_stock_notified_at)
- `carts` (user_id unique)
- `cart_items` (cart_id, product_id, quantity)
- `orders` (user_id, status, total_cents, completed_at)
- `order_items` (order_id, product_id, quantity, unit_price_cents, line_total_cents)

---

## Requirements

- PHP 8.2+ (recommended)
- Composer
- Node.js + npm
- SQLite/MySQL/PostgreSQL (SQLite is easiest)

---

## Installation

### 1) Clone & install dependencies
```bash
git clone https://github.com/ahmedmfz/trustfactory-cart.git
cd trustfactory-cart

composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan queue:table
php artisan migrate --seed



``### 2)Run the app

php artisan serve

php artisan schedule:work

php artisan queue:work