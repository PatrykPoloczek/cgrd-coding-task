<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure;

use Cgrd\Application\KernelInterface;
use Cgrd\Infrastructure\Factories\RequestFactory;

class Kernel implements KernelInterface
{
    private const SUCCESS = 0;

    public function bootstrap(): void
    {
    }

    public function run(): int
    {
        $this->bootstrap();
        $request = RequestFactory::createFromGlobals();

        return self::SUCCESS;
    }
}
