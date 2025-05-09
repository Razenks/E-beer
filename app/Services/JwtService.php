<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService 
{
    private static string $key;

    public function __construct()
    {
        static::$key = $_ENV['JWT_SECRET'];
    }

    public function generateToken(array $data)
    {
        $payload = [
            'iss' => 'http://localhost',
            'aud' => 'http://localhost',
            'iat' => time(),
            'exp' => time() + 60,
            'dados' => $data
        ];

        return JWT::encode($payload, static::$key, 'HS256');
    }
}