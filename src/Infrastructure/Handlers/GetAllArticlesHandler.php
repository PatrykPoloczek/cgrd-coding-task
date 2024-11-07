<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Handlers;

use Cgrd\Application\Repositories\ArticlesRepositoryInterface;
use Cgrd\Infrastructure\Http\Requests\AuthenticatedUserRequest;

class GetAllArticlesHandler
{
    public function __construct(
        private readonly ArticlesRepositoryInterface $articlesRepository
    ) {
    }

    public function handle(AuthenticatedUserRequest $request): array
    {
        $page = $request->hasParameter('page')
            ? (int) $request->getParameter('page')
            : null
        ;
        $perPage = $request->hasParameter('perPage')
            ? (int) $request->getParameter('perPage')
            : null
        ;

        return [
            'records' => $this->articlesRepository->findAllByUserId(
                $request->getUser()->getId(),
                $page,
                $perPage
            ),
            'pages' => $this->articlesRepository->getPageCountByUserId(
                $request->getUser()->getId(),
                $perPage
            ),
        ];
    }
}
