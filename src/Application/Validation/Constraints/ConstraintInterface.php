<?php

declare(strict_types=1);

namespace Cgrd\Application\Validation\Constraints;

interface ConstraintInterface
{
    public function check(string $name, array $data = []): bool;
    /** @return array<int, string> */
    public function getErrorMessages(): array;
}
