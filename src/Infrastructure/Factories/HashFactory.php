<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Http\Routing\RouteInterface;

class HashFactory
{
    public static function createFromRoute(RouteInterface $route): string
    {
        return static::create($route->getMethod()->value, $route->getPath());
    }

    public static function createFromRequest(RequestInterface $request): string
    {
        return static::create($request->getMethod()->value, $request->getPath());
    }

    public static function createFromPassword(string $password): string
    {
        return password_hash(
            $password,
            PASSWORD_BCRYPT,
            [
                'cost' => 12,
            ]
        );
    }

    private static function create(string $method, string $path): string
    {
        return sha1(
            sprintf(
                '%s-%s',
                strtoupper($method),
                $path
            )
        );
    }
}
