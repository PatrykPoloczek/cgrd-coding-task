<?php

declare(strict_types=1);

class Migration_1730590446
{
    public function up(): string
    {
        return <<<SQL
        CREATE TABLE users(
            id INTEGER PRIMARY KEY,
            login varchar(30) UNIQUE NOT NULL,
            password varchar(255) NOT NULL,
            token varchar(255)
        ) IF NOT EXISTS
        SQL;
    }

    public function down(): string
    {
        return <<<SQL
        DROP TABLE users
        SQL;
    }
}
