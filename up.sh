#!/bin/bash

echo "Running the compoaser install locally" && \
    composer install --working-dir=./app && \
    docker-compose up --build -d && \
    echo "Containers built, waiting for the db to be seeded, then opening browser. Be a bit patient please... (30seconds)" && \
    sleep 30 && \
    open http://localhost:8080