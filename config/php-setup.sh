#!/bin/bash

# Este script é o ENTRYPOINT.
# As configurações de php.ini já foram feitas no Dockerfile.

# Garante que o Apache possa escrever nos logs, especialmente se 'storage' for um volume.
# O chown no Dockerfile já deve ter cuidado disso para os arquivos da imagem.
# Esta etapa é mais uma garantia, útil se storage/logs for montado como um volume vazio
# que não herda as permissões da imagem.
if [ -d "/var/www/html/storage/logs" ]; then
    chown -R www-data:www-data /var/www/html/storage/logs
fi

echo "Permissões de tempo de execução verificadas/aplicadas. Iniciando Apache..."

# Roda o Apache no foreground (primeiro plano), que é o que o container precisa.
exec apache2-foreground