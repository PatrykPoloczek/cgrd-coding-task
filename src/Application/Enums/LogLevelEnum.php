<?php

declare(strict_types=1);

namespace Cgrd\Application\Enums;

enum LogLevelEnum: int
{
    case EMERGENCY = 700;
    case ALERT = 600;
    case CRITICAL = 500;
    case ERROR = 400;
    case WARNING = 300;
    case NOTICE = 200;
    case INFO = 100;
    case DEBUG = 0;
}
