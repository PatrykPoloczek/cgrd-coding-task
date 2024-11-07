<?php

declare(strict_types=1);

namespace Cgrd\Application\Repositories;

use Cgrd\Application\Models\NewsArticleInterface;

interface ArticlesRepositoryInterface
{
    public const PER_PAGE = 10;

    public function findOneById(int $id): ?NewsArticleInterface;

    public function findOneByPublicId(string $id): ?NewsArticleInterface;

    /**
     * @return array<int, NewsArticleInterface>
     */
    public function findAllByUserId(
        int $id,
        ?int $page = 0,
        ?int $perPage = self::PER_PAGE
    ): array;

    public function getPageCountByUserId(
        int $id,
        ?int $perPage = self::PER_PAGE
    ): int;

    public function insert(NewsArticleInterface $model): void;
    public function update(NewsArticleInterface $model): void;
    public function deleteById(int $id): void;
}
