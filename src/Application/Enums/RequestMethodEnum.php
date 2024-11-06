<?php

declare(strict_types=1);

namespace Cgrd\Application\Enums;

use Cgrd\Application\Exceptions\UnsupportedRequestMethodException;

enum RequestMethodEnum: string
{
    case GET = "GET";
    case POST = "POST";
    case PUT = "PUT";
    case PATCH = "PATCH";
    case DELETE = "DELETE";

    public static function resolve(string $method): self
    {
        return match(strtoupper($method)) {
            default => throw UnsupportedRequestMethodException::create($method),
            self::GET->name => self::GET,
            self::POST->name => self::POST,
            self::PATCH->name => self::PATCH,
            self::PUT->name => self::PUT,
            self::DELETE->name => self::DELETE
        };
    }
}
