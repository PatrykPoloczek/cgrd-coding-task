<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Models\NewsArticleInterface;
use Cgrd\Infrastructure\Entities\NewsArticleEntity;
use Cgrd\Infrastructure\Models\NewsArticle;

class ArticleModelFactory
{
    public function createFromEntity(NewsArticleEntity $entity): NewsArticleInterface
    {
        return new NewsArticle(
            $entity->getId(),
            $entity->getUserId(),
            $entity->getTitle(),
            $entity->getBody(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt()
        );
    }
}
