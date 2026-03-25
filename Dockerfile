# usamos una imagen de php base
FROM php:8.1-apache

#instalamos las dependencias -->PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# copiamos el código de la aplicación al contenedor
COPY . /var/www/html/

# exponemos el puerto 80 para acceder a la aplicación
EXPOSE 80
