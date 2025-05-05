<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

function gerarTokenJWT($dadosUsuario) {
    $chave = $_ENV['JWT_SECRET'];
    $payload = [
        'iss' => 'http://localhost',
        'aud' => 'http://localhost',
        'iat' => time(),
        'exp' => time() + 3600,
        'dados' => $dadosUsuario
    ];

    return JWT::encode($payload, $chave, 'HS256');
}

function validarTokenJWT($token)
{
    $chave_secreta = $_ENV['JWT_SECRET']; // chave secreta

    try {
        // Decodifica o token usando a chave secreta
        $decoded = JWT::decode($token, new Key($chave_secreta, 'HS256'));

        // Retorna os dados do payload do token em caso de sucesso
        return [
            'success' => true,
            'message' => 'Token válido',
            'data' => (array) $decoded->dados // Dados do usuário
        ];
    } catch (Exception $e) {
        // Retorna mensagem de erro em caso de falha
        return [
            'success' => false,
            'message' => 'Token inválido ou expirado',
            'error' => $e->getMessage() // Mensagem de erro do JWT
        ];
    }
}