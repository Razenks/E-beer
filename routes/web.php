<?php

use App\Core\Router;

$router = new Router();

// Rotas Front-End
$router->get('/', fn() => header("Location: /login"));
$router->get('/login', ['LoginController', 'index']);
$router->get('/enter-code', ['LoginController', 'enterCode']);
$router->get('/home', ['HomeController', 'index']);
$router->get('/admin', ['HomeController', 'indexAdmin']);

// Rotas Back-End
$router->post('/login', ['LoginController', 'login']);
$router->post('/enter-code', ['LoginController', 'validateEmailCode']);
$router->get('/home/{user_type}', ['LoginController', 'redirectHome']);
$router->get('/logout', ['LoginController', 'logout']);

return $router;