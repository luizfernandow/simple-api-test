#!make
.PHONY : build rebuild start stop php

DIR = docker

help:
	@echo ""
	@echo "usage: make COMMAND"
	@echo ""
	@echo "Commands:"
	@echo "  build        Build images"
	@echo "  rebuild      Rebuild images with no cache"
	@echo "  start        Create and start containers"
	@echo "  stop         Stop all services"
	@echo "  php          Open php container"

build:
	@cd $(DIR) && docker-compose build

rebuild:
	@cd $(DIR) && docker-compose build --no-cache

start:
	@cd $(DIR) && docker-compose up -d

stop:
	@cd $(DIR) && docker-compose down -v

php:
	@cd $(DIR) && docker exec -it $(shell cd $(DIR) && docker-compose ps -q php) bash