<?php

declare(strict_types=1);

namespace Seeders;

class Seed_1730590449 implements SeederInterface
{
    public function getQueries(): iterable
    {
        yield from [
            <<<SQL
            insert into articles(public_id, title, body, user_id, created_at, updated_at)
            values ('cdd903b015e818be87919efe0dfd24dcdaa11559', 'Sample title 1', 'Sample body 1', 1, '2024-01-01', '2024-02-02')
            SQL,
            <<<SQL
            insert into articles(public_id, title, body, user_id, created_at, updated_at)
            values ('a749204f137f38e3e3379993bad34f483860b129', 'Sample title 2', 'Sample body 2', 1, '2024-01-01', '2024-02-02')
            SQL,
        ];
    }
}
