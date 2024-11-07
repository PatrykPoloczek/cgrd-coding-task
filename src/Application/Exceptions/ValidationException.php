<?php

declare(strict_types=1);

namespace Cgrd\Application\Exceptions;

use Cgrd\Application\Enums\ResponseStatusCodeEnum;

class ValidationException extends HttpException
{
    public function __construct(
        private readonly array $errors = [],
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function createFromErrors(array $errors): self
    {
        return new self(
            $errors,
            'Provided payload contains validation error.',
            ResponseStatusCodeEnum::BAD_REQUEST->value
        );
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
