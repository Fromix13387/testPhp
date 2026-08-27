<?php

namespace app\controllers;
use app\core\Request;
use app\core\View;
use app\services\ArticleService;

class ArticleController
{
    public function __construct(
        private ArticleService $articleService,
        private View $view
    ) {}

    public function get(Request $request, int $id)
    {
        $data = $this->articleService->get($id, 3);

        if(!$data) {
            return $this->view->render('pages/not-found');
        }

        return $this->view->render('pages/article', $data);
    }

}