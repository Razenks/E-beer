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
        $logger = new ActivityLoggerService();
        $logger->log('Nova Requisição');

        $request = new Request();
        // Obtém a URL e o método da requisição
        $this->router->dispatch($request->uri(), $request->method());
    }
}