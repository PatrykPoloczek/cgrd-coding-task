<?php

declare(strict_types=1);

namespace Cgrd\Application\Models;

interface NewsArticleInterface
{
    public function getId(): int;
    public function getUserId(): int;
    public function getTitle(): string;
    public function getBody(): string;
    public function getCreatedAt(): ?\DateTime;
    public function getUpdatedAt(): ?\DateTime;
}
