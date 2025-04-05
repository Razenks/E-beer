# Imagem oficial do PHP + Apache
FROM php:8.2-apache

# Copia todos os arquivos do projeto
COPY . .

# Instala as extens�es necess�rias 
RUN apt-get update && apt-get install -y \
	libpq-dev \
	&& docker-php-ext-install pdo pdo_pgsql

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala depend�ncias do projeto via Composer
RUN composer install
	
# D� permiss�es 
RUN chown -R www-data:www-data /var/www/html

# Copia o script para dentro do container
COPY /config/php-setup.sh /usr/local/bin/php-setup.sh

# D� permiss�o de execu��o ao script
RUN chmod +x /usr/local/bin/php-setup.sh

# Usa o script como ponto de entrada
ENTRYPOINT ["/usr/local/bin/php-setup.sh"]

# Expondo a porta padr�o do Apache
EXPOSE 80