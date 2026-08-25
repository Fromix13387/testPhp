<?php

namespace app\core;

use app\controllers\TestController;

class Application
{
    private array $config;

//    private Database $db;
    private Container $container;
    private Request $request;
    private Response $response;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function run()
    {
        $this->request = new Request();
        $this->container = new Container($this->config['components']);


//        $this->container->make(TestController::class);

        $this->response = new Response();

    }
}