<?php

declare(strict_types=1);

use Cgrd\Infrastructure\Controllers\AuthController;
use Cgrd\Infrastructure\Factories\SqliteConnectionFactory;
use Cgrd\Infrastructure\Handlers\AuthenticateUserHandler;
use Cgrd\Infrastructure\Models\ServiceDefinition;

$authenticateUserHandler = new AuthenticateUserHandler();
$connection = SqliteConnectionFactory::create();

return [
    new ServiceDefinition(
        AuthenticateUserHandler::class,
        fn () => $authenticateUserHandler
    ),
    new ServiceDefinition(
        AuthController::class,
        fn () => new AuthController($authenticateUserHandler)
    ),
];
