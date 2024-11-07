<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories\Partials;

use Cgrd\Application\Enums\RequestMethodEnum;
use Cgrd\Application\Http\RequestInterface;
use Cgrd\Infrastructure\Http\Requests\JsonRequest;

class JsonRequestFactory extends AbstractPartialRequestFactory
{
    private const CONTENT_TYPE_HEADER = 'Content-Type';
    private const SUPPORTED_CONTENT_TYPE = 'application/json';
    private const REQUEST_METHOD_KEY = 'REQUEST_METHOD';

    public function create(): RequestInterface
    {
        $method = $_SERVER[self::REQUEST_METHOD_KEY] ?? '';
        $method = RequestMethodEnum::resolve($method);

        return new JsonRequest(
            $method,
            $_SERVER[self::PATH_INFO_KEY],
            file_get_contents('php://input'),
            getallheaders(),
            $_GET
        );
    }

    public function supports(): bool
    {
        $headers = getallheaders();
        $contentType = $headers[self::CONTENT_TYPE_HEADER] ?? null;

        return $contentType === self::SUPPORTED_CONTENT_TYPE;
    }
}
