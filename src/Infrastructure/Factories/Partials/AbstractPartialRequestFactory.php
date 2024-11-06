<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories\Partials;

use Cgrd\Application\Http\RequestInterface;

abstract class AbstractPartialRequestFactory
{
    protected const REQUEST_URI_KEY = 'REQUEST_URI';
    public abstract function supports(): bool;
    public abstract function create(): RequestInterface;
}
