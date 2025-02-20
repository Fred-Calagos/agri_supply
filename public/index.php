<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Composer autoload
require_once __DIR__ . '/../app/helper/auth_helper.php';


use App\Core\Router;

$router = new Router();
// require_once __DIR__ . '/../app/routes.php';
require_once __DIR__ . '/../routes/web.php';

$router->resolve();
