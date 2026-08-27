<?php

namespace app\commands;

use app\core\Database;

class MigrationRunner
{
    public function __construct(
        private Database $db,
        private string $migrationPath
    ) {}

    public function migrate(): void {
        $this->createTable();

        $applied = $this->getApplied();

        $files = glob($this->migrationPath . '/*.php');
        sort($files);


        $newMigrations = [];
        foreach ($files as $file) {
            $name = basename($file);

            if(in_array($name, $applied)) {
                continue;
            }

            $migration = include $file;

            $migration->up($this->db);

            $this->db->execute("INSERT INTO migrations (migration) VALUES (:migration)", [
                ':migration' => $name
            ]);

            $newMigrations[] = $name;
            echo "Успешно применена миграция: " . $name . PHP_EOL;
        }

        echo (!empty($newMigrations) ? "Применено " . count($newMigrations) . " новых миграций: " : "Новых миграций нет.") . PHP_EOL;
    }

    private function createTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    public function getApplied(): array
    {
        return $this->db->fetchAll("SELECT migration FROM migrations ORDER BY created_at");
    }
}