<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

require_once '../vendor/autoload.php';

function validarTokenJWT($token)
{
    $chave_secreta = $_ENV['JWT_SECRET']; // chave secreta

    try {
        // Decodifica o token usando a chave secreta
        $decoded = JWT::decode($token, new Key($chave_secreta, 'HS256'));

        // Retorna os dados do payload do token
        return (array) $decoded->dados; // Aqui retorna os dados do usuário
    } catch (Exception $e) {
        return false; // Token inválido ou expirado
    }
}