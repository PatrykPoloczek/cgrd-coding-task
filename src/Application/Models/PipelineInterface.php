<?php

declare(strict_types=1);

namespace Cgrd\Application\Models;

use Cgrd\Application\Http\RequestInterface;

interface PipelineInterface
{
    /** @var array<int, MiddlewareInterface> $middlewares */
    public function setMiddlewares(array $middlewares = []): self;
    /** @return array<int, MiddlewareInterface> */
    public function getMiddlewares(): array;
    public function run(RequestInterface $request): void;
}
