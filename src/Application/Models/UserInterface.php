<?php

declare(strict_types=1);

namespace Cgrd\Application\Models;

interface UserInterface
{
    public function getId(): int;
    public function getLogin(): string;
    public function getPassword(): string;
}
