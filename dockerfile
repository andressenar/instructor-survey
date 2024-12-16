# Usa una imagen base de PHP o Node.js según lo que necesite tu aplicación
FROM php:8.3-fpm

# Instalar dependencias necesarias (si es que no se gestionan automáticamente)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    chromium \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd 



