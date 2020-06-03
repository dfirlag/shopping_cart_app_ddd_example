composer install

php bin/console doctrine:database:create --env=test --no-interaction --if-not-exists
php bin/console doctrine:database:create --env=dev --no-interaction --if-not-exists

php bin/console doctrine:schema:update --env=test --force --no-interaction
php bin/console doctrine:schema:update --env=dev --force --no-interaction