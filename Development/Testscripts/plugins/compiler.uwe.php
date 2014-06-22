<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     compiler.tplheader.php
 * Type:     compiler
 * Name:     tplheader
 * Purpose:  Output header containing the source file name and
 *           the time it was compiled.
 * -------------------------------------------------------------
 */
function smarty_compiler_uwe($tag_arg, &$smarty)
{
    var_dump($tag_arg);

    return "hallo";
}

function smarty_compiler_uweclose($tag_arg, &$smarty)
{
    var_dump($tag_arg);

    return "close done";
}
