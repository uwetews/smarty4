<?php
/* @author Monte Ohrt <monte at ohrt dot com>
 * @param string $content contents of the block
 * @param object $smarty Smarty object
 * @param boolean &$repeat repeat flag
 * @param object $template template object
 * @return string content re-formatted
 */
function smarty_block_surround_by_tpl($params, $surroundedContent, &$smarty)
{
    if (isset($surroundedContent)) {
        // Assign all other parameters
        foreach ($params as $tplVar => $value)
            $smarty->assign($tplVar, $value);

        $smarty->assign("surroundedContent", $surroundedContent);

        // Display template
        return $smarty->fetch($params["template"]);
    }
}
