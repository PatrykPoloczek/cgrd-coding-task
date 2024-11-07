<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Models\Dtos;

use Cgrd\Application\Models\Dtos\DtoInterface;
use Cgrd\Infrastructure\Validation\Constraints\MaximumLengthConstraint;
use Cgrd\Infrastructure\Validation\Constraints\MinimalLengthConstraint;
use Cgrd\Infrastructure\Validation\Constraints\RequiredConstraint;

class UpdateArticleInputDto implements DtoInterface
{
    public static function getRules(): array
    {
        return [
            'title' => [
                RequiredConstraint::class,
                new MinimalLengthConstraint(3),
                new MaximumLengthConstraint(100),
            ],
            'body' => [
                RequiredConstraint::class,
                new MinimalLengthConstraint(3),
                new MaximumLengthConstraint(100),
            ],
        ];
    }

    public function __construct(
        private readonly string $title,
        private readonly string $body
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
