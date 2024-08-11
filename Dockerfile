FROM unit:1.32.1-php8.3

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY composer.* ./

WORKDIR /app

COPY . .
COPY nginx-unit/docker-entrypoint.sh /usr/local/bin/
COPY nginx-unit/config.json /docker-entrypoint.d/

RUN apt update && apt upgrade -y
RUN apt install -y libpq-dev libgmp-dev zip unzip gpg

RUN curl -s https://ngrok-agent.s3.amazonaws.com/ngrok.asc | \
gpg --dearmor -o ../etc/apt/keyrings/ngrok.gpg && \
echo "deb [signed-by=/etc/apt/keyrings/ngrok.gpg] https://ngrok-agent.s3.amazonaws.com buster main" | \
tee /etc/apt/sources.list.d/ngrok.list && \
apt update && apt install ngrok


RUN docker-php-ext-install pdo_pgsql pgsql
RUN docker-php-ext-enable pdo_pgsql pgsql

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-ansi --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader

CMD ./start.sh
