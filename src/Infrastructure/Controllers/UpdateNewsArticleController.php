<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Controllers;

use Cgrd\Application\Exceptions\RecordCouldNotHaveBeenUpdatedException;
use Cgrd\Application\Http\ResponseInterface;
use Cgrd\Infrastructure\Handlers\UpdateArticleHandler;
use Cgrd\Infrastructure\Http\Requests\ArticleFetchedRequest;
use Cgrd\Infrastructure\Http\Responses\JsonResponse;
use Cgrd\Infrastructure\Models\NewsArticle;

class UpdateNewsArticleController
{
    public function __construct(
        private readonly UpdateArticleHandler $updateArticleHandler
    ) {
    }

    public function __invoke(ArticleFetchedRequest $request): ResponseInterface
    {
        try {
            $this->updateArticleHandler->handle($request);

            return new JsonResponse([
                'message' => 'Records was successfully updated.',
            ]);
        } catch (\PDOException $exception) {
            throw RecordCouldNotHaveBeenUpdatedException::createFromException(
                $exception,
                NewsArticle::class
            );
        }
    }
}
