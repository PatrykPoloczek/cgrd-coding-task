<?php

declare(strict_types=1);

use Cgrd\Infrastructure\Kernel;

require_once __DIR__ . '/../vendor/autoload.php';

define('VIEWS_BASE_PATH', __DIR__ . '/views/');
define('CONFIG_BASE_PATH', __DIR__ . '/../config');
define('VAR_BASE_PATH', __DIR__ . '/../var');
define('DB_PARTIALS_BASE_PATH', __DIR__ . '/../database');

if (!file_exists(VAR_BASE_PATH) || !is_dir(VAR_BASE_PATH)) {
    mkdir(VAR_BASE_PATH, 0755, true);
}

$kernel = new Kernel();
$kernel->run();

// var_dump(getallheaders());
