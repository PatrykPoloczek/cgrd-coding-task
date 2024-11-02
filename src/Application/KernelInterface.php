<?php

declare(strict_types=1);

namespace Cgrd\Application;

interface KernelInterface
{
    public function bootstrap(): void;
    public function run(): int;
}
