<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Exceptions\DatabaseException;

class SqliteConnectionFactory
{
    public static function create(): \PDO
    {
        try {
            $dbPath = sprintf(
                'sqlite:%s/app.db',
                VAR_BASE_PATH
            );

            return new \PDO($dbPath);
        } catch (\PDOException $exception) {
            throw DatabaseException::createFromPdoException($exception);
        }
    }
}
