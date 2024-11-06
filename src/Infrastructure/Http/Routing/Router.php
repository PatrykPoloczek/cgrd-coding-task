<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Http\Routing;

use Cgrd\Application\Enums\RequestMethodEnum;
use Cgrd\Application\Exceptions\RouteAlreadyDefinedException;
use Cgrd\Application\Exceptions\RouteNotFoundException;
use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Http\Routing\RouteInterface;
use Cgrd\Application\Http\Routing\RouterInterface;
use Cgrd\Infrastructure\Factories\HashFactory;

class Router implements RouterInterface
{
    private const SEPARATOR = '/';
    private const WILDCARD_REGEX_PATTERN = '/{([a-zA-Z]+)}/s';

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

    public function resolve(RequestInterface &$request): RouteInterface
    {
        $routes = $this->routes[$request->getMethod()->value] ?? [];

        $requestSegments = explode(self::SEPARATOR, $request->getPath());

        /** @var RouteInterface $route */
        foreach ($routes as $route) {
            $routeSegments = explode(self::SEPARATOR, $route->getPath());

            if (count($requestSegments) !== count($routeSegments)) {
                continue;
            }

            if (!$this->tryToMatch($request, $requestSegments, $routeSegments)) {
                continue;
            }

            return $route;
        }

        throw RouteNotFoundException::createWithMethodAndPath(
            $request->getMethod()->value,
            $request->getPath()
        );
    }

    private function registerRoute(RouteInterface $route): void
    {
        $hash = HashFactory::createFromRoute($route);
        $method = $route->getMethod()->value;

        if ($this->hasRoute($method, $hash)) {
            throw RouteAlreadyDefinedException::createWithMethodAndPath(
                $method,
                $route->getPath()
            );
        }

        $this->routes[$method][$hash] = $route;
    }

    private function hasRoute(string $method, string $hash): bool
    {
        return array_key_exists($hash, $this->routes[$method] ?? []);
    }

    private function tryToMatch(
        RequestInterface &$request,
        array $requestSegments,
        array $routeSegments
    ): bool {
        for ($i = 0; $i < count($routeSegments); $i++) {
            $segment = $routeSegments[$i];
            $matches = [];
            preg_match_all(
                self::WILDCARD_REGEX_PATTERN,
                $segment,
                $matches
            );
            $isWildcard = !empty($matches[1]);

            if ($isWildcard) {
                $key = array_shift($matches[1]);
                $request->setParameter($key, $requestSegments[$i]);

                continue;
            }

            if ($segment !== $requestSegments[$i]) {
                return false;
            }
        }

        return true;
    }
}
