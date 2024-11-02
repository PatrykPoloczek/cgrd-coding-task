<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Middlewears;

use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Models\MiddlewearInterface;

class JsonFormatAcceptable implements MiddlewearInterface
{
    private const ACCEPT_HEADER = 'Accept';

    public function handle(RequestInterface $request, \Closure $next)
    {
        $header = $request->getHeader(self::ACCEPT_HEADER);



        return $next($request);
    }
}
