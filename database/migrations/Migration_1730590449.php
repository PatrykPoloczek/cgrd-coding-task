<?php

declare(strict_types=1);

namespace Migrations;

class Migration_1730590449 implements MigrationInterface
{
    public function up(): iterable
    {
        return [
            <<<SQL
            create table if not exists articles
            (
                id         INTEGER     not null
                    primary key autoincrement,
                public_id  VARCHAR(255) not null,
                title      VARCHAR(100) not null,
                body       TEXT(1000)   not null,
                user_id    INT(10)      not null
                    constraint users_id_fk
                        references users
                        on update cascade on delete cascade,
                created_at DATETIME     not null,
                updated_at DATETIME     not null
            );
            SQL,
            <<<SQL
            create index public_id on articles (public_id);
            SQL,
            <<<SQL
            create unique index public_id_unique on articles (public_id);
            SQL,
        ];
    }

    public function down(): string
    {
        return <<<SQL
        drop table if exists articles
        SQL;
    }
}
