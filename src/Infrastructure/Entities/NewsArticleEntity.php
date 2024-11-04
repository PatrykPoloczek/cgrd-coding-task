<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Entities;

use Cgrd\Application\Entities\AbstractEntity;

class NewsArticleEntity extends AbstractEntity
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

    public static function createFromDatabaseResult(array $data): AbstractEntity
    {
        return new self(
            $data['id'],
            $data['user_id'],
            $data['title'],
            $data['body'],
            $data['created_at'],
            $data['updated_at']
        );
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

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt ?? new \DateTime();
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt ?? new \DateTime();
    }
}
