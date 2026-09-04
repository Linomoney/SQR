FROM php:8.3-cli

WORKDIR /var/www

# Install system dependencies, PostgreSQL driver extensions, and Node.js for Vite asset compilation
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    curl \
    nodejs \
    npm \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Copy Composer binary from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install PHP production dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Install Node dependencies and compile production assets via Vite
RUN npm install --ignore-scripts && npm run build

# Set permissions for storage/cache and make entrypoint executable
RUN chmod -R 775 storage bootstrap/cache \
    && chmod +x docker-entrypoint.sh

EXPOSE 10000

ENTRYPOINT ["/var/www/docker-entrypoint.sh"]