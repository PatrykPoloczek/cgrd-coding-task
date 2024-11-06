<?php

declare(strict_types=1);

namespace Cgrd\Application\Entities;

abstract class AbstractEntity
{
    protected const DATE_NOW = 'now';
    protected const DATE_FORMAT = 'Y-m-d H:i:s';

    public static abstract function createFromDatabaseResult(array $data): self;
    /** @return array<string, mixed> */
    public abstract function toArray(): array;
}
