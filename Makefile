install:
	composer install

validate:
	composer validate

start-tests:
	./vendor/bin/phpunit tests

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src public tests

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 src public tests

serve:
	php -S localhost:8888 -t public