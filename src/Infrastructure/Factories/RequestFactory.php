<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Http\RequestInterface;

class RequestFactory
{
    public static function createFromJsonPayload()
    {
        $data = json_decode(
            json: file_get_contents('php://input'),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );
    }

    public static function createFromGlobals(): RequestInterface
    {
        
    }
}
