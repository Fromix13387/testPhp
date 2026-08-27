<?php

namespace app\core;

use RuntimeException;

class Router
{

    private array $routes = [];
    private mixed $defaultHandler = null;

    public function __construct()
    {

    }

    private function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function resolve(Request $request)
    {
        foreach ($this->routes as $route) {
            if ($route->match($request)) {
                return $route;
            }
        }

        if ($this->defaultHandler !== null) {
            return new Route($request->method(), $request->path(), $this->defaultHandler);
        }


        throw new RuntimeException('Путь не найден');
    }
    public function get($path, array|callable $handler): void
    {
        $this->addRoute(new Route('GET', $path, $handler));
    }
    public function post($path, array|callable $handler): void
    {
        $this->addRoute(new Route('POST', $path, $handler));
    }
    public function put($path, array|callable $handler): void
    {
        $this->addRoute(new Route('PUT', $path, $handler));
    }
    public function patch($path, array|callable $handler): void
    {
        $this->addRoute(new Route('PATCH', $path, $handler));
    }
    public function delete($path, array|callable $handler): void
    {
        $this->addRoute(new Route('DELETE', $path, $handler));
    }

    public function default(array|callable $handler): void
    {
        $this->defaultHandler = $handler;
    }

}