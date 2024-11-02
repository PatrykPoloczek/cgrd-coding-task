<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

class RouteNotFoundException extends \Exception
{
    public static function createWithMethodAndPath(string $method, string $path): self
    {
        return new self(
            sprintf(
                'No matching route found for method (%s) and path (%s).',
                strtoupper($method),
                $path
            )
        );
    }
}
