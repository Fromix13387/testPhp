<?php

namespace app\core;

use RuntimeException;

class Route
{
    public string $method;
    public array $params;
    public string $path;
    public mixed $handler;

    public function __construct(string $method, string $path, array|callable $handler)
    {
        $this->method = $method;
        $this->path = $path;
        $this->handler = $handler;
    }

    public function match(Request $request): bool
    {
        if($request->method() !== $this->method) {
            return false;
        }

        $pattern = preg_replace(
            '/\{([^\/]+)\}/',
            '(?P<$1>[^/]+)',
            $this->path
        );

        $pattern = '#^' . $pattern . '$#';

        if (!preg_match($pattern, $request->path(), $matches)) {
            return false;
        }

        $this->params = array_filter($matches, fn ($key) => !is_int($key), ARRAY_FILTER_USE_KEY);

        return true;
    }

    public function run(Container $container, Request $request): mixed {
        if (is_callable($this->handler)) {
            return call_user_func($this->handler, $request, ...array_values($this->params));
        }

        if(is_array($this->handler)) {
            [$controllerClass, $action] = $this->handler;

            $controller = $container->make($controllerClass);
            return $controller->{$action}($request, ...array_values($this->params));
        }

        throw new RuntimeException("Не верный handler");
    }
}