<?php

declare(strict_types=1);

namespace Seeders;

use Cgrd\Application\Logger\LoggerInterface;
use Cgrd\Infrastructure\Factories\DefaultLoggerFactory;
use Cgrd\Infrastructure\Factories\SqliteConnectionFactory;

class SeedHandler
{
    private const SEEDS_TO_RUN = [
        Seed_1730590446::class,
        Seed_1730590449::class,
    ];

    private readonly \PDO $connection;
    private readonly LoggerInterface $logger;

    public function __construct()
    {
        $this->connection = SqliteConnectionFactory::create();
        $this->logger = DefaultLoggerFactory::create();
    }

    public function seed(): void
    {
        $this->logger->info('Starting seeding.');

        try {
            foreach (self::SEEDS_TO_RUN as $seed) {
                $this->logger->debug(sprintf(
                    'Currently processed migration: %s.',
                    $seed
                ));

                /** @var SeederInterface $instance */
                $instance = new $seed;

                foreach ($instance->getQueries() as $query) {
                    $statement = $this->connection->prepare($query);
                    $statement->execute();
                }
            }
        } catch (\PDOException $exception) {
            $this->logger->error(
                'Exception encountered during seeding.',
                [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
                ]
            );
            exit;
        }

        $this->logger->info('Seeding process successfully finished.');
    }
}
