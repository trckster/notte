# About

Telegram notifications via HTTP.

# Development

In order to run the project, you should follow these steps:

1. Install & run ngrok: `ngrok http 8000`
2. Fill environment variables:
    - `cp .env.example .env`
    - Generate bot token via [@BotFather](https://t.me/botfather) and set `TELEGRAM_BOT_TOKEN` variable
    - Copy url from ngrok and set `APP_URL`
3. Launch project: `docker compose up --build`
