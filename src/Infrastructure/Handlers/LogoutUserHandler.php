<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Handlers;

use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Logger\LoggerInterface;
use Cgrd\Application\Repositories\UsersRepositoryInterface;
use Cgrd\Infrastructure\Builders\UserModelBuilder;
use Cgrd\Infrastructure\Http\Requests\AuthenticatedUserRequest;

class LogoutUserHandler
{
    public function __construct(
        private readonly UsersRepositoryInterface $usersRepository,
        private readonly UserModelBuilder $userModelBuilder,
        private readonly LoggerInterface $logger
    ) {
    }

    public function handle(AuthenticatedUserRequest $request): bool
    {
        $user = $request->getUser();
        $newModel = $this->userModelBuilder
            ->withId($user->getId())
            ->withLogin($user->getLogin())
            ->withPassword($user->getPassword())
            ->withoutToken()
            ->withCreatedAt($user->getCreatedAt())
            ->build()
        ;

        try {
            $this->usersRepository->update($newModel);

            return true;
        } catch (\PDOException $exception) {
            $this->logger->error(
                'Exception encountered.',
                [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
                ]
            );

            return false;
        }
    }
}
