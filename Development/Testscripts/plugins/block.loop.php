<?php
/* @author Monte Ohrt <monte at ohrt dot com>
 * @param string $content contents of the block
 * @param object $smarty Smarty object
 * @param boolean &$repeat repeat flag
 * @param object $template template object
 * @return string content re-formatted
 */
function smarty_block_loop($params, $content, $smarty, &$repeat, $template)
{
    global $loop;
    if (is_null($content)) {
        if (isset($params['count'])) {
            $loop = $params['count'];

            return;
        }
    }

    $loop--;

    if ($loop) $repeat = true;
    return $content . $loop;
}
