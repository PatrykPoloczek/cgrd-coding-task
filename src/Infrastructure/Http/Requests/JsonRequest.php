<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Http\Requests;

use Cgrd\Application\Enums\RequestMethodEnum;

class JsonRequest extends Request
{
    public function __construct(
        RequestMethodEnum $method,
        string $path,
        array|string $payload,
        array $headers = [])
    {
        $body = is_string($payload)
            ? $payload
            : $this->encodePayload($payload)
        ;

        parent::__construct(
            $method,
            $path,
            $body,
            $headers
        );
    }

    public function getContent(): array
    {
        return json_decode(
            $this->getBody(),
            true,
            JSON_THROW_ON_ERROR
        );
    }

    private function encodePayload(array $payload = []): string
    {
        return json_encode(
            $payload,
            JSON_THROW_ON_ERROR
        );
    }
}
