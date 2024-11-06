<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Builders;

use Cgrd\Application\Models\UserInterface;
use Cgrd\Infrastructure\Models\User;

class UserModelBuilder
{
    private int $id;
    private string $login;
    private string $password;
    private ?string $token = null;
    private ?\DateTime $createdAt = null;
    private ?\DateTime $updatedAt = null;

    public function withId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function withLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function withPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function withoutToken(): self
    {
        $this->token = null;

        return $this;
    }

    public function withToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function withCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function withUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function build(): UserInterface
    {
        return new User(
            $this->id,
            $this->login,
            $this->password,
            $this->token,
            $this->createdAt ?? new \DateTime(),
            $this->updatedAt ?? new \DateTime()
        );
    }
}
