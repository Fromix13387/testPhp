<?php

namespace app\core;

interface SeederInterface
{
    public function run(Database $db): void;
}