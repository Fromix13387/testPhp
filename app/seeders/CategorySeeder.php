<?php

namespace app\seeders;

use app\core\Database;
use app\core\SeederInterface;

class CategorySeeder implements SeederInterface
{
    public function run(Database $db): void
    {
        $faker = \Faker\Factory::create('ru_RU');

        for ($i = 0; $i < 8; $i++) {
            $db->execute(
                'INSERT INTO categories (name, description)
         VALUES (:name, :description)',
                [
                    'name' => $faker->unique()->words(2, true),
                    'description' => $faker->paragraph(),
                ]
            );
        }
    }

}