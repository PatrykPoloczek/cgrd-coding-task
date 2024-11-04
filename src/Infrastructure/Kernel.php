<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure;

use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Http\Routing\RouterInterface;
use Cgrd\Application\KernelInterface;
use Cgrd\Application\Models\PipelineInterface;
use Cgrd\Application\Storage\ContainerInterface;
use Cgrd\Infrastructure\Controllers\AuthController;
use Cgrd\Infrastructure\Factories\InMemoryContainerFactory;
use Cgrd\Infrastructure\Factories\RequestFactory;

class Kernel implements KernelInterface
{
    private const SUCCESS = 0;
    private const FAILURE = 1;

    private RequestFactory $requestFactory;

    private ContainerInterface $container;

    public function __construct()
    {
        $this->requestFactory = new RequestFactory();
    }

    public function bootstrap(): void
    {
        $this->container = InMemoryContainerFactory::create();
        var_dump(
            $this->container->getService(),
            $this->container->get('viewsStoragePath'),
            $this->container->get(AuthController::class)
        );exit;
    }

    public function run(): int
    {
        $this->bootstrap();

        return $this->handleRequest($this->requestFactory->createFromGlobals());
    }

    private function handleRequest(RequestInterface $request): int
    {
        try {
            /** @var RouterInterface $router */
            $router = $this->container->get(RouterInterface::class);
            $route = $router->resolve($request);

            if (empty($route->getPipeline())) {
                $response = $this->runPipeline($route->getPipeline(), $request);
            }

            return self::SUCCESS;
        } catch (\Throwable $exception) {
            return $exception->getCode() === self::SUCCESS
                ? self::FAILURE
                : $exception->getCode()
            ;
        }
    }

    /**
     * @return ?array<string, mixed>
     */
    private function runPipeline(PipelineInterface $pipeline, RequestInterface $request): ?array
    {
        try {
            $pipeline->run($request);

            return null;
        } catch (\Throwable $exception) {
            return [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ];
        }
    }
}
