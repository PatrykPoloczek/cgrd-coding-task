<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Controllers;

abstract class AbstractController
{
    private const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json',
    ];

    public function __construct(
        protected readonly string $viewsStoragePath
    ) {
    }

    public function renderResponse(
        $data,
        int $statusCode,
        array $headers = self::DEFAULT_HEADERS
    ) {
    }
}
