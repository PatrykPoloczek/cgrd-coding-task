<?php

declare(strict_types=1);

namespace Migrations;

interface MigrationInterface
{
    public function up(): iterable;
    public function down(): string;
}
