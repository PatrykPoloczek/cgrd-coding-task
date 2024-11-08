<?php

declare(strict_types=1);

use Cgrd\Application\Adapters\DatabaseAdapterInterface;
use Cgrd\Application\Http\Routing\RouterInterface;
use Cgrd\Application\Logger\LoggerInterface;
use Cgrd\Application\Models\MiddlewareInterface;
use Cgrd\Application\Repositories\ArticlesRepositoryInterface;
use Cgrd\Application\Repositories\UsersRepositoryInterface;
use Cgrd\Application\Validation\Validators\ValidatorInterface;
use Cgrd\Infrastructure\Adapters\SqliteAdapter;
use Cgrd\Infrastructure\Builders\UserModelBuilder;
use Cgrd\Infrastructure\Controllers\AuthController;
use Cgrd\Infrastructure\Controllers\CreateNewsArticleController;
use Cgrd\Infrastructure\Controllers\DeleteNewsArticleController;
use Cgrd\Infrastructure\Controllers\GetAllArticlesController;
use Cgrd\Infrastructure\Controllers\UpdateNewsArticleController;
use Cgrd\Infrastructure\Factories\ArticleEntityFactory;
use Cgrd\Infrastructure\Factories\ArticleModelFactory;
use Cgrd\Infrastructure\Factories\FileLoggerFactory;
use Cgrd\Infrastructure\Factories\Partials\DefaultRequestFactory;
use Cgrd\Infrastructure\Factories\Partials\JsonRequestFactory;
use Cgrd\Infrastructure\Factories\RequestFactory;
use Cgrd\Infrastructure\Factories\SqliteConnectionFactory;
use Cgrd\Infrastructure\Factories\UserEntityFactory;
use Cgrd\Infrastructure\Factories\UserModelFactory;
use Cgrd\Infrastructure\Handlers\AuthenticateUserHandler;
use Cgrd\Infrastructure\Handlers\CreateArticleHandler;
use Cgrd\Infrastructure\Handlers\DeleteArticleHandler;
use Cgrd\Infrastructure\Handlers\GetAllArticlesHandler;
use Cgrd\Infrastructure\Handlers\LogoutUserHandler;
use Cgrd\Infrastructure\Handlers\PipelineHandler;
use Cgrd\Infrastructure\Handlers\UpdateArticleHandler;
use Cgrd\Infrastructure\Http\Routing\Router;
use Cgrd\Infrastructure\Middlewares\EnsureJsonFormatIsAcceptable;
use Cgrd\Infrastructure\Middlewares\HasAccessToArticle;
use Cgrd\Infrastructure\Middlewares\VerifyAuthToken;
use Cgrd\Infrastructure\Models\ServiceDefinition;
use Cgrd\Infrastructure\Repositories\ArticlesRepository;
use Cgrd\Infrastructure\Repositories\UsersRepository;
use Cgrd\Infrastructure\Validation\Validators\DefaultValidator;

