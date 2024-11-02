<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

class DefinitionNotFoundException extends \Exception
{
    public static function createWithServiceName(string $serviceName): self
    {
        return new self(
            sprintf(
                'Definition for service (%s) was not found.',
                $serviceName
            )
        );
    }
}
