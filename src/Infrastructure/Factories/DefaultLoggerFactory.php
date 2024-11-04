<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Enums\LogLevelEnum;
use Cgrd\Application\Logger\LoggerInterface;
use Cgrd\Infrastructure\Logger\DefaultLogger;

class DefaultLoggerFactory
{
    public static function create(?LogLevelEnum $minimalLevel = null): LoggerInterface
    {
        return empty($minimalLevel)
            ? new DefaultLogger()
            : new DefaultLogger($minimalLevel)
        ;
    }
}