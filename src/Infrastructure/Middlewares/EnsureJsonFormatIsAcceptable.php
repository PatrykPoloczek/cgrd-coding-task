<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Middlewares;

use Cgrd\Application\Exceptions\UnsupportedResponseFormatException;
use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Models\MiddlewareInterface;

class EnsureJsonFormatIsAcceptable implements MiddlewareInterface
{
    private const ACCEPT_HEADER = 'Accept';
    private const EXPECTED_FORMAT_TYPE = 'application/json';

    public function handle(RequestInterface &$request, ?\Closure $next = null)
    {
        $header = $request->getHeader(self::ACCEPT_HEADER);

        if (empty($header) || !in_array(self::EXPECTED_FORMAT_TYPE, $header)) {
            throw UnsupportedResponseFormatException::create();
        }

        return empty($next)
            ? fn () => null
            : $next($request)
        ;
    }
}
