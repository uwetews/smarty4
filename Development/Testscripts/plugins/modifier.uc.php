<?php
/**
 * @smarty_template_object bb
 */
function smarty_modifier_uc(Smarty $tpl, $string)
{
    return strtoupper($string);
}
