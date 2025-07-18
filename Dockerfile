ARG COMPOSER_IMAGE_TAG
ARG PHP_IMAGE_TAG

FROM composer:${COMPOSER_IMAGE_TAG} AS deps
FROM php:${PHP_IMAGE_TAG} AS runtime

COPY --from=deps /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock /app/
COPY src/ /app/src/
COPY patches/ /app/patches/

ARG UOPZ_GIT_TAG

RUN apk add --no-cache --virtual .build-deps \
  $PHPIZE_DEPS \
  git \
  patch \
  && git clone --branch "${UOPZ_GIT_TAG}" --depth 1 \
  https://github.com/krakjoe/uopz.git /tmp/uopz \
  && wget -O /tmp/uopz.patch \
  https://github.com/krakjoe/uopz/commit/b2791e062fa94496dba13e4607e4738a7ae9b17f.patch\
  # see: https://github.com/krakjoe/uopz/issues/184#issuecomment-2495361776
  && cd /tmp/uopz \
  && patch -p1 < /tmp/uopz.patch \
  && phpize \
  && ./configure --with-php-config="$(command -v php-config)" \
  && make \
  && make install \
  && docker-php-ext-enable uopz \
  && apk del .build-deps

RUN apk add --no-cache patch \
  && composer install

CMD ["vendor/bin/phpunit", "tests"]
