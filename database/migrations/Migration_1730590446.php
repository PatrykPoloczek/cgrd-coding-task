<?php

declare(strict_types=1);

namespace Migrations;

class Migration_1730590446 implements MigrationInterface
{
    public function up(): iterable
    {
        return [
            <<<SQL
            create table if not exists users
            (
                id         INTEGER      not null
                    primary key autoincrement,
                login      VARCHAR(50)  not null,
                password   VARCHAR(255) not null,
                token      VARCHAR(255),
                token_expires_at DATETIME,
                created_at DATETIME     not null,
                updated_at DATETIME     not null
            );
            SQL,
            <<<SQL
            create index if not exists login on users (login);
            SQL,
            <<<SQL
            create unique index if not exists login_unique on users (login);
            SQL,
            <<<SQL
            create index if not exists token on users (token);
            SQL,
        ];
    }

    public function down(): string
    {
        return <<<SQL
        drop table if exists users
        SQL;
    }
}
