<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Repositories;

use Cgrd\Application\Adapters\DatabaseAdapterInterface;
use Cgrd\Application\Models\NewsArticleInterface;
use Cgrd\Application\Repositories\ArticlesRepositoryInterface;
use Cgrd\Infrastructure\Entities\NewsArticleEntity;
use Cgrd\Infrastructure\Factories\ArticleEntityFactory;
use Cgrd\Infrastructure\Factories\ArticleModelFactory;

class ArticlesRepository extends AbstractRepository implements ArticlesRepositoryInterface
{
    private const TABLE_NAME = 'articles';

    public function __construct(
        private readonly ArticleModelFactory $articleModelFactory,
        private readonly ArticleEntityFactory $articleEntityFactory,
        DatabaseAdapterInterface $databaseAdapter
    ) {
        parent::__construct($databaseAdapter);
    }

    public function findOneById(int $id): ?NewsArticleInterface
    {
        /** @var NewsArticleEntity $entity */
        $entity = $this->databaseAdapter->findOneOrDefault(
            self::TABLE_NAME,
            NewsArticleEntity::class,
            [
                'id' => $id,
            ]
        );

        return empty($entity)
            ? null
            : $this->articleModelFactory->createFromEntity($entity)
        ;
    }

    public function findOneByPublicId(string $id): ?NewsArticleInterface
    {
        /** @var NewsArticleEntity $entity */
        $entity = $this->databaseAdapter->findOneOrDefault(
            self::TABLE_NAME,
            NewsArticleEntity::class,
            [
                'public_id' => $id,
            ]
        );

        return empty($entity)
            ? null
            : $this->articleModelFactory->createFromEntity($entity)
        ;
    }

    /**
     * @inheritDoc
     */
    public function findAllByUserId(
        int $id,
        ?int $page = 0,
        ?int $perPage = self::PER_PAGE
    ): array {
        /** @var array<int, NewsArticleEntity> $entities */
        $entities = $this->databaseAdapter->findAllBy(
            self::TABLE_NAME,
            NewsArticleEntity::class,
            [
                'user_id' => $id,
            ],
            $this->calculateOffset(
                $page ?? 0,
                $perPage ?? self::PER_PAGE
            ),
            $perPage ?? self::PER_PAGE
        );

        return array_map(
            fn (NewsArticleEntity $entity): NewsArticleInterface => $this
                ->articleModelFactory
                ->createFromEntity($entity),
            $entities
        );
    }

    public function getPageCountByUserId(
        int $id,
        ?int $perPage = self::PER_PAGE
    ): int {
        $count = $this->databaseAdapter->getCountBy(
            self::TABLE_NAME,
            [
                'user_id' => $id,
            ]
        );

        return (int) ceil($count / ($perPage ?? self::PER_PAGE));
    }

    public function insert(NewsArticleInterface $model): void
    {
        $entity = $this->articleEntityFactory->createFromModel($model);

        $this->databaseAdapter->insert(
            fn () => $entity->toArray(),
            self::TABLE_NAME
        );
    }

    public function update(NewsArticleInterface $model): void
    {
        $entity = $this->articleEntityFactory->createFromModel($model);

        $this->databaseAdapter->update(
            fn () => $entity->toArray(),
            self::TABLE_NAME,
            [
                'id' => $model->getId(),
            ]
        );
    }

    public function deleteById(int $id): void
    {
        $this->databaseAdapter->deleteById(self::TABLE_NAME, $id);
    }
}