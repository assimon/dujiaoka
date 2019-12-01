test: remove-deps
	make test-laravel
	make test-lumen

test-laravel:
	composer require laravel/framework
	vendor/bin/phpunit
	make uninstall-laravel

test-lumen:
	composer require laravel/lumen-framework
	vendor/bin/phpunit
	make uninstall-lumen

remove-deps:
	rm -rf vendor

uninstall-laravel: remove-deps
	composer remove laravel/framework

uninstall-lumen: remove-deps
	composer remove laravel/lumen-framework