SHELL = /bin/sh

# Run the given command as the web user.  This means any files that are created
# will be owned by that user, and avoids the issue where cache files are owned
# by the root user and cannot be later overwritten by the web user.
WEB_USER = www-data
define runas_webuser
	su $(WEB_USER) -s /bin/bash -c '$(1)'
endef

install: install_deps remove_cache remove_sessions create_db load_fixtures remove_logs

release: install_deps remove_cache remove_logs remove_sessions package

# Have to remove the cache or entity changes cause the tests to fail
tests: remove_cache unit_tests code_sniffer

# Put the latest fixture data into the DB but wipe it first so all the IDs
# start from 1 again.
# The cache is removed first to ensure any updated parameters.yml is used.
reset_db: remove_cache drop_db create_db load_fixtures

remove_cache:
		@echo ""
		@echo "Removing cache"
		@rm -rf var/cache/*
		@chown -R $(WEB_USER) var/cache var/sessions var/logs
		@chmod -R u+rwx var/cache var/sessions var/logs

remove_logs:
		@echo ""
		@echo "Removing logs"
		@rm -rf var/logs/* /logs/*

remove_sessions:
		@echo ""
		@echo "Removing sessions"
		@rm -rf var/sessions/*

install_deps:
		@echo ""
		@echo "Installing dependencies and running Composer post-install scripts"
		@composer install --no-progress --optimize-autoloader --prefer-dist

ctags:
		@ctags -R -o .tags src/

create_db:
		@echo ""
		@echo "Creating the database"
		@$(call runas_webuser, php bin/console doctrine:schema:update --force)

drop_db:
		@echo ""
		@echo "Dropping the database"
		@$(call runas_webuser, php bin/console doctrine:schema:drop --force)

load_fixtures:
		@echo ""
		@echo "Loading database fixtures"
		@$(call runas_webuser, php bin/console doctrine:fixtures:load -q)


package:
		@echo ""
		@echo "Creating deployment package"
		@zip -r -q application.zip ./ -x *.git*

code_sniffer:
		@echo ""
		@echo "Running PHP code sniffer"
		@php vendor/bin/phpcs --standard=Symfony src tests
		@echo "Code sniffer end"

# Allow optional FILTER param to only run some tests.
# Example: "make tests FILTER=MyTestClass"
TEST_FILTER_PARAM := $(if $(FILTER),--filter $(FILTER),)

unit_tests:
		@echo ""
		@echo "Running PHP unit"
		@$(call runas_webuser, php vendor/bin/phpunit $(TEST_FILTER_PARAM))
		@echo "Unit tests end"
