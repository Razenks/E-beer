<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

$router = new Router();

// Rotas Front-End
$router->get('/', fn() => header("Location: /login"));
$router->get('/login', ['LoginController', 'index']);
$router->get('/login/{id}', ['LoginController', 'index']);

// Rotas Back-End
$router->post('/login', ['LoginController', 'login']);

return $router;