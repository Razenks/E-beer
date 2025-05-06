<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\App;

$router = require_once __DIR__ . '/../routes/web.php';

$app = new App($router);
$app->run();