<?php

namespace app\commands;

use app\core\Database;
use app\seeders\ArticleCategorySeeder;
use app\seeders\ArticleSeeder;
use app\seeders\CategorySeeder;

class SeederRunner
{
    public function __construct(private Database $db) {}

    public function run(): void {
        $this->call([
            ArticleSeeder::class,
            CategorySeeder::class,
            ArticleCategorySeeder::class
        ]);
    }


    private function call(array $classes): void
    {
        foreach ($classes as $class) {
            $seeder = new $class();
            $seeder->run($this->db);
            echo "Выполнен: {$class}\n";
        }
    }
}