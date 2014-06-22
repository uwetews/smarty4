<?php
/**
 * outputfilter adds content of {head}-blocks to document<head>
 * @param string
 * @param Smarty
 * @return string
 */
function smarty_postfilter_testuwe($tpl_output, &$smarty)
{
    return '/*- post start -*/' . $tpl_output . '/*- post end -*/';
}
