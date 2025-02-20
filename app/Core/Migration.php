<?php

namespace App\Core;

use PDO;

class Migration {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function applyMigrations() {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(__DIR__ . '/../migrations');
        $newMigrations = [];

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $migrationPath = __DIR__ . '/../migrations/' . $file;
            if (!file_exists($migrationPath)) {
                continue;
            }

            require_once $migrationPath;

            $className = pathinfo($file, PATHINFO_FILENAME);
            $fullyQualifiedClass = "Migrations\\$className";

            if (class_exists($fullyQualifiedClass)) {
                $instance = new $fullyQualifiedClass();
                $instance->up($this->pdo);
                $newMigrations[] = $className;
            } else {
                echo "Class $fullyQualifiedClass not found.\n";
            }
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        }
    }

    private function createMigrationsTable() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255)  NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    private function getAppliedMigrations() {
        $stmt = $this->pdo->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function saveMigrations(array $migrations) {
        $values = implode(',', array_map(fn($m) => "('$m')", $migrations));
        $this->pdo->exec("INSERT INTO migrations (migration) VALUES $values");
    }
}
