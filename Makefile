isDocker := $(shell docker info > /dev/null 2>&1 && echo 1)
user := $(shell id -u)
group := $(shell id -g)

sy := php bin/console
node :=
php :=
ifeq ($(isDocker), 1)
	ifneq ($(isProd), 1)
		dc := USER_ID=$(user) GROUP_ID=$(group) docker-compose -f docker-compose.yml
		de := docker-compose exec
		dr := $(dc) run --rm
		php := $(dr) --no-deps php
	endif
endif

.PHONY: build-docker
build-docker:
	$(dc) build php

.PHONY: dev
dev:
	$(dc) up

.PHONY: test
test:
	$(php) ./vendor/bin/phpunit --testdox tests
