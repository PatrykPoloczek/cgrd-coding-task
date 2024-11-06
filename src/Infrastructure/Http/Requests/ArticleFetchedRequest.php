<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Http\Requests;

use Cgrd\Application\Enums\RequestMethodEnum;
use Cgrd\Application\Models\NewsArticleInterface;
use Cgrd\Application\Models\UserInterface;

class ArticleFetchedRequest extends AuthenticatedUserRequest
{
    public function __construct(
        private readonly NewsArticleInterface $article,
        UserInterface $user,
        RequestMethodEnum $method,
        string $path,
        string $body,
        array $headers = [],
        array $parameters = []
    ) {
        parent::__construct(
            $user,
            $method,
            $path,
            $body,
            $headers,
            $parameters
        );
    }

    public function getArticle(): NewsArticleInterface
    {
        return $this->article;
    }
}