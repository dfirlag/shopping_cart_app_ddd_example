NAME = shopping_cart_application
VERSION = 0.05

.PHONY: build
build:
	docker build . -t $(NAME):$(VERSION) --rm
	docker tag $(NAME):$(VERSION) $(NAME):latest

.PHONY: install
install:
	docker-compose up -d
	docker exec -i shopping_cart_application_php_1 bash -c '/var/www/html/install.sh'
	docker-compose down