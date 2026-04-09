FROM php:8.3-fpm

# 1. Install system dependencies + Node.js
# 1. Install system dependencies + Node.js
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        mbstring \
        zip \
        exif \
        pcntl \
        bcmath \
        dom \
        xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


# 2. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Set Composer environment variables
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_PROCESS_TIMEOUT=2000

# 4. Set working directory
WORKDIR /var/www/html

# 5. Optimization: Copy dependency files first
# We copy both PHP and Node dependency files to cache layers independently
COPY src/composer.json src/composer.lock* ./
COPY src/package.json src/package-lock.json* ./

# 6. Install PHP & Node dependencies
RUN composer install --prefer-dist --no-progress --no-interaction --no-scripts \
    && npm install

# 7. Copy the rest of the Laravel application
COPY src/ .

# 8. Compile Assets (Vite)
# This generates the public/build/manifest.json file you were missing
RUN npm run build

# 9. Ensure directories exist and set permissions
RUN mkdir -p storage/framework/cache/data \
             storage/framework/app/cache \
             storage/framework/sessions \
             storage/framework/views \
             bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Run Composer scripts
RUN composer run-script post-autoload-dump

EXPOSE 9000
CMD ["php-fpm"]