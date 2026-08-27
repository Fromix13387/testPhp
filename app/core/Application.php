<?php

namespace app\core;

class Application
{
    private array $config;
    private Container $container;
    private Router $router;
    private Request $request;
    private Response $response;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->request = new Request();
        $this->router = new Router();
        $this->container = new Container($this->config['components']);
        $this->response = new Response();
        $this->registerRoutes();

    }

    private function registerRoutes(): void
    {
        $webRoutes = require __DIR__ . '/../routes/web.php';
        $webRoutes($this->router);
    }

    public function run()
    {
        $route = $this->router->resolve($this->request);

        $result = $route->run($this->container, $this->request);

        $this->response->send($result);
    }
}