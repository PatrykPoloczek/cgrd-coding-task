<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

class RouteAlreadyDefinedException extends \Exception
{
    public static function createWithMethodAndPath(string $method, string $path): self
    {
        return new self(
            sprintf(
                'Route for method (%s) and path (%s) is already defined.',
                $method,
                $path
            )
        );
    }
}
