# Backend challenge

## First steps - Installation

This project only has one POST endpoint that can be reached on `api/v1/transactions`;

To run this project follow these steps;
 - `git clone git@github.com:cmontezano/desafio-backend.git`;
 - Run `make` to create environment file, build docker-compose containers, up containers, install composer dependencies and generate laravel app key.
 - To run feature tests: `make test`;
 - If you want to seed the database you can run: `docker-compose exec app php artisan db:seed`

At this point the `POST transaction` endpoint is ready to be reached.

