# === Helper ===

# Styles
YELLOW=$(shell echo "\033[00;33m")
RED=$(shell echo "\033[00;31m")
RESTORE=$(shell echo "\033[0m")

# Variables
PHP_BIN := php
COMPOSER_BIN := composer.phar
DOCKER_BIN := docker
SRCS := src
CURRENT_DIR := $(shell pwd)
SCRIPS_DIR := $(CURRENT_DIR)/scripts

.DEFAULT_GOAL := help

.PHONY: help
help:
	@echo "******************************"
	@echo "${YELLOW}Available targets${RESTORE}:"
	@grep -E '^[a-zA-Z-]+:.*?## .*$$' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf " ${YELLOW}%-15s${RESTORE} > %s\n", $$1, $$2}'
	@echo "${RED}==============================${RESTORE}"

.PHONY: check
check: ## Run the codechecker
	bash $(SCRIPS_DIR)/codechecker.bash

.PHONY: build
build: ## Build the box locally (bypass the PROD)
	bash $(SCRIPS_DIR)/buildbox.bash

.PHONY: clean
clean: ## Removes the vendors, and caches
	rm -f .php_cs.cache composer.lock
	rm -rf vendor
