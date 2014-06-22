<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     block.test.php
 * Type:     block
 * Name:     test
 * Purpose:
 * -------------------------------------------------------------
 */
function smarty_block_test($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    // only output on the closing tag
    if (!$repeat) {
        if (isset($content)) {
            return "<i>$content</i>";
        }
    }
}
