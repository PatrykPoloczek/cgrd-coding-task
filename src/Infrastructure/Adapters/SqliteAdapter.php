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
        array $criteria = []
    ): ?AbstractEntity {
        $conditions = [];

        foreach (array_keys($criteria) as $column) {
            $conditions[] = sprintf('%s = :%s', $column, $column);
        }

        $conditionStatement = empty($conditions)
            ? ''
            : sprintf('WHERE %s', implode(self::SEPARATOR, $conditions))
        ;

        $statement = $this->connection->prepare(
            sprintf(
                'SELECT * FROM %s %s LIMIT 1',
                $table,
                $conditionStatement
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

    public function insert(\Closure $transformer, string $table): void
    {
        /** @var array<string, mixed> $parameters */
        $parameters = $transformer();
        $statement = $this->connection->prepare(
            sprintf(
                'INSERT INTO %s (%s) VALUES (%s)',
                $table,
                implode(self::SEPARATOR, array_keys($parameters)),
                implode(self::SEPARATOR, $parameters)
            )
        );
        $statement->execute();
    }

    public function update(\Closure $transformer, string $table): void
    {
        // TODO: Implement update() method.
    }
}
