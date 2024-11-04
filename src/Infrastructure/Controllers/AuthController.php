<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Controllers;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;
use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Http\ResponseInterface;
use Cgrd\Infrastructure\Handlers\AuthenticateUserHandler;
use Cgrd\Infrastructure\Handlers\LogoutUserHandler;
use Cgrd\Infrastructure\Http\Requests\JsonRequest;
use Cgrd\Infrastructure\Http\Responses\JsonResponse;

class AuthController extends AbstractController
{
    public function __construct(
        private readonly AuthenticateUserHandler $authenticateUserHandler,
        private readonly LogoutUserHandler $logoutUserHandler,
        string $viewsStoragePath
    ) {
        parent::__construct($viewsStoragePath);
    }

    public function login(JsonRequest $request): ResponseInterface
    {
        $token = $this->authenticateUserHandler->handle();

        if (empty($token)) {
            return new JsonResponse(
                payload: [
                    'message' => ResponseStatusCodeEnum::UNAUTHORIZED->name,
                    'code' => ResponseStatusCodeEnum::UNAUTHORIZED->value,
                ],
                statusCode: ResponseStatusCodeEnum::UNAUTHORIZED
            );
        }

        return new JsonResponse(
            payload: [
                'token' => $token,
            ]
        );
    }

    public function logout(RequestInterface $request): ResponseInterface
    {
        if ($this->logoutUserHandler->handle()) {
            return new JsonResponse(
                payload: [
                    'message' => 'Could not log off the user. Please, try later.',
                    'code' => ResponseStatusCodeEnum::INTERNAL_SERVER_EXCEPTION,
                ],
                statusCode: ResponseStatusCodeEnum::INTERNAL_SERVER_EXCEPTION
            );
        }

        return new JsonResponse(
            payload: [
                'message' => 'User successfully logged off.',
            ]
        );
    }

    public function loginView()
    {
        return require_once $this->viewsStoragePath . '/auth/login.html';
    }
}
