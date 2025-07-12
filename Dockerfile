# โหลด Base Image PHP 7.4
FROM php:7.4-fpm
 
# ติดตั้ง Extension Laravel ใช้
RUN apt-get update && apt-get install -y \
    git zip unzip curl \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql bcmath

# สั่ง update image และ ติดตั้ง git zip และ unzip package
RUN apt-get update
RUN apt-get install -y git zip unzip curl

# ติดตั้ง NodeJS เวอร์ชัน LTS ล่าสุด
RUN curl -sL https://deb.nodesource.com/setup_22.x | bash -
RUN apt-get install -y nodejs

# Copy file composer:latest ไว้ที่ /usr/bin/composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# คัดลอก composer.json และติดตั้ง dependency ล่วงหน้า
COPY src/composer.json src/composer.lock ./
RUN composer update --no-interaction --no-scripts 

# คัดลอก Laravel ทั้งหมดเข้า container
COPY src . 

EXPOSE 9000
# docker-compose exec app bash