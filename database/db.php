<?php

require_once __DIR__ . '/../vendor/autoload.php';

function runSeeders(): void
{
    require_once sprintf(
        '%s/migrations/migrate.php',
        DB_PARTIALS_BASE_PATH
    );
}

function runMigrations(): void
{
    require_once sprintf(
        '%s/seeders/seed.php',
        DB_PARTIALS_BASE_PATH
    );
}

const SEED_OPERATION = 'seed';
const MIGRATE_OPERATION = 'migrate';

$operation = $argv[1] ?? null;
$supportedOperations = [
    SEED_OPERATION,
    MIGRATE_OPERATION
];

match ($operation) {
    SEED_OPERATION => runSeeders(),
    MIGRATE_OPERATION => runMigrations(),
    default => throw new \Exception('Unsupported operation. Please use "seed" or "migrate".')
};
