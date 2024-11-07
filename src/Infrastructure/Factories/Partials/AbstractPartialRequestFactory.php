<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories\Partials;

use Cgrd\Application\Http\RequestInterface;

abstract class AbstractPartialRequestFactory
{
    protected const PATH_INFO_KEY = 'PATH_INFO';
    public abstract function supports(): bool;
    public abstract function create(): RequestInterface;
}
