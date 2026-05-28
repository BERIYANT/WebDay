# Stage 1: Build Vite assets
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Run Laravel Application
FROM richarvey/nginx-php-fpm:3.1.6

# Set working directory
WORKDIR /var/www/html

# Copy all project files into the container
COPY . .

# Copy built Vite assets from Stage 1
COPY --from=node-builder /app/public/build ./public/build

# Install PHP dependencies
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Configure Image environments
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Production optimizations
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Set permissions for Laravel storage and cache directories
RUN chown -R nobody:nobody /var/www/html/storage /var/www/html/bootstrap/cache

# Run the standard start script
CMD ["/start.sh"]
