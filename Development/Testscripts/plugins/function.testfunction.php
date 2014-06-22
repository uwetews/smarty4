<?php

function smarty_function_testfunction($params, &$template)
{
    $tpl = $template->createTemplate('menu.tpl');
    $tpl->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
    $tpl->setCacheLifetime(20);

    if (!$tpl->isCached()) {
        $tpl->assignGlobal('menu', rand(0, 100000));
    }

    $output = $tpl->fetch();
    $template->setCaching(Smarty::CACHING_OFF);

    return $output;
}
