#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'php' ] || [ "$1" = 'composer' ] || [ "$1" = 'bin/console' ]; then
    if [ "$APP_ENV" != 'prod' ]; then
        echo "Enabling development mode..."
        ln -sf "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

        echo "Enabling xdebug..."
        echo zend_extension="$(find / -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini
    fi
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'bin/console' ]; then
    if [ ! -d vendor ] || [ "$APP_ENV" != 'prod' ]; then
        echo "Installing vendor packages..."
        composer install --no-progress --no-suggest -n
    fi

    if [ ! -d "var/cache/$APP_ENV" ]; then
        echo "Preparing application cache..."
        bin/console cache:warmup
    fi

    echo "Waiting for db to be ready..."
    until bin/console doctrine:query:sql "SELECT 1" > /dev/null 2>&1; do
        sleep 1
    done

    if ls -A migrations/*.php > /dev/null 2>&1; then
        echo "Applying db migrations..."
        bin/console doctrine:migrations:migrate -n
    fi
fi

exec docker-php-entrypoint "$@"
