<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Logger;

use Cgrd\Application\Enums\LogLevelEnum;
use Cgrd\Application\Logger\LoggerInterface;

class DefaultLogger implements LoggerInterface
{
    protected const FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        private readonly LogLevelEnum $minimalLevel = LogLevelEnum::DEBUG
    ) {
    }

    public function emergency(string $message, array $context = []): void
    {
        $this->log(
            LogLevelEnum::EMERGENCY,
            $message,
            $context
        );
    }

    public function alert(string $message, array $context = []): void
    {
        $this->log(
            LogLevelEnum::ALERT,
            $message,
            $context
        );
    }

    public function critical(string $message, array $context = []): void
    {
        $this->log(
            LogLevelEnum::CRITICAL,
            $message,
            $context
        );
    }

    public function error(string $message, array $context = []): void
    {
        $this->log(
            LogLevelEnum::ERROR,
            $message,
            $context
        );
    }

    public function warning(string $message, array $context = []): void
    {
        $this->log(
            LogLevelEnum::WARNING,
            $message,
            $context
        );
    }

    public function notice(string $message, array $context = []): void
    {
        $this->log(
            LogLevelEnum::NOTICE,
            $message,
            $context
        );
    }

    public function info(string $message, array $context = []): void
    {
        $this->log(
            LogLevelEnum::INFO,
            $message,
            $context
        );
    }

    public function debug(string $message, array $context = []): void
    {
        $this->log(
            LogLevelEnum::DEBUG,
            $message,
            $context
        );
    }

    public function log(LogLevelEnum $level, string $message, array $context = []): void
    {
        if ($level->value < $this->minimalLevel->value) {
            return;
        }

        $entry = $this->formatMessage($level, $message, $context);
        $this->writeEntry($entry);
    }

    protected function formatMessage(LogLevelEnum $level, string $message, array $context = []): string
    {
        return sprintf(
        '[%s] Level: %s Message: %s Context: %s',
            date(self::FORMAT),
            strtoupper($level->name),
            $message,
            json_encode($context)
        );
    }

    protected function writeEntry(string $entry): void
    {
        echo $entry . PHP_EOL;
    }
}
