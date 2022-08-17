help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "⚡ \033[34m%-30s\033[0m %s\n", $$1, $$2}'

install: build run
test: build run test

build: ## Build Docker image for local development
	docker-compose build

start: run
run: ## Run application Docker. Run 'make build' first
	docker-compose up -d

status: ps
ps: ### Alias of docker-composer ps command
	docker-compose ps

restart: ## Restart containers
	docker-compose restart

test: ### Run unit testing
	docker-compose exec app sh -c "composer test"

stop: ## Stop application running in Docker
	docker-compose kill

destroy: ## Alias docker-compose down command
	docker-compose down
down: destroy

logs: ## View container logs
	docker-compose logs -ft app

shell: ## Enter bash in running Docker container
	docker-compose exec app sh

root: ## Enter bash in running Docker container as root user
	docker-compose exec --user root app sh
