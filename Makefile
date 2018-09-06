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
