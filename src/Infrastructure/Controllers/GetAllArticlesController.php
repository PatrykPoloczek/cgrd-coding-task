<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Controllers;

use Cgrd\Application\Http\ResponseInterface;
use Cgrd\Application\Models\NewsArticleInterface;
use Cgrd\Infrastructure\Handlers\GetAllArticlesHandler;
use Cgrd\Infrastructure\Http\Requests\AuthenticatedUserRequest;
use Cgrd\Infrastructure\Http\Responses\JsonResponse;

class GetAllArticlesController
{
    public function __construct(
        private readonly GetAllArticlesHandler $getAllArticlesHandler
    ) {
    }

    public function __invoke(AuthenticatedUserRequest $request): ResponseInterface
    {
        return new JsonResponse(
            [
                'message' => 'Successfully fetched articles records.',
                'articles' => array_map(
                    fn (NewsArticleInterface $model): array => $model->toArray(),
                    $this->getAllArticlesHandler->handle($request)
                ),
            ]
        );
    }
}
