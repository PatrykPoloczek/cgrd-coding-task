<?php

namespace Cgrd\Application\Exceptions;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;

class RecordCouldNotHaveBeenCreatedException extends HttpException
{
    public static function createFromException(\PDOException $exception, string $class): self
    {
        return new self(
            sprintf(
                'Record of class %s could not have been created.',
                $class
            ),
            ResponseStatusCodeEnum::INTERNAL_SERVER_EXCEPTION->value,
            $exception
        );
    }
}