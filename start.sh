#!/bin/sh
./artisan migrate --force &&
./artisan app:setup-ngrok-webhook &&
unitd --no-daemon --control unix:/var/run/control.unit.sock
