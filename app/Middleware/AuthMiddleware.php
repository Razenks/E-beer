<?php
namespace App\Middleware;

use App\Services\JwtService;

class AuthMiddleware {

    private string $email;
    private string $name;
    private int $user_type;
    private string $jwt;

    public function __construct() {
        $this->email = $_SESSION['email'] ?? false;
        $this->name = $_SESSION['name'] ?? false;
        $this->user_type = $_SESSION['user_type'] ?? false;
        $this->jwt = $_SESSION['jwt'] ?? false;
    }
    
    public function isValidatedLoggedAdmin(): array {
        [$isValidatedLogged, $errorMessage] = $this->isValidatedLogged();
        if (!$isValidatedLogged && $errorMessage !== null) {
            return [false, $errorMessage ?? "Usuário não logado."];
        }
        if($this->user_type != 2) {
            return [false, "Usuário não permitido"];
        }
        return [true, null];
    }

    public function isValidatedLogged(): array {
        $isValidatedSession = $this->isValidatedSession();
        if(!$isValidatedSession[0] || !$this->jwt) {
            return [false, "Usuário não logado."];
        }

        $validation = $this->validateToken();
        if(!$validation['success'])
        {
            return [false, $validation['message'] ?? "Sessão expirada"];
        }
        return [true, null];
    }

    private function validateToken(): array {
        return (new JwtService())->validateToken($this->jwt);
    }

    public function isValidatedSession(): array {
        if(!$this->email || !$this->name || !$this->user_type) {
            return [false, "Usuário sem sessão ou expirada."];
        }
        return [true, null];
    }
}