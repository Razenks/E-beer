<?php
namespace App\Services;

use App\Models\UserModel;
use Exception;

class AuthService
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = (new UserModel());
    }

    public function validateUser(string $email, string $pass): array|string
    {
        try {
            $user = $this->userModel->findByEmail($email);

            if(!$user)
            {
                return "E-mail não encontrado";
            }
            
            if(!password_hash($pass, $user['senha']))
            {
                return "Senha incorreta";
            }

            return $user;
        } catch (Exception $e) {
            error_log("Erro na função validateUser: " . $e->getMessage());
            return false;
        }
        
    }
}