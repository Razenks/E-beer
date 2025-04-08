# Imagem oficial do PHP + Apache
FROM php:8.2-apache

# Atualiza pacotes e instala dependências do sistema e PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala o Composer (imagem multi-stage)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia todos os arquivos do projeto
COPY . .

# Instala dependências do projeto via Composer
RUN composer install

# Dá permissões para o Apache
RUN chown -R www-data:www-data /var/www/html

# Copia o script de setup do PHP
COPY /config/php-setup.sh /usr/local/bin/php-setup.sh

# Permite execução do script
RUN chmod +x /usr/local/bin/php-setup.sh

# Usa o script como ponto de entrada
ENTRYPOINT ["/usr/local/bin/php-setup.sh"]

# Expõe a porta padrão do Apache
EXPOSE 80
