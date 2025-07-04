FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    libicu-dev \
    python3 \
    python3-pip \
    python3-dev \
    cmake \
    libopenblas-dev \
    liblapack-dev \
    libx11-dev \
    libgtk-3-dev \
    libboost-python-dev \
    libdlib-dev \
    libopencv-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copy custom PHP configuration
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Copy application files
COPY . /var/www

# Set permissions
RUN chown -R $user:$user /var/www
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Switch to non-root user
USER $user

# Install dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN npm install && npm run build

# Install Python face recognition dependencies
RUN pip3 install --break-system-packages \
    opencv-python-headless \
    face-recognition \
    numpy \
    Pillow

# Expose port 9000 for PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
