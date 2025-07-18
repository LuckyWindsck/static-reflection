ARG COMPOSER_IMAGE_TAG
ARG PHP_IMAGE_TAG

FROM composer:${COMPOSER_IMAGE_TAG} AS deps
FROM php:${PHP_IMAGE_TAG} AS runtime

COPY --from=deps /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock /app/
COPY src/ /app/src/

RUN composer install

CMD ["php", "src/index.php"]
