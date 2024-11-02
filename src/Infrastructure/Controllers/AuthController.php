<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Controllers;

use Cgrd\Infrastructure\Handlers\AuthenticateUserHandler;

class AuthController extends AbstractController
{
    public function __construct(
        private readonly AuthenticateUserHandler $authenticateUserHandler
    ) {
    }

    public function login()
    {
    }

    public function logout()
    {
    }

    public function loginView()
    {
        return require_once $this->viewsStoragePath . '/auth/login.html';
    }
}
