<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Validation\Constraints;

use Cgrd\Application\Validation\Constraints\ConstraintInterface;

class RequiredConstraint extends AbstractConstraint
{
    public function check(string $name, array $data = []): bool
    {
        $this->errorMessages = [];

        if (!empty($data[$name] ?? [])) {
            return true;
        }

        $this->errorMessages[] = sprintf(
            'Property %s is required.',
            $name
        );

        return false;
    }
}
