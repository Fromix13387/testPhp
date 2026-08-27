<?php

namespace app\controllers;
use app\core\Request;
use app\core\View;
use app\services\CategoryService;

class CategoryController
{
    public function __construct(
        private CategoryService $categoryService,
        private View $view,
    ) {}

    public function get(Request $request, int $id): string
    {
        $data = $this->categoryService->get(
            id: $id,
            page: $request->get('page') ?? 1,
            sort: $request->get('sort'),
            order: $request->get('order')
        );

        if(!$data) {
            http_response_code(404);
            return $this->view->render('pages/not-found');
        }

        return $this->view->render(
            'pages/category',
            $data
        );
    }
}