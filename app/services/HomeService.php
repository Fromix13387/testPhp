<?php

namespace app\services;

use app\repositories\ArticleRepo;

class HomeService
{
    public function __construct(
        private ArticleRepo $articleRepo
    ) {
    }

    public function getHome(): array
    {
        return [
            'categories' => $this->articleRepo->findLatestByCategory(3),
        ];
    }
}