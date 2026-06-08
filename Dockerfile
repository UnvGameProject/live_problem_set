# Stage 1: Node.js build environment
FROM node:20 AS vite-builder

WORKDIR /var/www/html
COPY package*.json ./

# Clean install deps
RUN npm ci

COPY . .

# Make entrypoint available and executable in this stage
RUN chmod +x docker-entrypoint.sh

# Build frontend assets
RUN npm run build

# Stage 2: PHP environment
FROM php:8.3-fpm

WORKDIR /var/www/html

# Install PHP deps + Redis + PostgreSQL support
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev curl libssl-dev sudo \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libpq-dev postgresql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo pdo_mysql pdo_pgsql pcntl gd sockets \
    && pecl install redis && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Non-root phpuser matching host UID/GID for WSL2 bind mounts
ARG UID=1000
ARG GID=1000
RUN groupadd -g ${GID} phpuser && \
    useradd -u ${UID} -g phpuser -m phpuser && \
    echo "phpuser ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers && \
    mkdir -p /var/www/html/storage/framework/{sessions,views,cache} && \
    mkdir -p /var/www/html/bootstrap/cache && \
    chown -R phpuser:phpuser /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Laravel project + prebuilt Vite assets
COPY --from=vite-builder /var/www/html/public/build ./public/build
COPY . .

# Entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

USER phpuser

CMD ["php-fpm"]
