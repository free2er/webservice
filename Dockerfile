# the different stages of this Dockerfile are meant to be built into separate images
# https://docs.docker.com/develop/develop-images/multistage-build/#stop-at-a-specific-build-stage
# https://docs.docker.com/compose/compose-file/#target


# https://docs.docker.com/engine/reference/builder/#understand-how-arg-and-from-interact
ARG PHP_VERSION=7.3
ARG NGINX_VERSION=1.17

# "php" stage
FROM php:${PHP_VERSION}-fpm-alpine AS backend
WORKDIR /app

# persistent / runtime deps
RUN apk add --no-cache bash fcgi icu-dev libzip-dev $PHPIZE_DEPS
RUN docker-php-ext-install intl pdo_mysql zip
RUN pecl install apcu xdebug && docker-php-ext-enable apcu opcache

RUN ln -s $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
COPY docker/php.prod.ini /usr/local/etc/php/conf.d/application.ini
COPY docker/php-fpm.ini /usr/local/etc/php-fpm.d/application.conf

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer /usr/bin/composer /usr/bin/composer

# install Symfony Flex globally to speed up download of Composer packages (parallelized prefetching)
RUN composer global require "symfony/flex" --no-progress --no-suggest -a && composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"

# prevent the reinstallation of vendors at every changes in the source code
COPY composer.json composer.lock symfony.lock ./
RUN composer install --no-dev --no-scripts --no-progress --no-suggest -n -o && composer clear-cache

# copy only specifically what we need
COPY phpcs.xml.dist phpunit.xml.dist ./
COPY bin bin/
COPY config config/
COPY keys keys/
COPY migrations migrations/
COPY public public/
COPY src src/
COPY tests tests/

# build for production
ENV APP_ENV=prod
RUN chmod +x bin/console && bin/console cache:warmup

# setup entrypoint
COPY docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint
ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

# "nginx" stage
FROM nginx:${NGINX_VERSION}-alpine AS frontend
WORKDIR /app/public

COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=backend /app/public ./
