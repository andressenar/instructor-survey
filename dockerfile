# Usa una imagen base de PHP o Node.js según lo que necesite tu aplicación
FROM php:8.3-fpm

# Instalar dependencias necesarias (si es que no se gestionan automáticamente)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd 

# Copia el código de tu aplicación
COPY . /app

# Define el directorio de trabajo
WORKDIR /app

# Instala dependencias de PHP y Node (si es necesario)

RUN npm install --location=global
RUN npm install puppeteer --location=global
RUN composer require spatie/browsershot


# Expone el puerto si es necesario (opcional, ya que Railway maneja esto automáticamente)
EXPOSE 8080

# Comando para iniciar el servidor PHP-FPM
CMD ["php-fpm"]
