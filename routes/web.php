<?php

use App\Core\Router;

$router = new Router();

// Rotas Front-End
$router->get('/', fn() => header("Location: /login"));
$router->get('/login', ['UserController', 'index']);
$router->get('/cadastro', ['UserController', 'getRegisterPage']);
$router->get('/login/digitar-codigo', ['UserController', 'getCodePage'], ['AuthMiddleware', 'isValidatedSession']);
$router->get('/home', ['HomeController', 'index'], ['AuthMiddleware', 'isValidatedLogged']);
$router->get('/admin', ['HomeController', 'indexAdmin'], ['AuthMiddleware', 'isValidatedLoggedAdmin']);
$router->get('/ativar-conta/{status}', ['UserController', 'getActivateAccountStatusPage']);
$router->get('/cadastro/ativar-conta', ['UserController', 'getActivateAccountPage']);

// Rotas Back-End
$router->post('/api/login', ['UserController', 'processLogin']);
$router->post('/api/validate-code', ['UserController', 'validateEmailCode']);
$router->get('/api/get-home/{user_type}', ['UserController', 'redirectHome']);
$router->post('/api/register', ['UserController', 'processRegistration']);
$router->get('/api/ativar-email/{token}', ['UserController', 'activateAccount']);


return $router;