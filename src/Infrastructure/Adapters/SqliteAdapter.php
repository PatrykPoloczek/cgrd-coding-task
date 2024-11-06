<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Adapters;

use Cgrd\Application\Adapters\DatabaseAdapterInterface;
use Cgrd\Application\Entities\AbstractEntity;

class SqliteAdapter implements DatabaseAdapterInterface
{
    private const DEFAULT_SEPARATOR = ',';
    private const AND_SEPARATOR = ' AND ';

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
            : sprintf('WHERE %s', implode(self::DEFAULT_SEPARATOR, $conditions))
        ;

        $statement = $this->connection->prepare(
            sprintf(
                'SELECT * FROM %s %s LIMIT 1',
                $table,
                $conditionStatement
            )
        );
        $statement->execute($criteria);
        $results = $statement->fetchAll();

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
                implode(self::DEFAULT_SEPARATOR, array_keys($parameters)),
                implode(self::DEFAULT_SEPARATOR, $parameters)
            )
        );
        $statement->execute();
    }

    public function update(\Closure $transformer, string $table, array $conditions): void
    {
        /** @var array<string, mixed> $parameters */
        $parameters = $transformer();
        unset($parameters['id']);
        $set = [];
        $where = [];
        foreach ($parameters as $key => $value) {
            $value = is_string($value ?? "")
                ? '"' . $value . '"'
                : $value
            ;
            $set[] = "{$key} = {$value}";
        }
        foreach ($conditions as $key => $value) {
            if (is_null($value)) {
                $where = "{$key} IS NULL";

                continue;
            }

            $value = is_string($value)
                ? '"' . $value . '"'
                : $value
            ;
            $where[] = "{$key} = {$value}";
        }

        $statement = $this->connection->prepare(
            sprintf(
                'UPDATE %s SET %s WHERE %s',
                $table,
                implode(self::DEFAULT_SEPARATOR, $set),
                implode(self::AND_SEPARATOR, $where),
            )
        );
        $statement->execute();
    }
}
