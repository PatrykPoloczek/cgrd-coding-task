<?php

declare(strict_types=1);

use Cgrd\Application\Adapters\DatabaseAdapterInterface;
use Cgrd\Application\Logger\LoggerInterface;
use Cgrd\Application\Repositories\UsersRepositoryInterface;
use Cgrd\Infrastructure\Adapters\SqliteAdapter;
use Cgrd\Infrastructure\Controllers\AuthController;
use Cgrd\Infrastructure\Factories\FileLoggerFactory;
use Cgrd\Infrastructure\Factories\SqliteConnectionFactory;
use Cgrd\Infrastructure\Factories\UserEntityFactory;
use Cgrd\Infrastructure\Factories\UserModelFactory;
use Cgrd\Infrastructure\Handlers\AuthenticateUserHandler;
use Cgrd\Infrastructure\Handlers\LogoutUserHandler;
use Cgrd\Infrastructure\Logger\FileLogger;
use Cgrd\Infrastructure\Models\ServiceDefinition;
use Cgrd\Infrastructure\Repositories\UsersRepository;

return [
    new ServiceDefinition(
        'viewsStoragePath',
        fn (): string => VIEWS_BASE_PATH
    ),
    new ServiceDefinition(
        FileLogger::class,
        fn (): LoggerInterface => FileLoggerFactory::create()
    ),
    new ServiceDefinition(
        \PDO::class,
        fn (): \PDO => SqliteConnectionFactory::create()
    ),
    new ServiceDefinition(
        DatabaseAdapterInterface::class,
        fn (\PDO $connection): DatabaseAdapterInterface => new SqliteAdapter($connection)
    ),
    new ServiceDefinition(
        UserModelFactory::class,
        fn (): UserModelFactory => new UserModelFactory()
    ),
    new ServiceDefinition(
        UserEntityFactory::class,
        fn (): UserEntityFactory => new UserEntityFactory()
    ),
    new ServiceDefinition(
        UsersRepositoryInterface::class,
        fn (
            UserModelFactory $userModelFactory,
            UserEntityFactory $userEntityFactory,
            DatabaseAdapterInterface $databaseAdapter
        ): UsersRepositoryInterface => new UsersRepository(
            $userModelFactory,
            $userEntityFactory,
            $databaseAdapter
        )
    ),
    new ServiceDefinition(
        AuthenticateUserHandler::class,
        fn (UsersRepositoryInterface $usersRepository): AuthenticateUserHandler => new AuthenticateUserHandler(
            $usersRepository
        )
    ),
    new ServiceDefinition(
        LogoutUserHandler::class,
        fn (UsersRepositoryInterface $usersRepository): LogoutUserHandler => new LogoutUserHandler(
            $usersRepository
        )
    ),
    new ServiceDefinition(
        AuthController::class,
        fn (
            AuthenticateUserHandler $userHandler,
            LogoutUserHandler $logoutUserHandler,
            string $viewsStoragePath
        ): AuthController => new AuthController(
            $userHandler,
            $logoutUserHandler,
            $viewsStoragePath
        )
    ),
];
