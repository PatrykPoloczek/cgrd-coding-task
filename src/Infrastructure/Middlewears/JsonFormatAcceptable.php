<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Middlewears;

use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Models\MiddlewareInterface;

class JsonFormatAcceptable implements MiddlewareInterface
{
    private const ACCEPT_HEADER = 'Accept';

    public function handle(RequestInterface $request, ?\Closure $next = null)
    {
        $header = $request->getHeader(self::ACCEPT_HEADER);

        return empty($next)
            ? fn () => null
            : $next($request)
        ;
    }
}
