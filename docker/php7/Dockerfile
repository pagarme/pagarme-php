FROM php:7.3-cli

RUN apt-get update && \
    apt-get install -y git zip unzip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader > /dev/null 2>&1 && \
    rm -rf /root/.composer

# Copy codebase
COPY . ./

# Finish composer
RUN composer dump-autoload --no-scripts --optimize > /dev/null 2>&1

RUN composer global require vimeo/psalm > /dev/null 2>&1

RUN ln -s /root/.composer/vendor/bin/* /usr/local/bin/ > /dev/null 2>&1