<?php
$_smarty->loadPlugin('smarty_function_test3');
function smarty_function_test2($params, $smarty)
{
    return smarty_function_test3($params, $smarty);
}
