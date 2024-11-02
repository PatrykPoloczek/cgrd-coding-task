<?php

declare(strict_types=1);

namespace Cgrd\Application\Adapters;

use Cgrd\Application\Entities\AbstractEntity;

interface DatabaseAdapterInterface
{
    public function findOneOrDefault(
        string $table,
        string $entityClass,
        array $criteria = []
    ): ?AbstractEntity;
}
