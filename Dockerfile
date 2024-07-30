FROM unit:1.32.1-php8.3

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY composer.* ./

WORKDIR /app

COPY . .
COPY nginx-unit/docker-entrypoint.sh /usr/local/bin/
COPY nginx-unit/config.json /docker-entrypoint.d/

RUN apt update && apt upgrade -y
RUN apt install -y libpq-dev libgmp-dev

RUN docker-php-ext-install pdo_pgsql pgsql
RUN docker-php-ext-enable pdo_pgsql pgsql

RUN composer install --no-ansi --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader; \
    composer clearcache
