<?php
namespace App\Core;

abstract class Controller 
{
    abstract function index();

    protected function render(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected static function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}