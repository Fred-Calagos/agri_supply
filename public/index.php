<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/helper/auth_helper.php';
require_once __DIR__ . '/../app/libraries/tcpdf/tcpdf.php';



use App\Core\Router;

$router = new Router();
// require_once __DIR__ . '/../app/routes.php';
require_once __DIR__ . '/../routes/web.php';

$router->resolve();
