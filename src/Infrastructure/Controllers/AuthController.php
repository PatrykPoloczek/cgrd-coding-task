<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Controllers;

class AuthController extends AbstractController
{
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
