<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories\Partials;

use Cgrd\Application\Http\RequestInterface;

abstract class AbstractPartialRequestFactory
{
    public abstract function supports(): bool;
    public abstract function create(): RequestInterface;
}
