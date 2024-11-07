<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Controllers;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;
use Cgrd\Application\Http\ResponseInterface;
use Cgrd\Application\Validation\Validators\ValidatorInterface;
use Cgrd\Infrastructure\Handlers\AuthenticateUserHandler;
use Cgrd\Infrastructure\Handlers\LogoutUserHandler;
use Cgrd\Infrastructure\Http\Requests\AuthenticatedUserRequest;
use Cgrd\Infrastructure\Http\Requests\JsonRequest;
use Cgrd\Infrastructure\Http\Responses\JsonResponse;
use Cgrd\Infrastructure\Models\Dtos\LoginInputDto;

class AuthController extends AbstractController
{
    public function __construct(
        private readonly AuthenticateUserHandler $authenticateUserHandler,
        private readonly LogoutUserHandler $logoutUserHandler,
        private readonly ValidatorInterface $validator,
        string $viewsStoragePath
    ) {
        parent::__construct($viewsStoragePath);
    }

    public function login(JsonRequest $request): ResponseInterface
    {
        /** @var LoginInputDto $dto */
        $dto = $this->validator->validate(
            $request->getContent(),
            LoginInputDto::class
        );
        $token = $this->authenticateUserHandler->handle(
            $dto->getUsername(),
            $dto->getPassword()
        );

        if (empty($token)) {
            return new JsonResponse(
                payload: [
                    'message' => 'Unauthorized.',
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

    public function logout(AuthenticatedUserRequest $request): ResponseInterface
    {
        if (!$this->logoutUserHandler->handle($request)) {
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
