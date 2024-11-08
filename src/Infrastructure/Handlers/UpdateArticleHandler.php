<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Handlers;

use Cgrd\Application\Repositories\ArticlesRepositoryInterface;
use Cgrd\Application\Validation\Validators\ValidatorInterface;
use Cgrd\Infrastructure\Factories\ArticleModelFactory;
use Cgrd\Infrastructure\Http\Requests\ArticleFetchedRequest;
use Cgrd\Infrastructure\Models\Dtos\UpdateArticleInputDto;

class UpdateArticleHandler
{
    public function __construct(
        private readonly ArticlesRepositoryInterface $articlesRepository,
        private readonly ValidatorInterface $validator,
        private readonly ArticleModelFactory $articleModelFactory
    ) {
    }

    public function handle(ArticleFetchedRequest $request): void
    {
        $data = json_decode(
            json: $request->getBody(),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );

        /** @var UpdateArticleInputDto $dto */
        $dto = $this->validator->validate(
            $data,
            UpdateArticleInputDto::class
        );

        $this->articlesRepository->update(
            $this->articleModelFactory->createFromUpdateDtoAndOldModel(
                $dto,
                $request->getArticle()
            )
        );
    }
}