<?php

declare(strict_types=1);

namespace Cgrd\Application\Repositories;

use Cgrd\Application\Models\NewsArticleInterface;

interface ArticlesRepositoryInterface
{
    public function findOneById(int $id): ?NewsArticleInterface;
}
