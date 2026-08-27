<?php

use app\core\Database;

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/config.php';

$db = new Database($config['components']['db']);

$runner = new \app\commands\SeederRunner($db);
$runner->run();


