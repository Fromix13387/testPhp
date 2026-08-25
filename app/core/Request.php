<?php

namespace app\core;

class Request
{
    private array $get;
    private array $post;
    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
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