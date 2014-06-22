<?php
/**
 * outputfilter adds content of {head}-blocks to document<head>
 * @param string
 * @param Smarty
 * @return string
 */
function smarty_outputfilter_testuwe($tpl_output, &$smarty)
{
    return '- output -' . $tpl_output . '- output -';
}
