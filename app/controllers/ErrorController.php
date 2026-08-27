<?php

namespace app\controllers;

use app\core\View;

class ErrorController
{
    public function __construct(private View $view) {}

    public function notFound()
    {
        http_response_code(404);
        return $this->view->render('pages/not-found');
    }

}