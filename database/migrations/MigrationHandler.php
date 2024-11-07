<?php

declare(strict_types=1);

namespace Migrations;

use Cgrd\Application\Logger\LoggerInterface;
use Cgrd\Infrastructure\Factories\DefaultLoggerFactory;
use Cgrd\Infrastructure\Factories\SqliteConnectionFactory;

class MigrationHandler
{
    private const MIGRATIONS_TO_RUN = [
        Migration_1730590446::class,
        Migration_1730590449::class,
    ];

    private readonly \PDO $connection;
    private readonly LoggerInterface $logger;

    public function __construct()
    {
        $this->connection = SqliteConnectionFactory::create();
        $this->logger = DefaultLoggerFactory::create();
    }

    public function migrate(bool $fresh = false): void
    {
        if ($fresh) {
            $this->rollback();
        }

        $this->logger->info('Starting migration.');

        try {
            foreach (self::MIGRATIONS_TO_RUN as $migration) {
                $this->logger->debug(sprintf(
                    'Currently processed migration: %s.',
                    $migration
                ));

                /** @var MigrationInterface $instance */
                $instance = new $migration;
                foreach ($instance->up() as $query) {
                    $statement = $this->connection->prepare($query);
                    $statement->execute();
                }
            }
        } catch (\PDOException $exception) {
            $this->logger->error(
                'Exception encountered during migration.',
                [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
                ]
            );
            exit;
        }

        $this->logger->info('Migration process finished successfully.');
    }

    private function rollback(): void
    {
        $this->logger->info('Starting rollback.');

        try {
            foreach (self::MIGRATIONS_TO_RUN as $migration) {
                $this->logger->debug(sprintf(
                    'Currently processed rollback: %s.',
                    $migration
                ));

                /** @var MigrationInterface $instance */
                $instance = new $migration;
                $statement = $this->connection->prepare($instance->down());
                $statement->execute();
            }
        } catch (\PDOException $exception) {
            $this->logger->error(
                'Exception encountered during rollback.',
                [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
                ]
            );
            exit;
        }

        $this->logger->info('Rollback process finished successfully.');
    }
}
