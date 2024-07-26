FROM php:8.3-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY composer.* ./

WORKDIR /app

COPY . /app/

RUN docker-php-ext-install pdo pdo_pgsql pgsql openssl bcmath curl json mbstring tokenizer xml
RUN docker-php-ext-enable pdo pdo_pgsql pgsql openssl bcmath curl json mbstring tokenizer xml

RUN composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader; \
    composer clearcache

CMD php artisan serve