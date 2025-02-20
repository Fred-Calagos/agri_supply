<?php

require_once __DIR__ . '/vendor/autoload.php';
$pdo = require __DIR__ . '/app/config/database.php'; // Fix this line

use App\Core\Migration;

$migration = new Migration($pdo);
$migration->applyMigrations();

echo "Migrations applied successfully.\n";
