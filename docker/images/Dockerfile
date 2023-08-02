FROM php:8.0-fpm
    
    RUN apt-get update && apt-get install -y \
            curl \
            libonig-dev \
            libzip-dev \
            wget \
            libfreetype6-dev \
            libjpeg62-turbo-dev \
            libmcrypt-dev \
        && pecl install mcrypt-1.0.4 \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
        && docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-enable mcrypt \
        && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
    RUN curl -fsSL https://deb.nodesource.com/setup_19.x | bash - && \
        apt-get install -y nodejs
        
    
    ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini
    
    WORKDIR /var/www
    
    CMD ["php-fpm"]