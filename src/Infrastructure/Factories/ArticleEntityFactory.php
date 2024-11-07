<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Models\NewsArticleInterface;
use Cgrd\Application\Models\UserInterface;
use Cgrd\Infrastructure\Entities\NewsArticleEntity;
use Cgrd\Infrastructure\Entities\UserEntity;

class ArticleEntityFactory
{
    public function createFromModel(NewsArticleInterface $model): NewsArticleEntity
    {
        return new NewsArticleEntity(
            $model->getId(),
            $model->getPublicId(),
            $model->getUserId(),
            $model->getTitle(),
            $model->getBody(),
            $model->getCreatedAt() ?? new \DateTime(),
            $model->getUpdatedAt() ?? new \DateTime()
        );
    }
}
