<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

class UnsupportedRequestException extends \Exception
{
    public static function create(): self
    {
        return new self(
            'Unsupported request encountered.'
        );
    }
}
