<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Validation\Constraints;

class NumericConstraint extends AbstractConstraint
{
    public function check(string $name, array $data = []): bool
    {
        $value = $data[$name] ?? null;

        if (is_numeric($value)) {
            return true;
        }

        $this->errorMessages[] = sprintf(
            'Property %s must be a number.',
            $name
        );

        return false;
    }
}
