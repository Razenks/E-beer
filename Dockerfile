    # Imagem oficial do PHP com Apache
    FROM php:8.2-apache

    # Variáveis de ambiente para evitar prompts interativos
    ENV DEBIAN_FRONTEND=noninteractive

    # Atualiza pacotes e instala dependências de sistema e PHP
    RUN apt-get update && apt-get install -y \
        libzip-dev \
        libpq-dev \
        libxml2-dev \
        libonig-dev \
        # Adicione outras dependências de sistema se necessário
        && docker-php-ext-install pdo pdo_pgsql zip mbstring dom xml xmlwriter \
        && apt-get clean && rm -rf /var/lib/apt/lists/* # Limpeza

    # Ativa o mod_rewrite do Apache
    RUN a2enmod rewrite

    # Copia o Composer
    COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

    # Define o diretório de trabalho da aplicação
    WORKDIR /var/www/html

    # ----- Configuração do PHP -----
    # Copia o php.ini-development para ser o ativo e o personaliza AQUI, durante o BUILD
    # Garanta que a pasta storage/logs exista na imagem para o error_log
    RUN mkdir -p /var/www/html/storage/logs && \
        cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && \
        sed -i 's/display_errors = .*/display_errors = On/' /usr/local/etc/php/php.ini && \
        sed -i 's/display_startup_errors = .*/display_startup_errors = On/' /usr/local/etc/php/php.ini && \
        sed -i 's/log_errors = .*/log_errors = On/' /usr/local/etc/php/php.ini && \
        # Garanta que o caminho para error_log seja absoluto e dentro do WORKDIR
        sed -i 's|;error_log = php_errors.log|error_log = /var/www/html/storage/logs/php_errors.log|' /usr/local/etc/php/php.ini && \
        # Ajuste de upload_max_filesize e post_max_size (opcional, mas comum)
        sed -i 's/upload_max_filesize = .*/upload_max_filesize = 20M/' /usr/local/etc/php/php.ini && \
        sed -i 's/post_max_size = .*/post_max_size = 20M/' /usr/local/etc/php/php.ini


    # ----- Dependências do Composer -----
    # Copia apenas os arquivos do Composer primeiro para melhor uso do cache da camada
    COPY composer.json composer.lock ./
    # Instala dependências PHP via Composer
    # --prefer-dist e --no-progress para builds mais rápidos e limpos em CI/imagens
    # --no-interaction para não pedir inputs
    RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-progress --no-interaction

    # ----- Código da Aplicação -----
    # Copia o restante da aplicação (o .dockerignore vai filtrar arquivos desnecessários)
    COPY . /var/www/html/

    # ----- Configuração do Apache -----
    # Copia a configuração personalizada do Apache (ajuste o DocumentRoot nela se necessário)
    COPY config/apache.conf /etc/apache2/sites-available/000-default.conf
    # Se seu apache.conf tem um nome diferente, ajuste aqui e no a2ensite
    # RUN a2dissite 000-default.conf && a2ensite seu-site.conf

    # ----- Permissões -----
    # Define permissões para pastas que o Apache/PHP precisam escrever
    # Faça isso APÓS copiar os arquivos e ANTES de definir o ENTRYPOINT
    # O WORKDIR é /var/www/html
    RUN chown -R www-data:www-data storage # Ou caminhos mais específicos como storage/logs storage/cache
    # Se você tiver uma pasta de uploads dentro de public:
    # RUN chown -R www-data:www-data public/uploads

    # ----- Script de Entrada -----
    COPY config/php-setup.sh /usr/local/bin/php-setup.sh
    RUN chmod +x /usr/local/bin/php-setup.sh

    # Expõe a porta padrão do Apache
    EXPOSE 80

    # Define o ponto de entrada
    ENTRYPOINT ["/usr/local/bin/php-setup.sh"]
    # Ou, se o php-setup.sh só fizer permissões e você quiser que o apache seja o processo principal direto:
    # CMD ["apache2-foreground"] # Nesse caso, o php-setup.sh seria um RUN step