<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Repositories;

use Cgrd\Application\Adapters\DatabaseAdapterInterface;
use Cgrd\Application\Models\UserInterface;
use Cgrd\Application\Repositories\UsersRepositoryInterface;
use Cgrd\Infrastructure\Entities\UserEntity;
use Cgrd\Infrastructure\Factories\HashFactory;
use Cgrd\Infrastructure\Factories\UserEntityFactory;
use Cgrd\Infrastructure\Factories\UserModelFactory;

class UsersRepository extends AbstractRepository implements UsersRepositoryInterface
{
    private const TABLE_NAME = 'users';

    public function __construct(
        private readonly UserModelFactory $userModelFactory,
        private readonly UserEntityFactory $userEntityFactory,
        DatabaseAdapterInterface $databaseAdapter
    ) {
        parent::__construct($databaseAdapter);
    }

    public function findOneByLoginAndPassword(string $login, string $password): ?UserInterface
    {
        /** @var UserEntity $entity */
        $entity = $this->databaseAdapter->findOneOrDefault(
            self::TABLE_NAME,
            UserEntity::class,
            [
                'login' => $login,
                'password' => HashFactory::createFromPassword($password),
            ]
        );

        return empty($entity)
            ? null
            : $this->userModelFactory->createFromEntity($entity)
        ;
    }

    public function insert(UserInterface $model): void
    {
        $this->save($model);
    }

    public function update(UserInterface $model): void
    {
        $this->save($model, true);
    }

    private function save(UserInterface $model, bool $update = false): void
    {
        $entity = $this->userEntityFactory->createFromModel($model);

        match ($update) {
            true => $this->databaseAdapter->update(
                fn () => $entity->toArray(),
                self::TABLE_NAME
            ),
            default => $this->databaseAdapter->insert(
                fn () => $entity->toArray(),
                self::TABLE_NAME
            )
        };
    }
}
