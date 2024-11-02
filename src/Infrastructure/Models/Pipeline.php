<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Models;

use Cgrd\Application\Models\MiddlewearInterface;
use Cgrd\Application\Models\PipelineInterface;

class Pipeline implements PipelineInterface
{
    /** @var array<int, MiddlewearInterface> $middlewears */
    public function __construct(
        private array $middlewears = []
    ) {
    }

    /** @inheritDoc */
    public function setMiddlewears(array $middlewears = []): self
    {
        $collection = [];

        foreach ($middlewears as $middlewear)
        {
            if (!$middlewear instanceof MiddlewearInterface) {
                continue;
            }

            $collection[] = $middlewear;
        }

        $this->middlewears = $collection;

        return $this;
    }

    /** @inheritDoc */
    public function getMiddlewears(): array
    {
        return $this->middlewears;
    }
}
