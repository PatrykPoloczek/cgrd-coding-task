<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;

class ForbiddenException extends HttpException
{
    public static function create(): self
    {
        return new self(
            'Forbidden.',
            ResponseStatusCodeEnum::FORBIDDEN->value
        );
    }
}
