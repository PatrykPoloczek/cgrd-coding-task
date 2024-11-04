<?php

declare(strict_types=1);

namespace Seeders;

class Seed_1730590449 implements SeederInterface
{
    public function getQueries(): iterable
    {
        yield from [
            <<<SQL
            insert into articles(title, body, user_id, created_at, updated_at)
            values ('Sample title 1', 'Sample body 1', 1, '2024-01-01', '2024-02-02')
            SQL,
            <<<SQL
            insert into articles(title, body, user_id, created_at, updated_at)
            values ('Sample title 2', 'Sample body 2', 1, '2024-01-01', '2024-02-02')
            SQL,
        ];
    }
}
