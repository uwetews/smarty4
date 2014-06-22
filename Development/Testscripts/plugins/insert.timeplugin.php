<?php
function smarty_insert_timeplugin($params, $smarty, $template)
{
    return 'plugin ' . $params['var'] . time();
}
