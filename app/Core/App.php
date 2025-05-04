<?php
namespace App\Core;

use App\Services\ActivityLogger;

class App
{
    public function __construct(
        protected Router $router
    ) {}

    public function run ()
    {
        $logger = new ActivityLogger();
        $logger->log('Nova Requisição');
        // Obtém a URL e o método da requisição
        $this->router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}