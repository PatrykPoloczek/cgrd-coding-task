<?php

declare(strict_types=1);

namespace Cgrd\Application\Validation\Validators;

use Cgrd\Application\Models\Dtos\DtoInterface;

interface ValidatorInterface
{
    public function validate(array $data, string $dtoClass): DtoInterface;
}
