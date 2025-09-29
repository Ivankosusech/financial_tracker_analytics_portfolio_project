FROM php:8.3-apache

# Установка системных зависимостей для SQLite
RUN apt-get update && \
    apt-get install -y libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Копируем файлы
COPY public/ /var/www/html/

# Даём права
RUN chown -R www-data:www-data /var/www/html/ && \
    chmod -R 775 /var/www/html/