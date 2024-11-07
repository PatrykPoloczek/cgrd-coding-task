<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;

class RecordCouldNotHaveBeenUpdatedException extends HttpException
{
    public static function createFromException(\PDOException $exception, string $class): self
    {
        return new self(
            sprintf(
                'Record of class %s could not have been updated.',
                $class
            ),
            ResponseStatusCodeEnum::INTERNAL_SERVER_EXCEPTION->value,
            $exception
        );
    }
}
