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
}