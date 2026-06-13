.DEFAULT_GOAL := help

.PHONY: help setup up down build fresh migrate seed test lint shell logs \
        cache-clear optimize horizon-pause horizon-continue horizon-terminate

help: ## Show available commands
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort \
		| awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-22s\033[0m %s\n", $$1, $$2}'

setup: ## First-time setup: copy env, build images, start, install, migrate & seed
	@[ -f .env ] || cp .env.example .env
	docker compose build
	docker compose up -d
	@echo "Waiting for services to initialize..."
	@sleep 5
	docker compose exec app php artisan storage:link
	docker compose exec app php artisan db:seed
	@echo ""
	@echo "✓ Setup complete!"
	@echo "  App:     http://localhost:$$(grep -E '^APP_PORT' .env | cut -d= -f2 || echo 8080)"
	@echo "  Mailpit: http://localhost:$$(grep -E '^MAILPIT_UI_PORT' .env | cut -d= -f2 || echo 8025)"
	@echo "  Horizon: http://localhost:$$(grep -E '^APP_PORT' .env | cut -d= -f2 || echo 8080)/horizon"

up: ## Start all containers in background
	docker compose up -d

down: ## Stop and remove containers
	docker compose down

build: ## Rebuild Docker images
	docker compose build

fresh: ## Drop all tables, re-run migrations and seed
	docker compose exec app php artisan migrate:fresh --seed

migrate: ## Run pending migrations
	docker compose exec app php artisan migrate

seed: ## Run database seeders
	docker compose exec app php artisan db:seed

test: ## Run the full Pest test suite
	docker compose exec app php artisan test

lint: ## Fix code style with Laravel Pint
	docker compose exec app ./vendor/bin/pint

shell: ## Open interactive shell in the app container
	docker compose exec app sh

logs: ## Tail logs from all containers
	docker compose logs -f

cache-clear: ## Clear all Laravel caches
	docker compose exec app php artisan optimize:clear

optimize: ## Cache config, routes, and views (use for production)
	docker compose exec app php artisan optimize

horizon-pause: ## Pause all Horizon workers
	docker compose exec app php artisan horizon:pause

horizon-continue: ## Resume Horizon workers
	docker compose exec app php artisan horizon:continue

horizon-terminate: ## Gracefully terminate Horizon
	docker compose exec app php artisan horizon:terminate
