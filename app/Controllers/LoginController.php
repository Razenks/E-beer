<?php
namespace App\Controllers;

use App\Core\View;

class LoginController
{
    public function index(): void
    {
        View::render('login.index');
    }
}