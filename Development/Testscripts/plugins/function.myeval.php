<?php
function smarty_function_myeval($params, $smarty)
{
    if (isset($params['var'])) {
        try {
            echo $smarty->fetch("eval:{$params['var']}", $template);
        } catch (Exception $e) {
            return;
        }
    }

    return;
}
