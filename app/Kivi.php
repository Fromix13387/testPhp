<?php

namespace app;
use app\core\Application;

class Kivi
{
    private static Application $app;

    public static function setApp(Application $app): void
    {
        self::$app = $app;
    }

    public static function app(): Application
    {
        return self::$app;
    }
}