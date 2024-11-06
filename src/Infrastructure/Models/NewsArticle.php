<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Models;

use Cgrd\Application\Models\NewsArticleInterface;

class NewsArticle implements NewsArticleInterface
{
    public function __construct(
        private readonly int $id,
        private readonly int $userId,
        private readonly string $title,
        private readonly string $body,
        private readonly ?\DateTime $createdAt = null,
        private readonly ?\DateTime $updatedAt = null,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'title' => $this->title,
            'body' => $this->body,
            'createdAt' => $this->createdAt->format(self::DATE_FORMAT),
            'updatedAt' => $this->updatedAt->format(self::DATE_FORMAT),
        ];
    }
}
