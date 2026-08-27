<?php

use app\controllers\ArticleController;
use app\controllers\CategoryController;
use app\controllers\ErrorController;
use app\controllers\HomeController;

return function (\app\core\Router $router)
{
    $router->get('/', [HomeController::class, 'index']);
    $router->get('/category/{id}', [CategoryController::class, 'get']);
    $router->get('/article/{id}', [ArticleController::class, 'get']);

    $router->default([ErrorController::class, 'notFound']);
};