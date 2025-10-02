<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index(array $data = []): void {
        $data['title'] = 'E-BEER - Home';
        $data['user_type'] = $_SESSION['user_type'];
        $data['jwt'] = $_SESSION['jwt'];

        $this->render('pages.home.home', $data);
    }

    public function indexAdmin(array $data = []): void {
        $data['title'] = 'E-BEER - Admin';

        $this->render('pages.home.homeAdmin', $data);
    }
}