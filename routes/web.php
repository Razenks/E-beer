<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

$router = new Router();

// Rotas Front-End
$router->get('/', fn() => header("Location: /login"));
$router->get('/login', ['LoginController', 'index']);
$router->get('/enter-code', ['LoginController', 'enterCode']);

// Rotas Back-End
$router->post('/login', ['LoginController', 'login']);
$router->post('/enter-code', ['LoginController', 'validateEmailCode']);

return $router;