<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Models\UserInterface;
use Cgrd\Infrastructure\Http\Requests\AuthenticatedUserRequest;

class AuthenticatedUserRequestFactory
{
    public static function createFromBaseRequest(
        RequestInterface $request,
        UserInterface $user
    ): RequestInterface {
        return new AuthenticatedUserRequest(
            $user,
            $request->getMethod(),
            $request->getPath(),
            $request->getBody(),
            $request->getHeaders(),
            $request->getParameters()
        );
    }
}
