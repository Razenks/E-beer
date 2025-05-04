#!/bin/bash

# Cria a pasta de log (no container, mapeada para o host)
mkdir -p /var/www/html/storage/logs

# Define permiss�es
chown -R www-data:www-data /var/www/html/storage/logs

# Copia o php.ini-development para ser o ativo
cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# Configura o PHP para exibir e logar os erros
sed -i 's/display_errors = .*/display_errors = On/' /usr/local/etc/php/php.ini
sed -i 's/display_startup_errors = .*/display_startup_errors = On/' /usr/local/etc/php/php.ini
sed -i 's/log_errors = .*/log_errors = On/' /usr/local/etc/php/php.ini
sed -i 's|;error_log = php_errors.log|error_log = /var/www/html/storage/logs/php_errors.log|' /usr/local/etc/php/php.ini


# Roda o Apache no foreground(primeiro plano)
apache2-foreground

