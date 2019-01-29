# Coding Style

.DEFAULT_GOAL := help

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
##
## Project setup
##---------------------------------------------------------------------------
cs: ## check cs problem
	./vendor/bin/php-cs-fixer fix --dry-run --stop-on-violation --diff

cs-fix: ## fix problems
	./vendor/bin/php-cs-fixer fix

cs-ci:
	./vendor/bin/php-cs-fixer fix src/ --dry-run --using-cache=no --verbose

##
## database creation
##---------------------------------------------------------------------------
db-reset: ## Drop and recreate database
	./bin/console doctrine:database:drop --force --if-exists
	./bin/console doctrine:database:create


db-test-reset: ## Drop and recreate test database
	./bin/console doctrine:database:drop --force --if-exists --env=test
	./bin/console doctrine:database:create --env=test

db-dev-create: ## make migrations and add fixtures
	./bin/console doctrine:migrations:migrate -n
	./bin/console doctrine:fixtures:load -n

db-test-dev-create: ## make migrations and add fixtures
	./bin/console doc:sch:up --force --env=test
	./bin/console doctrine:fixtures:load -n --env=test

db-recreate: ## Reset and recreate database with migrations and fixtures
db-recreate: db-reset db-dev-create

db-test-recreate: ## Reset and recreate database with migrations and fixtures
db-test-recreate: db-test-reset db-test-dev-create

db-fixtures: ## Load fixtures into database
	./bin/console doctrine:fixtures:load

phpunit:
	./bin/phpunit

exec-phpunit: db-test-recreate phpunit
