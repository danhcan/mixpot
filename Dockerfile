FROM php:8.2-cli-alpine

RUN apk add --no-cache \
    nginx \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    libxml2-dev \
    sqlite-dev \
    sqlite-libs \
    bash \
    curl \
    git \
    unzip \
    zip \
    icu-dev \
    linux-headers \
    $PHPIZE_DEPS \
  && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
  && docker-php-ext-install -j$(nproc) \
    bcmath \
    exif \
    gd \
    intl \
    mbstring \
    pcntl \
    pdo_sqlite \
    zip \
    opcache \
    sockets \
    xml \
    xmlrpc \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && apk del $PHPIZE_DEPS \
  && rm -rf /tmp/pear

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY . .

RUN composer dump-autoload --optimize \
  && php artisan config:cache \
  && php artisan route:cache \
  && php artisan view:cache \
  && mkdir -p storage/framework/{cache,sessions,views} \
  && mkdir -p storage/logs \
  && mkdir -p bootstrap/cache \
  && chmod -R 775 storage bootstrap/cache

COPY nginx.conf /etc/nginx/http.d/default.conf

RUN touch /var/log/nginx/access.log /var/log/nginx/error.log

RUN addgroup -g 1000 appuser \
  && adduser -u 1000 -G appuser -D appuser \
  && chown -R appuser:appuser /app /var/log/nginx /var/lib/nginx

USER appuser

EXPOSE 8080

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
