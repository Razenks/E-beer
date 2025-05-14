<?php

use App\Core\Router;

$router = new Router();

// Rotas Front-End
$router->get('/', fn() => header("Location: /login"));
$router->get('/login', ['LoginController', 'index']);
$router->get('/enter-code', ['LoginController', 'enterCode'], ['AuthMiddleware', 'validateSession']);
$router->get('/home', ['HomeController', 'index'], ['AuthMiddleware', 'validateLogged']);
$router->get('/admin', ['HomeController', 'indexAdmin'], ['AuthMiddleware', 'validateLoggedAdmin']);

// Rotas Back-End
$router->post('/login', ['LoginController', 'login']);
$router->post('/enter-code', ['LoginController', 'validateEmailCode']);
$router->get('/home/{user_type}', ['LoginController', 'redirectHome']);

return $router;