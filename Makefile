phpunit:
	docker compose run --rm php vendor/bin/phpunit tests/

phpstan:
	docker compose run --rm php vendor/bin/phpstan analyse

ecs:
	docker compose run --rm php vendor/bin/ecs --fix
