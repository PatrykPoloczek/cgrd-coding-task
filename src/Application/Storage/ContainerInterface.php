<?php

declare(strict_types=1);

namespace Cgrd\Application\Storage;

interface ContainerInterface
{
    /** @return mixed */
    public function get(string $id);

    public function has(string $id): bool;
}
