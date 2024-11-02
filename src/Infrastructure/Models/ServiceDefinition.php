<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Models;

use Cgrd\Application\Models\ServiceDefinitionInterface;

class ServiceDefinition implements ServiceDefinitionInterface
{
    public function __construct(
        private readonly string $name,
        private readonly \Closure $definition
    ) {
    }

    public function getDefinition(): \Closure
    {
        return $this->definition;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
