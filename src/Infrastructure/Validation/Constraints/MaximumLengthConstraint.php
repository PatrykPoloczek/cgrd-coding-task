<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Validation\Constraints;

class MaximumLengthConstraint extends AbstractConstraint
{
    public function __construct(
        private readonly int $maximumLength
    ) {
    }

    public function check(string $name, array $data = []): bool
    {
        $value = $data[$name] ?? '';

        if (strlen($value) <= $this->maximumLength) {
            return true;
        }

        $this->errorMessages[] = sprintf(
            'Property %s can not be longer than %d characters.',
            $name,
            $this->maximumLength
        );

        return false;
    }
}
