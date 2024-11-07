<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;

class RecordCouldNotHaveBeenDeletedException extends HttpException
{
    public static function createFromException(\PDOException $exception, string $class): self
    {
        return new self(
            sprintf(
                'Record of class %s could not have been deleted.',
                $class
            ),
            ResponseStatusCodeEnum::INTERNAL_SERVER_EXCEPTION->value,
            $exception
        );
    }
}
