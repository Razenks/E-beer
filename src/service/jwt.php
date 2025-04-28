<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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
