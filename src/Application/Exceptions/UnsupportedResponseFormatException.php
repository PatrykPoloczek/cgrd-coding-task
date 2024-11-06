<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;

class UnsupportedResponseFormatException extends \Exception
{
    public static function create(): self
    {
        return new self(
            'Requested response format different from JSON.',
            ResponseStatusCodeEnum::BAD_REQUEST->value
        );
    }
}
