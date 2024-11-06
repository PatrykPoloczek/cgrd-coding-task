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
        return $this->articlesRepository->findAllByUserId($request->getUser()->getId());
    }
}
