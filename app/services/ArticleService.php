<?php

namespace app\services;
use app\repositories\ArticleRepo;

class ArticleService
{
    public function __construct(
        private ArticleRepo $articleRepo,
    ) {
    }

    public function get($id, $limit = 3): ?array
    {
        $article = $this->articleRepo->find($id);

        if (!$article) {
            return null;
        }

        return [
            'article' => $article,
            'similarArticles' => $this->articleRepo->findSimilar($id, $limit),
        ];
    }
}