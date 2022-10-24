install:
	composer install

validate:
	composer validate

start-tests:
	./vendor/bin/phpunit tests
