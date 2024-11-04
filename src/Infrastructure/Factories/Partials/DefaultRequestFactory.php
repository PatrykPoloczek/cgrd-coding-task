<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories\Partials;

use Cgrd\Application\Enums\RequestMethodEnum;
use Cgrd\Application\Http\RequestInterface;
use Cgrd\Infrastructure\Http\Requests\Request;

class DefaultRequestFactory extends AbstractPartialRequestFactory
{
    public function supports(): bool
    {
        return true;
    }

    public function create(): RequestInterface
    {
        return new Request(
            RequestMethodEnum::GET,
            '',
            ''
        );
    }
}
