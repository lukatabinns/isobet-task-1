# Getting started

* Clone the repo
* Create a .env file from .env.example
* If using Docker:
    * Use the Docker commands below to build, mount and SSH to your container
    * Remember to run terminal commands from within the container
* `composer install`
* `npm install`
* `php artisan key:generate`
* `php artisan migrate --seed`
* `npm run dev` or `npm run watch` for hot reloading of edited files

# Docker commands

Open a terminal in repo folder to execute these commands:

* First time build: `docker-compose build --no-cache`
* Mount container: `docker-compose up -d`
* SSH into the container: `docker exec -it nifty /bin/bash`

It's easier to start and stop the container in the Docker interface than to mount and unmount each time.

* Unmount container (if you need to): `docker-compose down`

If mounting `db` fails on Windows, run `chmod 044 .docker/mysql/my.cnf` or manually set `my.cnf` to read-only and try again.

# Notes

## Decimal places

* Benchmarking scores (12, 9) xxx.xxxxxxxx
 * Elements (11, 9) xx.xxxxxxxx
* Weightings that must be <= 1 (10, 9) x.xxxxxxxx
* Percentages (12, 9) xxx.xxxxxxxx
* Financial amounts (21, 9) xxx,xxx,xxx,xxx.xxxxxxxx
