<?php
namespace App\Core;

use Exception;

class View
{
    private static string $layout = 'default';

    private static array $sharedData = [];

    public static function setLayout(string $layout): void {
        self::$layout = $layout;
    }

    public static function share(string $key, mixed $value): void {
        self::$sharedData[$key] = $value;
    }

    // Renderiza uma view dentro de um layout.
    public static function render(string $view, array $data = []): void {
        try {
            // Unifica os dados da view com os dados compartilhados
            $data = array_merge(self::$sharedData, $data);

            // Encontra o caminho do arquivo da view da página
            $viewPath = __DIR__ . '/../Views/' . str_replace('.', '/', $view) . '.php';
            if(!file_exists($viewPath)) {   
                throw new Exception("View '{$view}' não encontrada em '{$viewPath}'.");
            }

            // Encontra o caminho do arquivo de layout
            $layoutPath = __DIR__ . '/../Views/layouts/' . self::$layout . '.php'; 
            if(!file_exists($layoutPath)) {   
                throw new Exception("Layout '" . self::$layout . "' não encontrada em '{$layoutPath}'.");
            }

            // Inicia o buffer de saída e renderiza a view da PÁGINA
            ob_start();
            extract($data);            
            require $viewPath;
            $content = ob_get_clean(); // Pega o conteúdo da view e limpa o buffer

            // Renderiza o LAYOUT, que terá acesso à variável $content
            require $layoutPath;
        } catch (Exception $e) {
            http_response_code(500);
            echo "Erro ao renderizar a view: " . $e->getMessage();
            error_log("Erro na View::render - " . $e->getMessage());
        } 
    }
}