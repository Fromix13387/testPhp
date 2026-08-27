<?php

namespace app\seeders;

use app\core\SeederInterface;

class ArticleCategorySeeder implements SeederInterface
{
    public function run(\app\core\Database $db): void
    {
        $faker = \Faker\Factory::create('ru_RU');
        $articleIds = array_column($db->fetchAll('SELECT id FROM articles'), 'id');

        $categoryIds = array_column($db->fetchAll('SELECT id FROM categories'), 'id');

        foreach ($articleIds as $articleId) {
            $randomCategoryIds = $faker->randomElements(
                $categoryIds,
                $faker->numberBetween(1, min(5, count($categoryIds)))
            );

            foreach ($randomCategoryIds as $categoryId) {
                $db->execute(
                    'INSERT INTO article_category (article_id, category_id) VALUES (:article_id, :category_id)',
                    ['article_id' => $articleId, 'category_id' => $categoryId]
                );
            }
        }
    }
}