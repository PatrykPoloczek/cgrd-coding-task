<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Controllers;

use Cgrd\Application\Exceptions\RecordCouldNotHaveBeenCreatedException;
use Cgrd\Application\Http\ResponseInterface;
use Cgrd\Infrastructure\Handlers\DeleteArticleHandler;
use Cgrd\Infrastructure\Http\Requests\ArticleFetchedRequest;
use Cgrd\Infrastructure\Http\Responses\JsonResponse;
use Cgrd\Infrastructure\Models\NewsArticle;

class DeleteNewsArticleController
{
    public function __construct(
        private readonly DeleteArticleHandler $deleteArticleHandler
    ) {
    }

    public function __invoke(ArticleFetchedRequest $request): ResponseInterface
    {
        try {
            $this->deleteArticleHandler->handle($request->getArticle()->getId());

            return new JsonResponse([
                'message' => 'The record was successfully removed.',
            ]);
        } catch (\PDOException $exception) {
            throw RecordCouldNotHaveBeenCreatedException::createFromException(
                $exception,
                NewsArticle::class
            );
        }
    }
}
