<?php

use App\Core\Router;

$router = new Router();

// Rotas Front-End
$router->get('/', fn() => header("Location: /login"));
$router->get('/login', ['UserController', 'index']);
$router->get('/register', ['UserController', 'getRegisterPage']);
$router->get('/enter-code', ['UserController', 'getCodePage'], ['AuthMiddleware', 'isValidatedSession']);
$router->get('/home', ['HomeController', 'index'], ['AuthMiddleware', 'isValidatedLogged']);
$router->get('/admin', ['HomeController', 'indexAdmin'], ['AuthMiddleware', 'isValidatedLoggedAdmin']);
$router->get('/confirm-email/{token}', ['UserController', 'confirmEmail']);
$router->get('/finalize-registration', ['UserController', 'getFinalizeRegistrationPage']);

// Rotas Back-End
$router->post('/api/login', ['UserController', 'processLogin']);
$router->post('/api/validate-code', ['UserController', 'validateEmailCode']);
$router->get('/api/get-home/{user_type}', ['UserController', 'redirectHome']);
$router->post('/api/start-registration', ['UserController', 'startRegistration']);
$router->post('/api/finalize-registration', ['UserController', 'finalizeRegistration']);


return $router;