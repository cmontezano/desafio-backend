FROM php:8-fpm-alpine3.13

RUN apk update && apk add --no-cache \
    build-base \
    shadow \
    curl \
    zlib-dev \
    php8 \
    php8-common \
    php8-fpm \
    php8-pdo \
    php8-opcache \
    php8-zip \
    php8-phar \
    php8-iconv \
    php8-cli \
    php8-curl \
    php8-openssl \
    php8-mbstring \
    php8-tokenizer \
    php8-fileinfo \
    php8-json \
    php8-xml \
    php8-xmlwriter \
    php8-simplexml \
    php8-dom \
    php8-pdo_mysql \
    php8-pdo_sqlite \
    php8-tokenizer \
    php8-pecl-redis

# 2. install nodejs and npm
RUN apk add --update npm

# 3. install php extensions
RUN docker-php-ext-configure exif \
    && pecl install redis
RUN docker-php-ext-install exif pdo pdo_mysql
RUN docker-php-ext-enable exif pdo_mysql redis

# 4. composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. remove Cache
RUN rm -rf /var/cache/apk/*

# 5. add UID '1000' to www-data
ARG uid
RUN usermod -u $uid www-data

# 6. set working directory
WORKDIR /var/www

# 7. change current user to www
USER www-data

# 8. expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
