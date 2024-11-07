<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Models\NewsArticleInterface;
use Cgrd\Infrastructure\Entities\NewsArticleEntity;
use Cgrd\Infrastructure\Models\Dtos\CreateArticleInputDto;
use Cgrd\Infrastructure\Models\Dtos\UpdateArticleInputDto;
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

    public function createFromCreateDto(CreateArticleInputDto $dto): NewsArticleInterface
    {
        return new NewsArticle(
            rand(1, 1000),
            $dto->getPublicId(),
            $dto->getUserId(),
            $dto->getTitle(),
            $dto->getBody()
        );
    }

    public function createFromUpdateDtoAndOldModel(
        UpdateArticleInputDto $dto,
        NewsArticleInterface $oldModel
    ): NewsArticleInterface {
        return new NewsArticle(
            $oldModel->getId(),
            $oldModel->getPublicId(),
            $oldModel->getUserId(),
            $dto->getTitle(),
            $dto->getBody(),
            $oldModel->getCreatedAt()
        );
    }
}
