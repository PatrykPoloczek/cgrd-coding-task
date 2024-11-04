<?php

declare(strict_types=1);

namespace Seeders;

interface SeederInterface
{
    public function getQueries(): iterable;
}
