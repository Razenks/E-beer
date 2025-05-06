<?php
namespace App\Services;

use App\Models\UserModel;
use Exception;

class AuthService
{
    private $userModel;

    public function __construct(?UserModel $userModel = null)
    {
        $this->userModel = $userModel ?? new UserModel();
    }

    public function validateUser(string $email, string $pass): bool|array
    {
        try {
            $user = $this->userModel->findByEmail($email);

            if(!$user)
            {
                return false;
            }
            
            if(!password_verify($pass, $user['senha']))
            {
                return false;
            }

            return $user;
        } catch (Exception $e) {
            error_log("Erro na função validateUser: " . $e->getMessage());
            return false;
        }
        
    }
}