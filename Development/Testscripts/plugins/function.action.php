<?php
function smarty_function_action($params, $smarty, $template)
{

    $action = $params['action'];

    if ($action == 'right.tpl') {

        $smarty->caching = 2;

        $smarty->cache_lifetime = 10;

        if ($smarty->isCached($action))

            echo 'da';

    }

    $tpl = $smarty->createTemplate($action, null, null, $template);

    if ($action == 'right.tpl') {

        $smarty->caching = 0;

        $smarty->cache_lifetime = 3600;

    }

    $tpl->assign('test', time());

    $response = $tpl->fetch();

    return $response;

}
