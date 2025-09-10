<?php
namespace App\Services;

use App\Models\User;
use App\Repository\UserRepository;
use Exception;

class AuthService {
    private readonly UserRepository $user_repository;
    
    public function __construct() {
        $this->user_repository = new UserRepository();
    }

    public function validateUser(string $email, string $pass): ?User {
        try {
            if(!$email || !$pass) {
                return null;
            }

            $user = $this->user_repository->getUserByEmail($email);
            if (!$user) {
                return null;
            }
            
            if(!password_verify($pass, $user->getPass())) {
                return null;
            }

            return $user;
        } catch (Exception $e) {
            error_log("Erro na função validateUser: " . $e->getMessage());
            return null;
        }   
    }
}