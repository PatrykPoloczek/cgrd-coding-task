<?php

declare(strict_types=1);

namespace Cgrd\Application\Http;

use Cgrd\Application\Enums\RequestMethodEnum;

interface RequestInterface extends MessageInterface
{
    public function getMethod(): RequestMethodEnum;
    public function setMethod(RequestMethodEnum $method): self;
    public function getPath(): string;
    public function setPath(string $path): self;
}
