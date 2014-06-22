<?php
/**
 * Smarty {extract} compiler function plugin
 *
 * Type:     compiler function<br>
 * Name:     extract<br>
 * Purpose:  assign a value to a template variable
 * @link http://smarty.php.net/manual/en/language.custom.functions.php#LANGUAGE.FUNCTION.ASSIGN {assign}
 *       (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com> (initial author)
 * @author messju mohr <messju at lammfellpuschen dot de> (conversion to compiler function)
 * @param string containing var-attribute and value-attribute
 * @param Smarty_Compiler
 */
function smarty_compiler_extract($tag_attrs, $smarty)
{
    if (!isset($tag_attrs[0])) {
        trigger_error("assign: missing array parameter", E_USER_WARNING);

        return;
    }

    $code_obj = "<?php \$_smarty_tpl->assign(" . $tag_attrs[0] . ");?>";

    return $code_obj;
}
