<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Models\UserInterface;
use Cgrd\Infrastructure\Entities\UserEntity;

class UserEntityFactory
{
    public function createFromModel(UserInterface $model): UserEntity
    {
        return new UserEntity(
            $model->getId(),
            $model->getLogin(),
            $model->getPassword(),
            $model->getToken(),
            $model->getCreatedAt(),
            $model->getUpdatedAt()
        );
    }
}
