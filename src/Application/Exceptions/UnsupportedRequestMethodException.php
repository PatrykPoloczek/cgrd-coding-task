<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

class UnsupportedRequestMethodException extends \Exception
{
    public static function create(string $method): self
    {
        return new self(
            sprintf(
                'Request method (%s) is not supported.',
                $method
            )
        );
    }
}
