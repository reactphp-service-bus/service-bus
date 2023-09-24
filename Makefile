help:                                                                           ## shows this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_\-\.]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

install:                                                              			## install all dependencies for a development environment
	composer install

coding-standard-fix:                                                            ## apply automated coding standard fixes
	./vendor/bin/php-cs-fixer fix

coding-standard-check:                                                          ## check coding-standard compliance
	./vendor/bin/php-cs-fixer fix --dry-run --diff

static-analysis:                                                                ## run static analysis checks
	./vendor/bin/phpstan analyse

unit-tests:                                                                     ## run unit tests
	./vendor/bin/phpunit
