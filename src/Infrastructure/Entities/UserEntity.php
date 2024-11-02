<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Entities;

use Cgrd\Application\Entities\AbstractEntity;

class UserEntity extends AbstractEntity
{
    public static function createFromDatabaseResult(array $data): AbstractEntity
    {
        return new self();
    }
}
