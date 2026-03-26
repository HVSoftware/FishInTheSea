.PHONY: run test lint

run:
	php FishService.php

run-days:
	php FishService.php $(DAYS)

test:
	@echo "No tests configured"

lint:
	php -l FishService.php
	php -l ConsoleLogger.php
	php -l LogInterface.php