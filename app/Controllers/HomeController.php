<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(array $data = []): void
    {
        $this->render('home.home', $data);
    }

    public function indexAdmin(array $data = []): void
    {
        $this->render('home.homeAdmin', $data);
    }
}