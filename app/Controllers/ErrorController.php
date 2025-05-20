<?php
namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{
    public function index(array $data = []): void
    {
        $this->render('error.404', $data);
    }
}