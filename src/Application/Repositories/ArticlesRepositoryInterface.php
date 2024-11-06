<?php

declare(strict_types=1);

namespace Cgrd\Application\Repositories;

use Cgrd\Application\Models\NewsArticleInterface;

interface ArticlesRepositoryInterface
{
    public const PER_PAGE = 10;

    public function findOneById(int $id): ?NewsArticleInterface;

    /**
     * @return array<int, NewsArticleInterface>
     */
    public function findAllByUserId(
        int $id,
        ?int $page = 0,
        ?int $perPage = self::PER_PAGE
    ): array;
}
