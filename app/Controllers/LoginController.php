<?php
namespace App\Controllers;

use App\Core\View;

class LoginController
{
    public function index(): void
    {
        $usuario = 'Joao';
        View::render('login.index', ['usuario' => $usuario]);
    }
}