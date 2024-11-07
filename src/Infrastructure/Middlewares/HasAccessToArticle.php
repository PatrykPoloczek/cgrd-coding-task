<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Middlewares;

use Cgrd\Application\Exceptions\ForbiddenException;
use Cgrd\Application\Exceptions\NotFoundException;
use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Models\MiddlewareInterface;
use Cgrd\Application\Repositories\ArticlesRepositoryInterface;
use Cgrd\Infrastructure\Factories\ArticleFetchedRequestFactory;
use Cgrd\Infrastructure\Http\Requests\AuthenticatedUserRequest;

class HasAccessToArticle implements MiddlewareInterface
{
    public function __construct(
        private readonly ArticlesRepositoryInterface $articlesRepository
    ) {
    }

    /**
     * @param AuthenticatedUserRequest $request
     */
    public function handle(RequestInterface &$request, ?\Closure $next = null)
    {
        $user = $request->getUser();
        $article = $this->articlesRepository->findOneById(
            (int) $request->getParameter('id')
        );

        if (empty($article)) {
            throw NotFoundException::create();
        }

        if ($user->getId() !== $article->getUserId()) {
            throw ForbiddenException::create();
        }

        $request = ArticleFetchedRequestFactory::createFromBaseRequest(
            $request,
            $article
        );

        return empty($next)
            ? fn () => null
            : $next($request)
        ;
    }
}
