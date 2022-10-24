install:
	composer install

validate:
	composer validate

test:
	composer test

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src public tests

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 src public tests

serve:
	composer serve