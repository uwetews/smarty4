<?php
/**
 * outputfilter adds content of {head}-blocks to document<head>
 * @param string
 * @param Smarty
 * @return string
 */
function smarty_prefilter_test($source, $smarty)
{
    $s = $smarty->getConfigVars('sec1');
    var_dump($s);

    return $source . '<pre>';
}
