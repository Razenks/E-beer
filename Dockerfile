# Imagem oficial do PHP com Apache
FROM php:8.4-apache

# Atualiza pacotes e instala dependências de sistema e PHP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpq-dev \
    libxml2-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql zip mbstring dom xml xmlwriter

# Ativa o mod_rewrite do Apache
RUN a2enmod rewrite

# Copia o Composer (multi-stage)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho da aplicação
WORKDIR /var/www/html

# Copia apenas os arquivos do Composer para melhor uso de cache
COPY composer.json composer.lock ./

# Instala dependências PHP via Composer
RUN composer install --no-dev --optimize-autoloader

# Copia o restante da aplicação (evite arquivos desnecessários com .dockerignore)
COPY . /var/www/html

# Dá permissões adequadas para o Apache
RUN chown -R www-data:www-data /var/www/html

# Copia a configuração personalizada do Apache
COPY config/apache.conf /etc/apache2/sites-available/apache.conf

# Ativa o VirtualHost e desativa o default
RUN a2ensite apache.conf && a2dissite 000-default.conf

# Copia o script de setup do PHP
COPY config/php-setup.sh /usr/local/bin/php-setup.sh

# Torna o script executável
RUN chmod +x /usr/local/bin/php-setup.sh

# Define o ponto de entrada
ENTRYPOINT ["/usr/local/bin/php-setup.sh"]

# Expõe a porta padrão do Apache
EXPOSE 80
