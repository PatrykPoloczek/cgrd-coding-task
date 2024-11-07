<?php

declare(strict_types=1);

namespace Cgrd\Application\Models\Dtos;

use Cgrd\Application\Validation\Constraints\ConstraintInterface;

interface DtoInterface
{
    /** @return array<string, array<int, ConstraintInterface|string>> */
    public static function getRules(): array;
}
