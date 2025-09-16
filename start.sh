#!/bin/sh
./artisan migrate --force &&
./artisan app:setup-webhook &&
unitd --no-daemon --control unix:/var/run/control.unit.sock
