help: ## Show this help
	@printf "\033[33m%s:\033[0m\n" 'Available commands'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[32m%-14s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## build the application
	make restart
	make composer_install
	make migrate

up: ## Up containers
	docker-compose up -d --build

down: ## Down containers
	docker-compose down

restart: ## Restart containers
	make down
	make up

connect_app: ## Run shell in php container 
	docker-compose exec -u www-data php sh

composer_install: ## Install php dependencies
	docker-compose exec -u www-data php composer install

migrate: ## Up database migrations
	docker-compose exec -u www-data php bin/console d:m:m --no-interaction

app_scoring_calculate: ## run Calculate scoring command
	docker-compose exec -u www-data php bin/console app:scoring:calculate $(ARGS)

load_fixtures: ## Load application fixtures
	docker-compose exec -u www-data php bin/console d:f:l

test: ## Run project tests 
	docker-compose exec -u www-data php bin/phpunit
