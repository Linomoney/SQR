#!/bin/sh
set -e

echo "=== Starting Saung Quran (SQR) Container ==="

# Link public storage directory if not linked
if [ ! -d "/var/www/public/storage" ]; then
    echo "Creating storage link..."
    php artisan storage:link || true
fi

# Clear any cached config/route/view to read fresh environment variables
echo "Clearing application caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Execute database migrations automatically if DB credentials or URL are present
if [ -n "$DB_HOST" ] || [ -n "$DATABASE_URL" ]; then
    echo "Running database migrations on Supabase PostgreSQL..."
    php artisan migrate --force || true
fi

echo "Starting server on port ${PORT:-10000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
