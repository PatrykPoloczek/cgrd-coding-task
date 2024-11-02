<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Adapters;

use Cgrd\Application\Adapters\DatabaseAdapterInterface;
use Cgrd\Application\Entities\AbstractEntity;

class SqliteAdapter implements DatabaseAdapterInterface
{
    private const SEPARATOR = ',';

    public function __construct(
        private readonly \PDO $connection
    ) {
    }

    public function findOneOrDefault(
        string $table,
        string $entityClass,
        array $criteria = []): ?AbstractEntity
    {
        $conditions = [];

        foreach (array_keys($criteria) as $column) {
            $conditions[] = sprintf('%s = :%s', $column, $column);
        }

        $statement = $this->connection->prepare(
            sprintf(
                'SELECT * FROM %s %s %s LIMIT 1',
                $table,
                empty($conditions) ? '' : 'WHERE',
                implode(self::SEPARATOR, $conditions)
            )
        );
        $statement->execute($criteria);
        $results = $statement->fetchAll(SQLITE_ASSOC);

        if (empty($results)) {
            return null;
        }

        /** @var AbstractEntity $entityClass */
        return $entityClass::createFromDatabaseResult(array_shift($results));
    }
}
