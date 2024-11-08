<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Entities;

use Cgrd\Application\Entities\AbstractEntity;

class UserEntity extends AbstractEntity
{
    public function __construct(
        private readonly int $id,
        private readonly string $login,
        private readonly string $password,
        private readonly ?string $token = null,
        private readonly ?\DateTime $tokenExpiresAt = null,
        private readonly ?\DateTime $createdAt = null,
        private readonly ?\DateTime $updatedAt = null,
    ) {
    }

    public static function createFromDatabaseResult(array $data): AbstractEntity
    {
        return new self(
            $data['id'],
            $data['login'],
            $data['password'],
            $data['token'],
            empty($data['token_expires_at'])
                ? null
                : new \DateTime($data['token_expires_at']),
            new \DateTime($data['created_at'] ?? self::DATE_NOW),
            new \DateTime($data['updated_at'] ?? self::DATE_NOW)
        );
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

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt ?? new \DateTime();
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt ?? new \DateTime();
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'password' => $this->password,
            'token' => $this->token,
            'token_expires_at' => $this->tokenExpiresAt?->format(self::DATE_FORMAT),
            'created_at' => $this->createdAt->format(self::DATE_FORMAT),
            'updated_at' => $this->updatedAt->format(self::DATE_FORMAT),
        ];
    }
}
