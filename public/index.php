<?php

use Cgrd\Infrastructure\Http\Routing\Router;
use Cgrd\Infrastructure\Kernel;
use Cgrd\Infrastructure\Storage\Container;

require_once __DIR__ . '/../vendor/autoload.php';

define('CONFIG_BASE_PATH', __DIR__ . '/../config');

// $kernel = new Kernel();
// $kernel->run();

$router = new Router;
$router->register();

var_dump(getallheaders());
