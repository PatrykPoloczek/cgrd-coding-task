<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Handlers;

use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Logger\LoggerInterface;
use Cgrd\Application\Models\MiddlewareInterface;
use Cgrd\Application\Models\PipelineInterface;
use Cgrd\Application\Storage\ContainerInterface;

class PipelineHandler
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    public function handle(
        RequestInterface $request,
        ContainerInterface $container,
        ?PipelineInterface $pipeline = null
    ): RequestInterface {
        if (empty($pipeline) || empty($pipeline->getMiddlewares())) {
            return $request;
        }

        $middlewares = $pipeline->getMiddlewares();
        for ($i = 0; $i < count($middlewares); $i++) {
            $this->logger->info(sprintf(
                '[%d/%d] Currently processed middleware: %s.',
                $i + 1,
                count($middlewares),
                $middlewares[$i]
            ));
            /** @var MiddlewareInterface $current */
            $current = $container->get($middlewares[$i]);
            $next = $middlewares[$i +1] ?? null;
            $next = empty($next)
                ? null
                : $container->get($next)
            ;
            $current->handle($request, fn () => $next);
        }

        return $request;
    }
}
