# Dockerfile
FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Obtener Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar composer.json y composer.lock
COPY composer.json composer.lock ./

# Instalar dependencias
RUN composer install --no-scripts --no-autoloader

# Copiar el resto de la aplicación
COPY . .

# Generar autoloader optimizado
RUN composer dump-autoload --optimize

RUN chown -R www-data:www-data vendor/

# Exponer puerto para el servidor de desarrollo de Laravel
EXPOSE 7000

# Comando para iniciar el servidor de desarrollo de Laravel
CMD php artisan serve --host=0.0.0.0 --port=7000
