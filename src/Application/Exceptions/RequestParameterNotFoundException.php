<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

class RequestParameterNotFoundException extends \Exception
{
    public static function createFromParameterName(string $parameter): self
    {
        return new self(
            sprintf(
                'Requested parameter (%s) was not found.',
                $parameter
            )
        );
    }
}
