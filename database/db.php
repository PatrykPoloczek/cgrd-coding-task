<?php

declare(strict_types=1);

use Seeders\SeedHandler;
use Migrations\MigrationHandler;

require_once __DIR__ . '/../vendor/autoload.php';

define('VAR_BASE_PATH', __DIR__ . '/../var');

if (!file_exists(VAR_BASE_PATH) || !is_dir(VAR_BASE_PATH)) {
    mkdir(VAR_BASE_PATH, 0755, true);
}

const SEED_OPERATION = 'seed';
const MIGRATE_OPERATION = 'migrate';
const MIGRATE_FRESH_OPERATION = 'migrate:fresh';

$operation = $argv[1] ?? null;
$supportedOperations = [
    SEED_OPERATION,
    MIGRATE_OPERATION,
    MIGRATE_FRESH_OPERATION,
];

match ($operation) {
    SEED_OPERATION => (new SeedHandler)->seed(),
    MIGRATE_OPERATION => (new MigrationHandler)->migrate(),
    MIGRATE_FRESH_OPERATION => (new MigrationHandler)->migrate(true),
    default => throw new \Exception('Unsupported operation. Please use "seed" or "migrate".')
};
