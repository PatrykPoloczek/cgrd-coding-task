<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Models\NewsArticleInterface;
use Cgrd\Infrastructure\Http\Requests\ArticleFetchedRequest;
use Cgrd\Infrastructure\Http\Requests\AuthenticatedUserRequest;

class ArticleFetchedRequestFactory
{
    public static function createFromBaseRequest(
        AuthenticatedUserRequest $request,
        NewsArticleInterface $article
    ): RequestInterface {
        return new ArticleFetchedRequest(
            $article,
            $request->getUser(),
            $request->getMethod(),
            $request->getPath(),
            $request->getBody(),
            $request->getHeaders(),
            $request->getParameters()
        );
    }
}
