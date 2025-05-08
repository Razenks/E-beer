<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;

class HomeController extends Controller
{
    public function index(array $data = []): void
    {
        if(!((new AuthService())->validateLogged(['name', 'email', 'user_type'])))
        {
            $this->render('login.index', ['error' => 'Usuário não logado']);
        }

        $this->render('home.home', $data);
    }

    public function indexAdmin(array $data = []): void
    {
        if(!((new AuthService())->validateLogged(['name', 'email', 'user_type'])))
        {
            $this->render('login.index', ['error' => 'Usuário não logado']);
        }

        $this->render('home.homeAdmin', $data);
    }
}