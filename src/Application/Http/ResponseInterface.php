<?php

declare(strict_types=1);

namespace Cgrd\Application\Http;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;

interface ResponseInterface extends MessageInterface
{
    public function getStatusCode(): ResponseStatusCodeEnum;
    public function setStatusCode(ResponseStatusCodeEnum $statusCode): self;
}
