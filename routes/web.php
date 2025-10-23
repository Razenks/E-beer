<?php

use App\Core\Router;

$router = new Router();

$router->get('/', fn() => header("Location: /login"));
$router->get('/login', ['UserController', 'index']);
$router->get('/cadastro', ['UserController', 'getRegisterPage']);
$router->get('/login/digitar-codigo', ['UserController', 'getCodePage'], ['AuthMiddleware', 'isValidatedSession']);
$router->get('/home', ['HomeController', 'index'], ['AuthMiddleware', 'isValidatedLogged']);
$router->get('/admin', ['HomeController', 'indexAdmin'], ['AuthMiddleware', 'isValidatedLoggedAdmin']);
$router->get('/ativar-conta/{status}', ['UserController', 'getActivateAccountStatusPage']);
$router->get('/cadastro/ativar-conta', ['UserController', 'getActivateAccountPage']);
$router->get('/cervejas', ['BeerController', 'index'], ['AuthMiddleware', 'isValidatedLogged']);
$router->get('/cerveja/{id}', ['BeerController', 'getDetailedBeerPage'], ['AuthMiddleware', 'isValidatedLogged']);
$router->post('/login', ['UserController', 'processLogin']);
$router->post('/login/validar-codigo', ['UserController', 'validateEmailCode']);
$router->get('/login/obter-home/{user_type}', ['UserController', 'redirectHome']);
$router->post('/cadastrar', ['UserController', 'processRegistration']);
$router->get('/cadastrar/ativar-conta/{token}', ['UserController', 'activateAccount']);
$router->get('/beerFeed', ['RecommendationController', 'index'], ['AuthMiddleware', 'isValidatedLogged']);
$router->get('/beerFeed/formulario', ['RecommendationController', 'getForm'], ['AuthMiddleware', 'isValidatedLogged']);

return $router;