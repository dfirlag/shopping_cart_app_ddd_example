NAME = shopping_cart_application
VERSION = 0.05

.PHONY: build
build:
	docker build . -t $(NAME):$(VERSION) --rm
	docker tag $(NAME):$(VERSION) $(NAME):latest

.PHONY: start-server
start-server:
	docker-compose up -d

.PHONY: install
install:
	docker exec -i shopping_cart_application_php_1 bash -c '/var/www/html/install.sh'

.PHONY: test
test:
	docker exec -i shopping_cart_application_php_1 bash -c '/var/www/html/vendor/phpunit/phpunit/phpunit --configuration /var/www/html/phpunit.xml.dist /var/www/html/tests'