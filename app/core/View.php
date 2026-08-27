<?php

namespace app\core;

use Smarty\Smarty;

class View
{
    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(__DIR__ . '/../views/');
    }

    public function render(string $template, array $params = []): string
    {
        $this->smarty->assign($params);
        return $this->smarty->fetch($template . '.tpl');
    }
}