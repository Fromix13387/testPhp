<?php

namespace app\services;
use app\repositories\ArticleRepo;
use app\repositories\CategoryRepo;

class CategoryService
{
    public function __construct(
        private CategoryRepo $categoryRepo,
        private ArticleRepo $articleRepo,
    ) {
    }

    public function get($id, $page = 1, $limit = 4, $sort = null, $order = null): ?array
    {
        $category = $this->categoryRepo->find($id);

        if (!$category) {
            return null;
        }

        $pagination = PaginationService::paginate(
            $this->articleRepo->countByCategoryId($id),
            $page,
            $limit
        );

        return [
            'articles' => $this->articleRepo->findByCategoryId(
                $id,
                $pagination['perPage'],
                $pagination['offset'],
                $sort,
                $order
            ),
            'category' => $category,
            'pagination' => $pagination,
            'sort' => $sort,
            'order' => $order
        ];
    }
}