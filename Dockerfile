FROM php:8.3-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY composer.* ./

WORKDIR /app

COPY . /app/

RUN apt-get update && apt upgrade
RUN apt-get install -y libpq-dev libgmp-dev

RUN docker-php-ext-install pdo_pgsql pgsql 
RUN docker-php-ext-enable pdo_pgsql pgsql

RUN composer install --no-ansi --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader; \
    composer clearcache

CMD php artisan serve