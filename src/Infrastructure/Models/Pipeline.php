<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Models;

use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Models\PipelineInterface;

class Pipeline implements PipelineInterface
{
    /** @var array<int, string> $middlewares */
    public function __construct(
        private array $middlewares = []
    ) {
    }

    /** @inheritDoc */
    public function setMiddlewares(array $middlewares = []): self
    {
        $this->middlewares = $middlewares;

        return $this;
    }

    /** @inheritDoc */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function run(RequestInterface $request): void
    {
        if (empty($this->middlewares)) {
            return;
        }

        for ($i = 0; $i < count($this->middlewares); $i++) {
            $current = $this->middlewares[$i];
            $next = $this->middlewares[$i +1] ?? null;
            $current->handle($request, $next);
        }
    }
}
