<?php

namespace Cgrd\Infrastructure\Http\Requests;

use Cgrd\Application\Enums\RequestMethodEnum;
use Cgrd\Application\Exceptions\RequestParameterNotFoundException;
use Cgrd\Application\Http\MessageInterface;
use Cgrd\Application\Http\RequestInterface;

class Request implements RequestInterface
{
    public function __construct(
        private RequestMethodEnum $method,
        private string $path,
        private string $body,
        private array $headers = [],
        private array $parameters = []
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
        return array_key_exists($name, $this->headers)
            ? (array) $this->headers[$name]
            : []
        ;
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

    public function getMethod(): RequestMethodEnum
    {
        return $this->method;
    }

    public function setMethod(RequestMethodEnum $method): RequestInterface
    {
        $this->method = $method;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): RequestInterface
    {
        $this->path = $path;

        return $this;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters = []): RequestInterface
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getParameter(string $key): mixed
    {
        if (!$this->hasParameter($key)) {
            throw RequestParameterNotFoundException::createFromParameterName($key);
        }

        return $this->parameters[$key];
    }

    public function setParameter(string $key, mixed $value): RequestInterface
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    public function hasParameter(string $key): bool
    {
        return array_key_exists($key, $this->parameters);
    }
}