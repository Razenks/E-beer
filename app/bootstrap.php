<?php
// Inicia sessão
session_start();

// Carrega o autoloader do Composer
require_once __DIR__ . '/../vendor/autoload.php';


// Carrega variáveis de ambiente
$dotenvPath = __DIR__ . '/../';
if (file_exists($dotenvPath . '.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($dotenvPath);
    $dotenv->load();
}

// Configurações globais
date_default_timezone_set('America/Campo_Grande');