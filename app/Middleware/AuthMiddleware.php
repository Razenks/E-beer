<?php
namespace App\Middleware;

use App\Services\JwtService;

class AuthMiddleware
{

    private string $jwt;
    private int $user_type;

    public function __construct()
    {
        $this->jwt = $_SESSION['jwt'] ?? false;
        $this->user_type = $_SESSION['user_type'] ?? false;
    }
    
    public function validateLoggedAdmin(): void
    {
        $this->validateLogged();
        if($this->user_type != 2)
        {
            $this->redirectToLogin("Usuário não permitido");
        }
    }

    public function validateLogged(): void
    {
        if(!$this->user_type && !$this->jwt)
        {
            $this->redirectToLogin("Usuário não logado");
        }
        
        $validation = $this->validateToken();
        if(!$validation['success'])
        {
            $this->redirectToLogin($validation['message'] ?? "Sessão expirada");
        }
    }

    private function validateToken(): array
    {
        return (new JwtService())->validateToken($this->jwt);
    }

    public function validateSession(): void
    {
        if(!isset($_SESSION['email'], $_SESSION['name'], $_SESSION['user_type']))
        {
            $this->redirectToLogin();
        }
    }

    private function redirectToLogin(?string $message = null): void
    {
        $message ? header("Location: /login?error={$message}") : header("Location: /login");
        exit;
    }
}