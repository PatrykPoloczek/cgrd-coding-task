<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Validation\Constraints;

class UserIdExistsConstraint extends AbstractConstraint
{
    public function check(string $name, array $data = []): bool
    {
        $value = $data[$name] ?? null;

        if ($value === 1) {
            return true;
        }

        $this->errorMessages[] = 'Provided user does not exist.';

        return false;
    }
}
