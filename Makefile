.PHONY: help build up down restart logs init install migrate seed migrate-fresh queue shell test

help:
	@echo "Dictionary - Laravel API + Android"
	@echo ""
	@echo "Backend (Docker):"
	@echo "  make build         - Build Docker images"
	@echo "  make up            - Start containers"
	@echo "  make down          - Stop containers"
	@echo "  make restart       - Restart containers"
	@echo "  make logs          - Tail logs"
	@echo ""
	@echo "  make init          - First-time setup (.env, build, up, key, migrate, seed)"
	@echo "  make install       - Composer install"
	@echo "  make migrate       - Run migrations"
	@echo "  make seed          - Run seeders"
	@echo "  make migrate-fresh - Fresh migrate + seed"
	@echo "  make queue         - Run queue worker inside app container"
	@echo ""
	@echo "  make shell         - Shell into app container"
	@echo "  make test          - Run PHPUnit"

build:
	cd api && docker compose build

up:
	cd api && docker compose up -d

down:
	cd api && docker compose down

restart: down up

logs:
	cd api && docker compose logs -f

init:
	@if [ ! -f api/.env ]; then cp api/.env.docker.example api/.env && echo "Created api/.env"; fi
	cd api && docker compose build
	cd api && docker compose up -d
	cd api && docker compose exec app sh -c "\
		composer install --no-interaction; \
		php artisan key:generate --force; \
		php artisan migrate --force; \
		php artisan db:seed --force"
	@echo "Done! Open http://localhost:8000"

install:
	cd api && docker compose exec app composer install --no-interaction

migrate:
	cd api && docker compose exec app php artisan migrate --force

seed:
	cd api && docker compose exec app php artisan db:seed --force

migrate-fresh:
	cd api && docker compose exec app php artisan migrate:fresh --force && docker compose exec app php artisan db:seed --force

queue:
	cd api && docker compose exec app php artisan queue:work redis --sleep=3 --tries=3

shell:
	cd api && docker compose exec app sh

test:
	cd api && docker compose exec app php artisan test