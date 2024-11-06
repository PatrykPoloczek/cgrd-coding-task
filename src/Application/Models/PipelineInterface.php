<?php

declare(strict_types=1);

namespace Cgrd\Application\Models;

use Cgrd\Application\Http\RequestInterface;

interface PipelineInterface
{
    /** @var array<int, string> $middlewares */
    public function setMiddlewares(array $middlewares = []): self;
    /** @return array<int, string> */
    public function getMiddlewares(): array;
}
