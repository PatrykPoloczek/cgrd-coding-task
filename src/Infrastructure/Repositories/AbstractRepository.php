<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Repositories;

use Cgrd\Application\Adapters\DatabaseAdapterInterface;

abstract class AbstractRepository
{
    public function __construct(
        protected readonly DatabaseAdapterInterface $databaseAdapter
    ) {
    }
}
