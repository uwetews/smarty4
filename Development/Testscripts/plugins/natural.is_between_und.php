<?php
function smarty_natural_is_between_und(Smarty $smarty, $p1, $p2, $p3)
{
    return $p1 >= $p2 && $p1 <= $p3;
}
