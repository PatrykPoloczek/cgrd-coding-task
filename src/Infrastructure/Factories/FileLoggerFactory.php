<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Enums\LogLevelEnum;
use Cgrd\Application\Logger\LoggerInterface;
use Cgrd\Infrastructure\Logger\FileLogger;

class FileLoggerFactory
{
    private const DATE_FORMAT = 'Y-m-d';

    public static function create(?LogLevelEnum $minimalLevel = null): LoggerInterface
    {
        $path = sprintf(
            '%s/%s.log',
            VAR_BASE_PATH,
            date(self::DATE_FORMAT)
        );

        return empty($minimalLevel)
            ? new FileLogger($path)
            : new FileLogger($path, $minimalLevel)
        ;
    }
}
