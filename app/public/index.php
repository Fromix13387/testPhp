<?php

use app\core\Application;
use app\Kivi;

require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/../config/config.php';

$app = new Application($config);

Kivi::setApp($app);

$app->run();
