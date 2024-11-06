<?php

declare(strict_types=1);

namespace Cgrd\Application\Models;

use Cgrd\Application\Http\RequestInterface;

interface MiddlewareInterface
{
    public function handle(RequestInterface &$request, ?\Closure $next = null);
}
