<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Models\Dtos;

use Cgrd\Application\Models\Dtos\DtoInterface;
use Cgrd\Infrastructure\Validation\Constraints\RequiredConstraint;

readonly class LoginInputDto implements DtoInterface
{
    public static function getRules(): array
    {
        return [
            'username' => [
                RequiredConstraint::class,
            ],
            'password' => [
                RequiredConstraint::class,
            ],
        ];
    }

    public function __construct(
        private string $username,
        private string $password
    ) {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
