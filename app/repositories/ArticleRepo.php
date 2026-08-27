<?php

namespace app\repositories;
use app\core\Database;

class ArticleRepo
{
    public function __construct(private Database $db) {}

    public function findLatestByCategory(int $limit = 3): array
    {
        $rows = $this->db->fetchAll('
        SELECT *
        FROM (
            SELECT categories.id AS category_id,  categories.name AS category_name,
                articles.id AS article_id, articles.name AS article_name,  articles.description AS article_description,
                articles.image, articles.created_at,

                ROW_NUMBER() OVER (
                    PARTITION BY categories.id
                    ORDER BY articles.created_at DESC
                ) AS rowNumber
            FROM categories
            INNER JOIN article_category
                ON article_category.category_id = categories.id
            INNER JOIN articles
                ON articles.id = article_category.article_id
        ) t
        WHERE rowNumber <= :limit
        ORDER BY category_id, created_at DESC
    ', ['limit' => $limit]);

        return $this->groupByCategory($rows);
    }

    public function findByCategoryId(
        int $id,
        int $limit,
        int $offset,
        ?string $sort = null,
        ?string $order = null
    ): array
    {
        $sql = '
            SELECT articles.*
            FROM articles
            INNER JOIN article_category
            ON article_category.article_id = articles.id
            WHERE article_category.category_id = :id
        ';

        if ($sort !== null) {
            $orderBy = match ($sort) {
                'views' => 'articles.views',
                'date' => 'articles.created_at',
                default => 'articles.id',
            };

            $order = strtolower($order ?? '') === 'asc'
                ? 'ASC'
                : 'DESC';

            $sql .= " ORDER BY {$orderBy} {$order}";
        }

        $sql .= ' LIMIT :limit OFFSET :offset';

        return $this->db->fetchAll($sql, [
            'id' => $id,
            'limit' => $limit,
            'offset' => $offset,
        ]);
    }

    public function countByCategoryId($id): int
    {
        $row = $this->db->fetchOne('
            SELECT COUNT(*) as count
            FROM article_category
            WHERE category_id = :id
        ', ['id' => $id]);
        return $row['count'] ?? 0;
    }

    public function find($id): false|array
    {
        return $this->db->fetchOne('
            SELECT *
            FROM articles
            WHERE id = :id
        ', ['id' => $id]);
    }

    public function findSimilar(int $articleId, int $limit = 3): array
    {
        return $this->db->fetchAll("
            SELECT
                articles.*,
                COUNT(DISTINCT article_category.category_id) AS catCount
            FROM articles
            INNER JOIN article_category
                ON article_category.article_id = articles.id
            WHERE article_category.category_id IN (
                SELECT category_id
                FROM article_category
                WHERE article_id = :article_id
            )
            AND articles.id != :exclude_article_id
            GROUP BY articles.id
            ORDER BY catCount DESC, articles.created_at DESC
            LIMIT :limit
        ", ['article_id' => $articleId, 'exclude_article_id' => $articleId, 'limit' => $limit]);
    }

    private function groupByCategory(array $rows): array
    {
        $categories  = [];
        foreach ($rows as $row) {
            $categoryId = $row['category_id'];
            if (!isset($categories[$categoryId])) {
                $categories[$categoryId] = [
                    'id' => $categoryId,
                    'name' => $row['category_name'],
                    'articles' => []
                ];
            }
            $categories[$categoryId]['articles'][] = [
                'id' => $row['article_id'],
                'name' => $row['article_name'],
                'description' => $row['article_description'],
                'image' => $row['image'],
                'created_at' => $row['created_at']
            ];
        }
        return array_values($categories);
    }
}