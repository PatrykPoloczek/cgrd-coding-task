<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Http\Responses;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;

class JsonResponse extends Response
{
    public function __construct(
        array $payload = [],
        array $headers = [],
        ResponseStatusCodeEnum $statusCode = ResponseStatusCodeEnum::OK
    ) {
        parent::__construct(
            $this->encodePayload($payload),
            $headers,
            $statusCode
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
