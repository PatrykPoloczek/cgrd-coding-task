<?php

namespace Cgrd\Infrastructure\Validation\Constraints;

class MinimalLengthConstraint extends AbstractConstraint
{
    public function __construct(
        private readonly int $minimumLength
    ) {
    }

    public function check(string $name, array $data = []): bool
    {
        $value = $data[$name] ?? '';

        if (strlen($value) >= $this->minimumLength) {
            return true;
        }

        $this->errorMessages[] = sprintf(
            'Property %s can not be shorter than %d characters.',
            $name,
            $this->minimumLength
        );

        return false;
    }
}