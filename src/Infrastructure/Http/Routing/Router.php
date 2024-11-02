<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Http\Routing;

use Cgrd\Application\Exceptions\RouteAlreadyDefinedException;
use Cgrd\Application\Exceptions\RouteNotFoundException;
use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Http\ResponseInterface;
use Cgrd\Application\Http\Routing\RouteInterface;
use Cgrd\Application\Http\Routing\RouterInterface;
use Cgrd\Infrastructure\Factories\HashFactory;

class Router implements RouterInterface
{
    private array $routes = [];

    public function register(): void
    {
        $configPath = sprintf(
            '%s/routing/api.php',
            CONFIG_BASE_PATH
        );

        foreach (require_once $configPath as $route) {
            $this->registerRoute($route);
        }
    }

    public function resolve(RequestInterface $request): ResponseInterface
    {
        $hash = HashFactory::createFromRequest($request);

        if (!$this->hasRoute($hash)) {
            throw RouteNotFoundException::createWithMethodAndPath(
                $request->getMethod()->value,
                $request->getPath()
            );
        }

        $route = $this->routes[$hash];

        return $this->routes[$hash];
    }

    private function registerRoute(RouteInterface $route): void
    {
        $hash = HashFactory::createFromRoute($route);

        if ($this->hasRoute($hash)) {
            throw RouteAlreadyDefinedException::createWithMethodAndPath(
                $route->getMethod()->value,
                $route->getPath()
            );
        }

        $this->routes[$hash] = $route;
    }

    private function hasRoute(string $hash): bool
    {
        return array_key_exists($hash, $this->routes);
    }
}
