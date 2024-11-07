<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Controllers;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;
use Cgrd\Application\Exceptions\RecordCouldNotHaveBeenCreatedException;
use Cgrd\Application\Http\ResponseInterface;
use Cgrd\Infrastructure\Handlers\CreateArticleHandler;
use Cgrd\Infrastructure\Http\Requests\AuthenticatedUserRequest;
use Cgrd\Infrastructure\Http\Responses\JsonResponse;
use Cgrd\Infrastructure\Models\NewsArticle;

class CreateNewsArticleController
{
    public function __construct(
        private readonly CreateArticleHandler $createArticleHandler
    ) {
    }

    public function __invoke(AuthenticatedUserRequest $request): ResponseInterface
    {
        try {
            $this->createArticleHandler->handle($request);

            return new JsonResponse(
                payload: [
                    'message' => 'Record successfully created.',
                ],
                statusCode: ResponseStatusCodeEnum::CREATED
            );
        } catch (\PDOException $exception) {
            throw RecordCouldNotHaveBeenCreatedException::createFromException(
                $exception,
                NewsArticle::class
            );
        }
    }
}
