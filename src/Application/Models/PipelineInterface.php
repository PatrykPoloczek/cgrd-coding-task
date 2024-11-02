<?php

declare(strict_types=1);

namespace Cgrd\Application\Models;

interface PipelineInterface
{
    /** @var array<int, MiddlewearInterface> $middlewears */
    public function setMiddlewears(array $middlewears = []): self;
    /** @return array<int, MiddlewearInterface> */
    public function getMiddlewears(): array;
}
