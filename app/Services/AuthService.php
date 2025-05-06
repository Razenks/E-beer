<?php
namespace App\Services;

use Exception;

class AuthService
{
    public function validateUser(array|bool $user, string $pass): bool
    {
        try {
            if(!$user)
            {
                return false;
            }
            
            if(!password_verify($pass, $user['senha']))
            {
                return false;
            }

            return true;
        } catch (Exception $e) {
            error_log("Erro na função validateUser: " . $e->getMessage());
            return false;
        }
        
    }
}