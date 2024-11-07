<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Controllers;

use Cgrd\Infrastructure\Handlers\CreateArticleHandler;
use Cgrd\Infrastructure\Http\Requests\AuthenticatedUserRequest;

class CreateNewsArticleController
{
    public function __construct(
        private readonly CreateArticleHandler $createArticleHandler
    ) {
    }

    public function __invoke(AuthenticatedUserRequest $request)
    {
        $model = $this->createArticleHandler->handle($request);
    }
}
