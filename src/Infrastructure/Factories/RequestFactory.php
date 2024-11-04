<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Exceptions\UnsupportedRequestException;
use Cgrd\Application\Http\RequestInterface;
use Cgrd\Infrastructure\Factories\Partials\AbstractPartialRequestFactory;

class RequestFactory
{
    public function __construct(
        private readonly array $factories = []
    ) {
    }

    public function createFromGlobals(): RequestInterface
    {
        /**
         * @var AbstractPartialRequestFactory $factory
         */
        foreach ($this->factories as $factory) {
            if (!$factory->supports()) {
                continue;
            }

            return $factory->create();
        }

        throw UnsupportedRequestException::create();
    }
}
