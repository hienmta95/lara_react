FROM php:7.3-fpm-alpine
WORKDIR /

RUN apk update && apk add \
  git \
  wget \
  freetype \
  freetype-dev \
  libpng-dev \
  jpeg-dev \
  libzip-dev \
  zip \
  unzip vim supervisor \
  openssh

RUN  docker-php-ext-configure gd \
        --with-freetype-dir=/usr/bin/ \
        --with-png-dir=/usr/bin/ \
        --with-jpeg-dir=/usr/lib/ \
        --with-gd

RUN docker-php-ext-install gd opcache pdo_mysql && \
  docker-php-ext-configure zip --with-libzip && \
  docker-php-ext-install zip

COPY ./docker-entrypoint.sh /docker-entrypoint.sh
COPY ./php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./supervisor/supervisor.conf /etc/supervisor/supervisor.conf
COPY ./supervisor/httpd.conf /etc/supervisor/conf.d/httpd.conf
COPY ./supervisor/queue.conf /etc/supervisor/conf.d/queue.conf

ARG DOCKER_UID
ARG DOCKER_GID
RUN if [ ${DOCKER_UID:-0} -ne 0 ] && [ ${DOCKER_GID:-0} -ne 0 ]; then \
    deluser www-data &&\
    if getent group www-data ; then delgroup www-data; fi &&\
    addgroup -g ${DOCKER_GID} www-data &&\
    adduser -u ${DOCKER_UID} -G www-data www-data --disabled-password &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data \
;fi

RUN apk add --no-cache openssl

ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz

# ENTRYPOINT ["/usr/bin/supervisor", "-c", "/etc/supervisor/supervisor.conf"]

WORKDIR /app
