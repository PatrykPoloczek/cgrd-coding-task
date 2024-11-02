<?php

declare(strict_types=1);

namespace Cgrd\Application\Models;

interface ServiceDefinitionInterface
{
    public function getDefinition(): \Closure;
    public function getName(): string;
}
