<?php
function smarty_function_include_if_exists($params, $smarty, $template)
{
    $include_file = $params['file'];
    if ($smarty->templateExists($include_file)) {
        $tpl = $smarty->createTemplate($include_file, null, null, $template);
        $tpl->assign($params);
        echo $tpl->fetch();
    }

    return;
}
