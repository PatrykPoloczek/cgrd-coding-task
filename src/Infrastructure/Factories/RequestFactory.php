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
    public static function createFromJsonPayload()
    {
        $data = json_decode(
            json: file_get_contents('php://input'),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );
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
