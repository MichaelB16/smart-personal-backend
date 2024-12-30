FROM php:8.3-fpm

# Configura o diretório de trabalho
WORKDIR /var/www/html

# Instala dependências necessárias
RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    libpq-dev && \
    docker-php-ext-install \
    intl \
    pdo_mysql \
    gd \
    pdo_pgsql \
    pgsql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Copia o Composer da imagem oficial para o container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia os arquivos do projeto para o container
COPY . .

# Ajusta permissões para o Laravel
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Instala dependências do PHP via Composer
RUN composer install --no-dev --prefer-dist --optimize-autoloader && \
    composer clear-cache

# Expõe a porta padrão do PHP-FPM
EXPOSE 9000

# Comando para rodar o PHP-FPM
CMD ["php-fpm"]
