<?php

declare(strict_types=1);

use Cgrd\Infrastructure\Controllers\AuthController;
use Cgrd\Infrastructure\Http\Routing\Route;

return [
    Route::get(
        '/auth',
        AuthController::class,
        'loginView'
    ),
    Route::post(
        '/auth',
        AuthController::class,
        'login'
    ),
    Route::delete(
        '/auth',
        AuthController::class,
        'logout'
    ),
];
