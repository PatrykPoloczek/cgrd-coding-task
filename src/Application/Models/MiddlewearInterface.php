<?php

declare(strict_types=1);

namespace Cgrd\Application\Models;

use Cgrd\Application\Http\RequestInterface;

interface MiddlewearInterface
{
    public function handle(RequestInterface $request, \Closure $next);
}
