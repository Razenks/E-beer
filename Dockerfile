# Imagem oficial do PHP + Apache
FROM php:8.2-apache

# Copia todos os arquivos do projeto
COPY . .

# Instala as extensões necessárias 
RUN apt-get update && apt-get install -y \
	libpq-dev \
	&& docker-php-ext-install pdo pdo_pgsql

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala dependências do projeto via Composer
RUN composer install
	
# Dá permissões 
RUN chown -R www-data:www-data /var/www/html

# Copia o script para dentro do container
COPY /config/php-setup.sh /usr/local/bin/php-setup.sh

# Dá permissão de execução ao script
RUN chmod +x /usr/local/bin/php-setup.sh

# Usa o script como ponto de entrada
ENTRYPOINT ["/usr/local/bin/php-setup.sh"]

# Expondo a porta padrão do Apache
EXPOSE 80