<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Exception;

class JwtService 
{
    private static string $key;

    public function __construct()
    {
        static::$key = $_ENV['JWT_SECRET'];
    }

    public function generateToken(array $data): string
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

    public function validateToken(string $token): array
    {
        try {
            $decoded = JWT::decode($token, new Key(static::$key, 'HS256'));

            return [
                'success' => true,
                'message' => 'Token válido',
                'data' => (array) $decoded->dados
            ];
        } catch (ExpiredException $e) {
            return [
                'success' => false,
                'message' => 'Sessão expirada',
                'messageLog' => 'Token expirado'
            ];
        } catch (SignatureInvalidException $e) {
            return [
                'success' => false,
                'message' => 'Sessão expirada',
                'messageLog' => 'Assinatura inválida'
            ];
        } catch (BeforeValidException $e) {
            return [
                'success' => false,
                'message' => 'Sessão expirada',
                'messageLog' => 'Token ainda não válido'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Sessão expirada',
                'messageLog' => 'Token inválido'
            ];
        }
    }
}