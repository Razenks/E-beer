<?php
namespace App\Core;

use App\Services\ActivityLoggerService;

class App
{
    public function __construct(
        protected Router $router
    ) {}

    public function run ()
    {
        $request = new Request();

        $logger = new ActivityLoggerService();
        $logger->log('Nova Requisição');
        
        // Obtém a URL e o método da requisição
        $this->router->dispatch($request->uri(), $request->method());
    }
}