<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories\Partials;

use Cgrd\Application\Enums\RequestMethodEnum;
use Cgrd\Application\Http\RequestInterface;
use Cgrd\Infrastructure\Http\Requests\JsonRequest;

class JsonRequestFactory extends AbstractPartialRequestFactory
{
    public function create(): RequestInterface
    {
        return new JsonRequest(
            RequestMethodEnum::GET,
            '',
            file_get_contents('php://input'),
        );
    }

    public function supports(): bool
    {
        return true;
    }
}
