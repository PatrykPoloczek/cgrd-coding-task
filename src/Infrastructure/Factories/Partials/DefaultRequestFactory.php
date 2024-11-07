<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories\Partials;

use Cgrd\Application\Enums\RequestMethodEnum;
use Cgrd\Application\Http\RequestInterface;
use Cgrd\Infrastructure\Http\Requests\JsonRequest;

class DefaultRequestFactory extends AbstractPartialRequestFactory
{
    private const REQUEST_METHOD_KEY = 'REQUEST_METHOD';

    public function supports(): bool
    {
        return true;
    }

    public function create(): RequestInterface
    {
        $method = $_SERVER[self::REQUEST_METHOD_KEY] ?? '';
        $method = RequestMethodEnum::resolve($method);
        $body = $method->value === RequestMethodEnum::GET
            ? json_encode($_GET)
            : json_encode($_POST)
        ;

        return new JsonRequest(
            $method,
            $_SERVER[self::PATH_INFO_KEY],
            $body,
            getallheaders()
        );
    }
}
