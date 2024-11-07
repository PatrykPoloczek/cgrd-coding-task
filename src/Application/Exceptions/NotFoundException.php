<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;

class NotFoundException extends HttpException
{
    public static function create(): self
    {
        return new self(
            message: 'Not found.',
            code: ResponseStatusCodeEnum::NOT_FOUND->value
        );
    }
}
