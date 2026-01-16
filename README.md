# T-Racks
T-Racks is a modern Racktables alternative.

## Requirements
- php
- Node.js
- pnpm

## Running locally
1. Install dependencies:
    ```bash
    pnpm install
    composer install
    ```
2. Copy `.env.example` to `.env` and adjust settings as needed.
3. Generate application key:
    ```bash
    php artisan key:generate
    ```
4. Run database migrations: 
    ```bash
    php artisan migrate
    ```
5. Start the development server:
    ```bash
    composer run dev
    ```