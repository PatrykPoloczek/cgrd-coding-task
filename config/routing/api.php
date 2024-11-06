<?php

declare(strict_types=1);

use Cgrd\Infrastructure\Controllers\AuthController;
use Cgrd\Infrastructure\Controllers\UpdateNewsArticleController;
use Cgrd\Infrastructure\Http\Routing\Route;
use Cgrd\Infrastructure\Middlewares\EnsureJsonFormatIsAcceptable;
use Cgrd\Infrastructure\Middlewares\HasAccessToArticle;
use Cgrd\Infrastructure\Middlewares\VerifyAuthToken;
use Cgrd\Infrastructure\Models\Pipeline;

return [
    Route::get(
        path: '/api/v1/auth',
        controller: AuthController::class,
        controllerAction: 'loginView'
    ),
    Route::post(
        path: '/api/v1/auth',
        controller: AuthController::class,
        controllerAction: 'login',
        pipeline: new Pipeline([
            EnsureJsonFormatIsAcceptable::class,
        ])
    ),
    Route::delete(
        path: '/api/v1/auth',
        controller: AuthController::class,
        controllerAction: 'logout',
        pipeline: new Pipeline([
            EnsureJsonFormatIsAcceptable::class,
            VerifyAuthToken::class
        ])
    ),
    Route::patch(
        path: '/api/v1/articles/{id}',
        controller: UpdateNewsArticleController::class,
        pipeline: new Pipeline([
            EnsureJsonFormatIsAcceptable::class,
            VerifyAuthToken::class,
            HasAccessToArticle::class,
        ])
    ),
];
