<?php
namespace App\Core;

use Exception;

class View
{
    public static function render(string $view, array $data = []): void
    {
        try {
            $viewPath = __DIR__ . '/../Views/' . str_replace('.', '/', $view) . '.php';

            if(!file_exists($viewPath))
            {   
                throw new Exception("View '{$view}' não encontrada.");
            }

            extract($data);
            require $viewPath;
        } catch (Exception $e) {
            http_response_code(500);
            echo "Erro ao renderizar a view: " . $e->getMessage();
            error_log("Erro na View::render - " . $e->getMessage());
        }
        
    }
}