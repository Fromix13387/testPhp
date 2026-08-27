<?php

namespace app\core;

class Request
{
    private string $method;
    private string $path;
    private array $get;
    private array $post;
    private array $headers;
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $this->headers = getallheaders();
        $this->get = $_GET;
        $this->post = $_POST;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function header(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }

    public function get(?string $key = null) {
        if ($key === null) {
            return $this->get;
        }

        return $this->get[$key] ?? null;
    }

    public function post(?string $key = null) {
        if ($key === null) {
            return $this->post;
        }

        return $this->post[$key] ?? null;
    }
}