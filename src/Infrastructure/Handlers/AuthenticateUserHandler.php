<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Handlers;

use Cgrd\Application\Repositories\UsersRepositoryInterface;
use Cgrd\Infrastructure\Builders\UserModelBuilder;
use Cgrd\Infrastructure\Factories\HashFactory;

class AuthenticateUserHandler
{
    public function __construct(
        private readonly UsersRepositoryInterface $usersRepository,
        private readonly UserModelBuilder $userModelBuilder
    ) {
    }

    public function handle(string $login, string $password): ?string
    {
        $user = $this->usersRepository->findOneByLogin($login);

        if (empty($user) || !password_verify($password, $user->getPassword())) {
            return null;
        }

        $token = HashFactory::createFromUserAndTimestamp($user);
        $newModel = $this->userModelBuilder
            ->withId($user->getId())
            ->withLogin($user->getLogin())
            ->withPassword($user->getPassword())
            ->withToken($token)
            ->withCreatedAt($user->getCreatedAt())
            ->build()
        ;

        $this->usersRepository->update($newModel);

        return $token;
    }
}
