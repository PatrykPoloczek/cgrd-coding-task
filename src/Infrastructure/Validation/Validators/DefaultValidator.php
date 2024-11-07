<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Validation\Validators;

use Cgrd\Application\Exceptions\ValidationException;
use Cgrd\Application\Models\Dtos\DtoInterface;
use Cgrd\Application\Validation\Constraints\ConstraintInterface;
use Cgrd\Application\Validation\Validators\ValidatorInterface;

class DefaultValidator implements ValidatorInterface
{
    public function validate(array $data, string $dtoClass): DtoInterface
    {
        $errors = [];
        $payload = [];

        /**
         * @var DtoInterface $dtoClass
         */
        foreach ($dtoClass::getRules() as $property => $rules) {
            foreach ($rules as $rule) {
                /** @var ConstraintInterface $instance */
                $instance = $rule instanceof ConstraintInterface
                    ? $rule
                    : new $rule
                ;
                if ($instance->check($property, $data)) {
                    $payload[$property] = $data[$property];

                    continue;
                }

                foreach ($instance->getErrorMessages() as $error) {
                    $errors[$property][] = $error;
                }
            }
        }

        if (!empty($error)) {
            throw ValidationException::createFromErrors($errors);
        }

        return new $dtoClass(...$payload);
    }
}
