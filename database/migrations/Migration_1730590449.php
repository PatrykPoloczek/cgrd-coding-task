<?php

declare(strict_types=1);

namespace Migrations;

class Migration_1730590449
{
    public function up(): string
    {
        return <<<SQL
        create table if not exists articles
        (
            id         INTEGER     not null
                primary key autoincrement,
            title      VARCHAR(100) not null,
            body       TEXT(1000)   not null,
            user_id    INT(10)      not null
                constraint users_id_fk
                    references users
                    on update cascade on delete cascade,
            created_at DATETIME     not null,
            updated_at DATETIME     not null
        );
        SQL;
    }

    public function down(): string
    {
        return <<<SQL
        drop table if exists articles
        SQL;
    }
}
