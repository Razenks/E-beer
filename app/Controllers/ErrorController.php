<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;

class ErrorController extends Controller
{
    public function index(array $data = []): void {
        View::setLayout('auth');
        $this->render('pages.error.404', $data);
    }
}