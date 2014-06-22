<?php
function smarty_block_uc($params, $content, &$smarty)
{
    if (is_null($content)) {
        return;
    }

    return ucfirst($content);

}

/* vim: set expandtab: */
