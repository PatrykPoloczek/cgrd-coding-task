<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Models;

use Cgrd\Application\Models\UserInterface;

class User implements UserInterface
{
    public function __construct(
        private readonly int $id,
        private readonly string $login,
        private readonly string $password,
        private readonly ?string $token = null,
        private readonly ?\DateTime $tokenExpiresAt = null,
        private readonly ?\DateTime $createdAt = null,
        private readonly ?\DateTime $updatedAt = null
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getTokenExpiresAt(): ?\DateTime
    {
        return $this->tokenExpiresAt;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function tokenExpired(): bool
    {
        if (empty($this->tokenExpiresAt)) {
            return true;
        }

        $dateFormat = 'Y-m-d H:i:s';
        $now = strtotime((new \DateTime())->format($dateFormat));
        $expiresAt = strtotime($this->tokenExpiresAt->format($dateFormat));

        return $now > $expiresAt;
    }
}
