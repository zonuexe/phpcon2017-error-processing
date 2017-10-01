COMPOSER ?= composer

composer.lock: composer.json
	$(COMPOSER) install

vendor/autoload.php: composer.lock
	$(COMPOSER) install
