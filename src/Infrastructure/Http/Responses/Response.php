<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Http\Responses;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;
use Cgrd\Application\Http\MessageInterface;
use Cgrd\Application\Http\ResponseInterface;

class Response implements ResponseInterface
{
    public function __construct(
        private string $body,
        private array $headers = [],
        private ResponseStatusCodeEnum $statusCode = ResponseStatusCodeEnum::OK
    ) {
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers = []): MessageInterface
    {
        $this->headers = $headers;

        return $this;
    }

    public function hasHeader(string $name): bool
    {
        return array_key_exists($name, $this->headers);
    }

    public function getHeader(string $name): array
    {
        return (array) $this->headers[$name] ?? [];
    }

    public function setHeader(string $name, array $values): MessageInterface
    {
        $this->headers[$name] = $values;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): MessageInterface
    {
        $this->body = $body;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getBody();
    }

    public function getStatusCode(): ResponseStatusCodeEnum
    {
        return $this->statusCode;
    }

    public function setStatusCode(ResponseStatusCodeEnum $statusCode): ResponseInterface
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
