<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Models\Dtos;

use Cgrd\Application\Models\Dtos\DtoInterface;
use Cgrd\Infrastructure\Factories\HashFactory;
use Cgrd\Infrastructure\Validation\Constraints\NumericConstraint;
use Cgrd\Infrastructure\Validation\Constraints\RequiredConstraint;
use Cgrd\Infrastructure\Validation\Constraints\UserIdExistsConstraint;
use Cgrd\Infrastructure\Validation\Constraints\MinimalLengthConstraint;
use Cgrd\Infrastructure\Validation\Constraints\MaximumLengthConstraint;

class CreateArticleInputDto implements DtoInterface
{
    public static function getRules(): array
    {
        return [
            'user_id' => [
                RequiredConstraint::class,
                NumericConstraint::class,
                UserIdExistsConstraint::class,
            ],
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

    private string $publicId;

    public function __construct(
        private readonly int $userId,
        private readonly string $title,
        private readonly string $body
    ) {
        $this->publicId = HashFactory::createFromUserIdTitleAndTimestamp(
            $this->userId,
            $this->title
        );
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getPublicId(): string
    {
        return $this->publicId;
    }
}
