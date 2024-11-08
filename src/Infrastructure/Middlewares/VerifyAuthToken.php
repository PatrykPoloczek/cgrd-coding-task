<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Middlewares;

use Cgrd\Application\Exceptions\UnauthorizedException;
use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Models\MiddlewareInterface;
use Cgrd\Application\Repositories\UsersRepositoryInterface;
use Cgrd\Infrastructure\Factories\AuthenticatedUserRequestFactory;

class VerifyAuthToken implements MiddlewareInterface
{
    private const AUTHORIZATION_HEADER_KEY = 'Authorization';

    public function __construct(
        private readonly UsersRepositoryInterface $usersRepository
    ) {
    }

    public function handle(RequestInterface &$request, ?\Closure $next = null)
    {
        $header = $request->getHeader(self::AUTHORIZATION_HEADER_KEY);

        if (empty($header)) {
            throw UnauthorizedException::tokenMissing();
        }

        $token = str_replace(
            'Bearer',
            '',
            $header
        );
        $token = trim(array_shift($token));

        $user = $this->usersRepository->findOneByToken($token);

        if (empty($user) || $user->tokenExpired()) {
            throw UnauthorizedException::create();
        }

        $request = AuthenticatedUserRequestFactory::createFromBaseRequest(
            $request,
            $user
        );

        return empty($next)
            ? fn () => null
            : $next($request)
        ;
    }
}
