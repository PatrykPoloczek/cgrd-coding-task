<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Models\UserInterface;
use Cgrd\Infrastructure\Entities\UserEntity;
use Cgrd\Infrastructure\Models\User;

class UserModelFactory
{
    public function createFromEntity(UserEntity $entity): UserInterface
    {
        return new User(
            $entity->getId(),
            $entity->getLogin(),
            $entity->getPassword(),
            $entity->getToken(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt()
        );
    }
}
