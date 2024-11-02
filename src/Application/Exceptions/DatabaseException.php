<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

class DatabaseException extends \Exception
{
    public static function createFromPdoException(\PDOException $previous): self
    {
        return new self(
            sprintf(
                'Unexpected database exception encountered. Original message: %s.',
                $previous->getMessage()
            ),
            $previous->getCode()
        );
    }
}
