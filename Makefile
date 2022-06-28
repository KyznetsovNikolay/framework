##################
# Variables
##################

APP_CONTAINER = app
DOCKER_COMPOSE = docker-compose -f ./docker/docker-compose.yml
DOCKER_COMPOSE_PHP_FPM_EXEC = ${DOCKER_COMPOSE} exec -u www-data php-fpm

##################
# Docker compose
##################

dc_build:
	${DOCKER_COMPOSE} build

dc_start:
	${DOCKER_COMPOSE} start

dc_stop:
	${DOCKER_COMPOSE} stop

dc_up:
	${DOCKER_COMPOSE} up -d --remove-orphans

dc_ps:
	${DOCKER_COMPOSE} ps

dc_logs:
	${DOCKER_COMPOSE} logs -f

dc_down:
	${DOCKER_COMPOSE} down -v --remove-orphans


##################
# App
##################

app_bash:
	${DOCKER_COMPOSE} exec ${APP_CONTAINER} bash

app_run:
	${DOCKER_COMPOSE} exec ${APP_CONTAINER} php public/index.php

##################
# Tests
##################

tests_run:
	${DOCKER_COMPOSE} exec ${APP_CONTAINER} vendor/bin/phpunit