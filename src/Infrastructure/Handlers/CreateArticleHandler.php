<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Handlers;

use Cgrd\Application\Models\NewsArticleInterface;
use Cgrd\Application\Repositories\ArticlesRepositoryInterface;
use Cgrd\Application\Validation\Validators\ValidatorInterface;
use Cgrd\Infrastructure\Factories\ArticleModelFactory;
use Cgrd\Infrastructure\Http\Requests\AuthenticatedUserRequest;
use Cgrd\Infrastructure\Models\Dtos\CreateArticleInputDto;

class CreateArticleHandler
{
    public function __construct(
        private readonly ArticlesRepositoryInterface $articlesRepository,
        private readonly ValidatorInterface $validator,
        private readonly ArticleModelFactory $articleModelFactory
    ) {
    }

    public function handle(AuthenticatedUserRequest $request): ?NewsArticleInterface
    {
        $data = json_decode(
            json: $request->getBody(),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );

        /** @var CreateArticleInputDto $dto */
        $dto = $this->validator->validate(
            $data,
            CreateArticleInputDto::class
        );

        $this->articlesRepository->insert(
            $this->articleModelFactory->createFromDto($dto)
        );
        return null;
    }
}
