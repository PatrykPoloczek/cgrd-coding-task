<?php

declare(strict_types=1);

namespace Cgrd\Application\Http;

interface MessageInterface
{
    /**
     * @return string[][]
     */
    public function getHeaders(): array;

    public function setHeaders(array $headers = []): self;

    public function hasHeader(string $name): bool;

    /**
     * @return string[]
     */
    public function getHeader(string $name): array;

    public function setHeader(string $name, array $values): self;

    public function getBody(): string;

    public function setBody(string $body): self;
    public function __toString(): string;
}
