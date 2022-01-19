FROM php:8.0-fpm
 
# Set working directory
WORKDIR /var/www/html/
 
# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    curl
 
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
 
# Install extensions for php
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl 
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Install XDebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents to the working directory
COPY . /var/www/html

# Permissions
RUN chown -R root:www-data /var/www/html
RUN chmod -R u+rwx,g+rx,o+rx /var/www/html
RUN find /var/www/html -type d -exec chmod -R u+rwx,g+rx,o+rx {} +
RUN find /var/www/html -type f -exec chmod -R u+rw,g+rw,o+r {} +

CMD ["php-fpm"]

EXPOSE 9000
