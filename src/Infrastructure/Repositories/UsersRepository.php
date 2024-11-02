<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Repositories;

use Cgrd\Application\Models\UserInterface;
use Cgrd\Application\Repositories\UsersRepositoryInterface;
use Cgrd\Infrastructure\Entities\UserEntity;
use Cgrd\Infrastructure\Factories\HashFactory;

class UsersRepository extends AbstractRepository implements UsersRepositoryInterface
{
    private const TABLE_NAME = 'users';

    public function findOneByLoginAndPassword(string $login, string $password): ?UserInterface
    {
        $entity = $this->databaseAdapter->findOneOrDefault(
            self::TABLE_NAME,
            UserEntity::class,
            [
                'login' => $login,
                'password' => HashFactory::createFromPassword($password),
            ]
        );

        return $entity ?? null;
    }
}
