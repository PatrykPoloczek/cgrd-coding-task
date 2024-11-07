<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Models\NewsArticleInterface;
use Cgrd\Infrastructure\Entities\NewsArticleEntity;
use Cgrd\Infrastructure\Models\Dtos\CreateArticleInputDto;
use Cgrd\Infrastructure\Models\NewsArticle;

class ArticleModelFactory
{
    public function createFromEntity(NewsArticleEntity $entity): NewsArticleInterface
    {
        return new NewsArticle(
            $entity->getId(),
            $entity->getPublicId(),
            $entity->getUserId(),
            $entity->getTitle(),
            $entity->getBody(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt()
        );
    }

    public function createFromDto(CreateArticleInputDto $dto)
    {
        return new
    }
}
