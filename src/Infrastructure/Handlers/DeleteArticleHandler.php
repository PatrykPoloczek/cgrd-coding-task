<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Handlers;

use Cgrd\Application\Repositories\ArticlesRepositoryInterface;

class DeleteArticleHandler
{
    public function __construct(
        private readonly ArticlesRepositoryInterface $articlesRepository
    ) {
    }

    public function handle(int $id): void
    {
        $this->articlesRepository->deleteById($id);
    }
}
