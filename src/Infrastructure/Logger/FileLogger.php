<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Logger;

use Cgrd\Application\Enums\LogLevelEnum;

class FileLogger extends DefaultLogger
{
    public function __construct(
        private readonly string $storagePath,
        LogLevelEnum $minimalLevel = LogLevelEnum::INFO
    ) {
        parent::__construct($minimalLevel);
    }

    protected function writeEntry(string $entry): void
    {
        file_put_contents(
            $this->storagePath,
            $entry . PHP_EOL,
            FILE_APPEND
        );
    }
}
