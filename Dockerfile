# Imagem oficial do PHP + Apache
FROM php:8.2-apache

# Atualiza pacotes e instala depend�ncias do sistema e PHP
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

# Instala depend�ncias do projeto via Composer
RUN composer install

# D� permiss�es para o Apache
RUN chown -R www-data:www-data /var/www/html

# Copia o script de setup do PHP
COPY /config/php-setup.sh /usr/local/bin/php-setup.sh

# Permite execu��o do script
RUN chmod +x /usr/local/bin/php-setup.sh

# Usa o script como ponto de entrada
ENTRYPOINT ["/usr/local/bin/php-setup.sh"]

# Exp�e a porta padr�o do Apache
EXPOSE 80
