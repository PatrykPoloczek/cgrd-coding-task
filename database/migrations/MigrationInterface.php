<?php

declare(strict_types=1);

namespace Migrations;

interface MigrationInterface
{
    public function up(): string;
    public function down(): string;
}
