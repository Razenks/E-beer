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

    public function validateUserPassword(string $pass, string $passwordHash): bool {
        try {
            if (!$pass || !$passwordHash) {
                return false;
            }
            
            if(!password_verify($pass, $passwordHash)) {
                return false;
            }

            return true;
        } catch (Exception $e) {
            error_log("Erro ao validar senha do usuário: " . $e->getMessage());
            return false;
        }   
    }
}