<?php

namespace app\controllers;

use app\core\View;
use app\services\HomeService;

class HomeController
{
    public function __construct(
        private HomeService $homeService,
        private View $view,
    ) {}

    public function index(): string
    {
        return $this->view->render('pages/home', $this->homeService->getHome());
    }
}