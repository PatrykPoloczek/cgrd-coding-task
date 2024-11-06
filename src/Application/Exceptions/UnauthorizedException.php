<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;

class UnauthorizedException extends HttpException
{
    public static function create(): self
    {
        return new self(
            'Unauthorized.',
            ResponseStatusCodeEnum::UNAUTHORIZED->value
        );
    }

    public static function tokenMissing(): self
    {
        return new self(
            'Unauthorized. Authorization token was not provided.',
            ResponseStatusCodeEnum::UNAUTHORIZED->value
        );
    }
}
