<?php

declare(strict_types=1);

namespace Cgrd\Application\Repositories;

use Cgrd\Application\Models\UserInterface;

interface UsersRepositoryInterface
{
    public function findOneByLoginAndPassword(
        string $login,
        string $password
    ): ?UserInterface;

    public function insert(UserInterface $model): void;
    public function update(UserInterface $model): void;
}
