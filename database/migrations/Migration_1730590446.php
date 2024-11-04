<?php

declare(strict_types=1);

namespace Migrations;

class Migration_1730590446
{
    public function up(): string
    {
        return <<<SQL
        create table if not exists users
        (
            id         INTEGER      not null
                primary key autoincrement,
            login      VARCHAR(50)  not null,
            password   VARCHAR(255) not null,
            token      VARCHAR(255),
            created_at DATETIME     not null,
            updated_at DATETIME     not null
        );

        create index login
            on users (login);

        create unique index login_unique
            on users (login);

        create index token
            on users (token);
        SQL;
    }

    public function down(): string
    {
        return <<<SQL
        drop table if exists users
        SQL;
    }
}
