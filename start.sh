#!/usr/bin/env bash

PORT=${PORT:-10000}
echo "Starting PHP server on port $PORT"
php -S 0.0.0.0:$PORT -t .