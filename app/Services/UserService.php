<?php
namespace App\Services;

use App\Repository\UserRepository;
use App\Models\User;
use Exception;

class UserService {

    private readonly UserRepository $user_repository;

    public function __construct(UserRepository $user_repository) {
        $this->user_repository = $user_repository;
    }

    public function getUserByEmail(string $email): ?User {
        if (!$email) {
            return null;
        }
        $user = $this->user_repository->getUserByEmail($email);
        if (!$user) {
            return null;
        }

        return $user;
    }

    public function isCreatedUser(string $email): ?bool {
        try {
            $is_created = $this->user_repository->isCreatedUser($email);
            
            return $is_created;
        } catch (Exception $e) {
            error_log("Erro ao tentar consultar se email já foi cadastrado: " . $e->getMessage());
            return null;
        }
    }

    public function createUser($data = []): bool {
        if (count($data) <= 0) {
            return false;
        }
        try {
            $is_created = $this->user_repository->createUser($data);
            if (!$is_created) {
                return false;
            }

            return true;
        } catch (Exception $e) {
            error_log("Erro para criar usuário no banco: " . $e->getMessage());
            return false;
        }
        
    }

    public function createUserSession($data = []) {
        $_SESSION['name'] = $data['name'] ?? null;
        $_SESSION['email'] = $data['email'] ?? null;
        $_SESSION['user_type'] = $data['user_type'] ?? null;
    }

    public function logout() {
        unset($_SESSION['jwt']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        unset($_SESSION['user_type']);
        session_destroy();
    }

    public function activateUser(string $email): bool {
        if (!$email) {
            return false;
        }
        try {
            $isActiveUser = $this->user_repository->activateUser($email);

            return $isActiveUser;
        } catch (Exception $e) {
            error_log("Erro para ativar usuário: " . $e->getMessage());
            return false;
        }
    }
}