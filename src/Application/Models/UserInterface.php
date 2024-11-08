<?php

declare(strict_types=1);

namespace Cgrd\Application\Models;

interface UserInterface
{
    public function getId(): int;
    public function getLogin(): string;
    public function getPassword(): string;
    public function getToken(): ?string;
    public function getTokenExpiresAt() : ?\DateTime;
    public function getCreatedAt(): ?\DateTime;
    public function getUpdatedAt(): ?\DateTime;
    public function tokenExpired(): bool;
}
