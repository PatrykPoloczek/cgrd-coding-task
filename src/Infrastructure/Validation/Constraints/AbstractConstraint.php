<?php

namespace Cgrd\Infrastructure\Validation\Constraints;

use Cgrd\Application\Validation\Constraints\ConstraintInterface;

abstract class AbstractConstraint implements ConstraintInterface
{
    protected array $errorMessages = [];

    public abstract function check(string $name, array $data = []): bool;
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }
}