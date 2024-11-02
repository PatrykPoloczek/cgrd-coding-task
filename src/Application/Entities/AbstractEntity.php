<?php

declare(strict_types=1);

namespace Cgrd\Application\Entities;

abstract class AbstractEntity
{
    public static abstract function createFromDatabaseResult(array $data): self;
}
