<?php

declare(strict_types=1);

namespace Cgrd\Application\Http\Routing;

use Cgrd\Application\Http\RequestInterface;

interface RouterInterface
{
    public function register(): void;
    public function resolve(RequestInterface $request): RouteInterface;
}
