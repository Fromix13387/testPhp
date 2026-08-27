<?php

namespace app\seeders;

use app\core\Database;
use app\core\SeederInterface;

class ArticleSeeder implements SeederInterface
{
    public function run(Database $db): void
    {
        $faker = \Faker\Factory::create('ru_RU');

        for ($i = 0; $i < 100; $i++) {
            $db->execute(
                'INSERT INTO articles (image, name, description, text, views)
         VALUES (:image, :name, :description, :text, :views)',
                [
                    'image' => $faker->imageUrl(800, 600, 'animals'),
                    'name' => $faker->sentence(3),
                    'description' => $faker->paragraph(),
                    'text' => $faker->text(),
                    'views' => $faker->numberBetween(0, 10000),
                ]
            );
        }
    }
}