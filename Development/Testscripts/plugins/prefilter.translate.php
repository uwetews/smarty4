<?php
/**
 * outputfilter adds content of {head}-blocks to document<head>
 * @param string
 * @param Smarty
 * @return string
 */
function smarty_prefilter_translate($source)
{
    $i18n = core::getInstance('i18n');
    $source = preg_replace_callback(
        '/##(.+?)##/',
        array($i18n, 'inSite'),
        $source
    );

    return $source;
}
