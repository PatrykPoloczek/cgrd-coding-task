<?php

declare(strict_types=1);

namespace Cgrd\Application\Adapters;

use Cgrd\Application\Entities\AbstractEntity;

interface DatabaseAdapterInterface
{
    public const DEFAULT_OFFSET = 0;
    public const DEFAULT_LIMIT = 10;

    public function findOneOrDefault(
        string $table,
        string $entityClass,
        array $criteria = []
    ): ?AbstractEntity;

    /**
     * @return array<int, AbstractEntity>
     */
    public function findAllBy(
        string $table,
        string $entityClass,
        array $criteria = [],
        $offset = self::DEFAULT_OFFSET,
        $limit = self::DEFAULT_LIMIT
    ): array;

    public function insert(
        \Closure $transformer,
        string $table
    ): void;

    public function update(
        \Closure $transformer,
        string $table,
        array $conditions
    ): void;
}
