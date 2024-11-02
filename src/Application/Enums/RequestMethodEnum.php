<?php

declare(strict_types=1);

namespace Cgrd\Application\Enums;

enum RequestMethodEnum: string
{
    case GET = "GET";
    case POST = "POST";
    case PUT = "PUT";
    case PATCH = "PATCH";
    case DELETE = "DELETE";
}
