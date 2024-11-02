<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

class DefinitionAlreadySetException extends \Exception
{
    public static function createWithServiceName(string $serviceName): self
    {
        return new self(
            sprintf(
                'Definition for service (%s) already present.',
                $serviceName
            )
        );
    }
}
