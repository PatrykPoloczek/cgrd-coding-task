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
            $data['created_at'],
            $data['updated_at']
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
            'created_at' => $this->createdAt->format(self::DATE_FORMAT),
            'updated_at' => $this->updatedAt->format(self::DATE_FORMAT),
        ];
    }
}
