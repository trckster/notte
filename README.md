# About

Telegram notifications via HTTP.

# Development

In order to run the project, you should follow these steps

1. install ngrok, config ngrok and run the following command
    `ngrok http <port>`

2. fill up the .env file with appropriate values, set `DB_HOST=postgres` and set `TELEGRAM_WEBHOOK_URL` to url from ngrok with `/api/webhook` added

3. Run the `docker compose up` command 