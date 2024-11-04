<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Handlers;

use Cgrd\Application\Repositories\UsersRepositoryInterface;

class LogoutUserHandler
{
    public function __construct(
        private readonly UsersRepositoryInterface $usersRepository
    ) {
    }

    public function handle(): bool
    {
        return true;
    }
}
