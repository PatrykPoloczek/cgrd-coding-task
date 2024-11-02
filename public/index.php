<?php

use Cgrd\Infrastructure\Http\Routing\Router;
use Cgrd\Infrastructure\Kernel;
use Cgrd\Infrastructure\Storage\InMemoryContainer;

require_once __DIR__ . '/../vendor/autoload.php';

define('CONFIG_BASE_PATH', __DIR__ . '/../config');
define('VAR_BASE_PATH', __DIR__ . '/../var');

$kernel = new Kernel();
$kernel->run();

$router = new Router;
$router->register();

// var_dump(getallheaders());
