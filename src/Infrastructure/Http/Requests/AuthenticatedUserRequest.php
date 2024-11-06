<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Http\Requests;

use Cgrd\Application\Enums\RequestMethodEnum;
use Cgrd\Application\Models\UserInterface;

class AuthenticatedUserRequest extends Request
{
    public function __construct(
        private readonly UserInterface $user,
        RequestMethodEnum $method,
        string $path,
        string $body,
        array $headers = [],
        array $parameters = []
    ) {
        parent::__construct(
            $method,
            $path,
            $body,
            $headers,
            $parameters
        );
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
