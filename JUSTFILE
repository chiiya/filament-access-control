set dotenv-load := false

# Lint files
@lint:
	./vendor/bin/ecs check --fix
	./vendor/bin/php-cs-fixer fix
	./vendor/bin/rector process
	./vendor/bin/tlint lint
