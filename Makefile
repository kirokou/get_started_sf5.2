sc := symfony console

## Stan Analyse
analyse:
	vendor/bin/phpstan analyse

## PHP unit test
run_test:
	vendor/bin/phpunit

## PHP unit test
new_test:
	symfony console make:unit-test

## start server
server:
	symfony serve

## stop server
server-stop:
	symfony server:stop

## Open Local
sol:
	symfony open:local

## make Controller
controller:
	$(sc) make:controller

## make Entity
entity:
	$(sc) make:entity

## make database
database:
	$(sc) doctrine:database:create

## make migration
migration:
	$(sc) make:migration
	$(sc) doctrine:migrations:migrate --no-interaction

## make schema update
schema-update:
	$(sc) d:s:u -f

## make cache clear
cache:
	$(sc) cache:clear
	$(sc) cache:warmup

## fixture load
fixture-load:
	$(sc) doctrine:fixtures:load --append

## make translation file
translation:
	$(sc) translation:update fr --force --domain=messages

## make user
user:
	$(sc) make:user

## make Authentification
auth:
	$(sc) make:auth