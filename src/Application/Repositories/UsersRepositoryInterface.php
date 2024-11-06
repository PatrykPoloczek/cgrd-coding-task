<?php

declare(strict_types=1);

namespace Cgrd\Application\Repositories;

use Cgrd\Application\Models\UserInterface;

interface UsersRepositoryInterface
{
    public function findOneByLogin(string $login): ?UserInterface;

    public function findOneByToken(string $token): ?UserInterface;

    public function insert(UserInterface $model): void;
    public function update(UserInterface $model): void;
}