return [
    new ServiceDefinition(
        'viewsStoragePath',
        fn (): string => VIEWS_BASE_PATH
    ),
    new ServiceDefinition(
        LoggerInterface::class,
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
        fn (
            UsersRepositoryInterface $usersRepository,
            UserModelBuilder $userModelBuilder
        ): AuthenticateUserHandler => new AuthenticateUserHandler(
            $usersRepository,
            $userModelBuilder
        )
    ),
    new ServiceDefinition(
        LogoutUserHandler::class,
        fn (
            UsersRepositoryInterface $usersRepository,
            UserModelBuilder $userModelBuilder,
            LoggerInterface $logger
        ): LogoutUserHandler => new LogoutUserHandler(
            $usersRepository,
            $userModelBuilder,
            $logger
        )
    ),
    new ServiceDefinition(
        AuthController::class,
        fn (
            AuthenticateUserHandler $userHandler,
            LogoutUserHandler $logoutUserHandler,
            ValidatorInterface $validator,
            string $viewsStoragePath
        ): AuthController => new AuthController(
            $userHandler,
            $logoutUserHandler,
            $validator,
            $viewsStoragePath
        )
    ),
    new ServiceDefinition(
        DefaultRequestFactory::class,
        fn (): DefaultRequestFactory => new DefaultRequestFactory()
    ),
    new ServiceDefinition(
        JsonRequestFactory::class,
        fn (): JsonRequestFactory => new JsonRequestFactory()
    ),
    new ServiceDefinition(
        'factories',
        fn (
            JsonRequestFactory $jsonRequestFactory,
            DefaultRequestFactory $defaultRequestFactory
        ): array => [
            $jsonRequestFactory,
            $defaultRequestFactory,
        ]
    ),
    new ServiceDefinition(
        RequestFactory::class,
        fn (array $factories): RequestFactory => new RequestFactory($factories)
    ),
    new ServiceDefinition(
        RouterInterface::class,
        fn (): RouterInterface => new Router()
    ),
    new ServiceDefinition(
        PipelineHandler::class,
        fn (LoggerInterface $logger): PipelineHandler => new PipelineHandler($logger)
    ),
    new ServiceDefinition(
        EnsureJsonFormatIsAcceptable::class,
        fn (): MiddlewareInterface => new EnsureJsonFormatIsAcceptable(),
    ),
    new ServiceDefinition(
        VerifyAuthToken::class,
        fn (UsersRepositoryInterface $usersRepository): MiddlewareInterface => new VerifyAuthToken(
            $usersRepository
        )
    ),
    new ServiceDefinition(
        UserModelBuilder::class,
        fn (): UserModelBuilder => new UserModelBuilder()
    ),
    new ServiceDefinition(
        ArticleModelFactory::class,
        fn (): ArticleModelFactory => new ArticleModelFactory()
    ),
    new ServiceDefinition(
        ArticleEntityFactory::class,
        fn (): ArticleEntityFactory => new ArticleEntityFactory()
    ),
    new ServiceDefinition(
        ArticlesRepositoryInterface::class,
        fn (
            ArticleModelFactory $articleModelFactory,
            ArticleEntityFactory $articleEntityFactory,
            DatabaseAdapterInterface $databaseAdapter
        ): ArticlesRepositoryInterface => new ArticlesRepository(
            $articleModelFactory,
            $articleEntityFactory,
            $databaseAdapter
        )
    ),
    new ServiceDefinition(
        HasAccessToArticle::class,
        fn (ArticlesRepositoryInterface $articlesRepository): MiddlewareInterface => new HasAccessToArticle(
            $articlesRepository
        )
    ),
    new ServiceDefinition(
        GetAllArticlesHandler::class,
        fn (ArticlesRepositoryInterface $articlesRepository): GetAllArticlesHandler => new GetAllArticlesHandler(
            $articlesRepository
        )
    ),
    new ServiceDefinition(
        GetAllArticlesController::class,
        fn (
            GetAllArticlesHandler $getAllArticlesHandler
        ): GetAllArticlesController => new GetAllArticlesController($getAllArticlesHandler)
    ),
    new ServiceDefinition(
        ValidatorInterface::class,
        fn (): ValidatorInterface => new DefaultValidator()
    ),
    new ServiceDefinition(
        CreateArticleHandler::class,
        fn (
            ArticlesRepositoryInterface $articlesRepository,
            ValidatorInterface $validator,
            ArticleModelFactory $articleModelFactory
        ): CreateArticleHandler => new CreateArticleHandler(
            $articlesRepository,
            $validator,
            $articleModelFactory
        )
    ),
    new ServiceDefinition(
        CreateNewsArticleController::class,
        fn (
            CreateArticleHandler $createArticleHandler
        ): CreateNewsArticleController => new CreateNewsArticleController(
            $createArticleHandler
        )
    ),
    new ServiceDefinition(
        DeleteNewsArticleController::class,
        fn (
            DeleteArticleHandler $handler
        ): DeleteNewsArticleController => new DeleteNewsArticleController(
            $handler
        )
    ),
    new ServiceDefinition(
        DeleteArticleHandler::class,
        fn (
            ArticlesRepositoryInterface $articlesRepository
        ): DeleteArticleHandler => new DeleteArticleHandler($articlesRepository)
    ),
    new ServiceDefinition(
        UpdateArticleHandler::class,
        fn (
            ArticlesRepositoryInterface $articlesRepository,
            ValidatorInterface $validator,
            ArticleModelFactory $articleModelFactory
        ): UpdateArticleHandler => new UpdateArticleHandler(
            $articlesRepository,
            $validator,
            $articleModelFactory
        )
    ),
    new ServiceDefinition(
        UpdateNewsArticleController::class,
        fn (
            UpdateArticleHandler $updateArticleHandler
        ): UpdateNewsArticleController => new UpdateNewsArticleController(
            $updateArticleHandler
        )
    ),
];
