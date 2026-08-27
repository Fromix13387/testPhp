<?php

return function (\app\core\Router $router)
{
    $router->get('/api/{id}/test', function (\app\core\Request $request, $id) {
        return 'Hello world!' . " $id";
    });
};