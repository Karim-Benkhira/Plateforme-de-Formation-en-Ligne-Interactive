#!/bin/bash

# Make script executable
chmod +x docker-setup.sh

# Create necessary directories
mkdir -p docker/nginx/conf.d
mkdir -p docker/php

# Copy .env.example to .env if it doesn't exist
if [ ! -f .env ]; then
    cp .env.example .env
    echo ".env file created from .env.example"
fi

# Build and start Docker containers
docker-compose up -d

# Install Composer dependencies
docker-compose exec app composer install

# Generate application key
docker-compose exec app php artisan key:generate

# Run migrations
docker-compose exec app php artisan migrate

# Run seeders
docker-compose exec app php artisan db:seed

# Create storage link
docker-compose exec app php artisan storage:link

# Set permissions
docker-compose exec app chmod -R 775 storage bootstrap/cache

# Install and build frontend assets
docker-compose exec app npm install
docker-compose exec app npm run build

echo "Setup completed! Your application is running at http://localhost:8000"
echo "phpMyAdmin is available at http://localhost:8080"
