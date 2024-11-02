<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

class UnsuportedLogLevelException extends \Exception
{
    public static function createFromLevel(): self
    {
        return new self("");
    }
}
