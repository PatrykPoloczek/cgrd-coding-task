<?php

declare(strict_types=1);

namespace Seeders;

class Seed_1730590446 implements SeederInterface
{
    public function getQueries(): iterable
    {
        yield from [
            <<<SQL
            insert into users(login, password, created_at, updated_at)
            values('admin', '$2y$12$3OigLZmw/D5yqz0efslVLuSL.6R0IiWYcvleCF75RiANvDYWy3GNm', '2024-11-04', '2024-11-04');
            SQL,
        ];
    }
}
