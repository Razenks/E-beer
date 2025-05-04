<?php
namespace App\Core;

use Exception;

class Router 
{
    protected array $routes = [];

    // Função para criar uma rota get
    public function get(string $uri, callable|array $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, callable|array $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    private function addRoute(string $method, string $uri, callable|array $action): void
    {
        $this->routes[$method][] = ['uri' => $uri, 'action' => $action];
    }

    // Função para processar a requisição e chamar a rota correta (Separar responsabilidades futuramente)
    public function dispatch(string $uri, string $method)
    {
        try {

            $uri = trim(parse_url($uri, PHP_URL_PATH), '/');
            foreach($this->routes[$method] ?? [] as $route)
            {
                $pattern = "#^" . preg_replace('#\{[\w]+\}#', '([\w-]+)', trim($route['uri'], '/')) . "$#";
                if(preg_match($pattern, $uri, $matches))
                {
                    array_shift($matches);
                    $action = $route['action'];
                    if(is_callable($action)) 
                    {
                        return call_user_func_array($action, $matches);
                    }
                    if(is_array($action) && count($action) === 2)
                    {
                        $controllerName = "App\\Controllers\\{$action[0]}";
                        $methodName = $action[1];
                        if(class_exists($controllerName))
                        {
                            $controller = new $controllerName();
                            if(method_exists($controller, $methodName)) 
                            {
                                return call_user_func_array([$controller, $methodName], $matches);
                            }
                            else
                            {
                                throw new Exception("Método '{$methodName}' não encontrado em {$controllerName}.");
                            }
                        } 
                        else
                        {
                            throw new Exception("Controller '{$controllerName}' não encontrado.");
                        }
                    }
                    
                    throw new Exception("Tipo de action inválido.");
                }
            }
            http_response_code(404);
            echo "404 - Not Found";
        } catch (Exception $e) {
            http_response_code(500);
            // echo "Erro interno, tente novamente mais tarde.";
            echo 'Erro na função dispatch: '.$e->getMessage();
            error_log('Erro na função dispatch: '.$e->getMessage());
        }
        
    }
}

// Exemplo do array $routes
// [
//     'GET' => [
//         ['uri' => '/login', 'action' => ['LoginController', 'index']],
//         ['uri' => '/contato', 'action' => ['ContatoController', 'index']],
//     ],
//     'POST' => [
//         ['uri' => '/login', 'action' => ['LoginController', 'login']]
//     ]
// ]
