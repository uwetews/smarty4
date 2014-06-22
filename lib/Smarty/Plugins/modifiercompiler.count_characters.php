<?php

/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsModifierCompiler
 */

/**
 * Smarty count_characters modifier plugin
 * Type:     modifier<br>
 * Name:     count_characteres<br>
 * Purpose:  count the number of characters in a text
 *
 * @link   http://www.smarty.net/docs/en/language.modifier.count.characters.tpl count_characters (Smarty online manual)
 * @author Uwe Tews
 *
 * @param  Smarty_Compiler_CompilerCore $compiler   compiler object
 * @param string                        $input      input string
 * @param bool|string                   $whitespace flag count whitespaces
 *
 * @return string with compiled code
 */
// NOTE: The parser does pass all parameter as strings which could be directly inserted into the compiled code string
function smarty_modifiercompiler_count_characters(Smarty_Compiler_CompilerCore $compiler, $input, $whitespace = 'false')
{
    if (preg_match('/^([\'"]?)[a-zA-Z0-9_]+(\\1)$/', $whitespace)) {
        $wspace = trim($whitespace, "'\"");
        if ($wspace == 'false') {
            return "preg_match_all('/[^\s]/" . Smarty::$_UTF8_MODIFIER . "', {$input}, \$tmp)";
        }
        if ($wspace == 'true') {
            if (Smarty::$_MBSTRING) {
                return "mb_strlen({$input}, SMARTY_RESOURCE_CHAR_SET)";
            }
            // no MBString fallback
            return "strlen({$input})";
        }
    }
    // could not optimize |count_characters, so fallback to regular plugin
    if ($compiler->tag_nocache | $compiler->nocache) {
        $compiler->required_plugins['nocache']['escape']['modifier']['file'] = Smarty::$_SMARTY_PLUGINS_DIR . 'modifier.count_characters';
        $compiler->required_plugins['nocache']['escape']['modifier']['function'] = 'smarty_modifier_count_characters';
    } else {
        $compiler->required_plugins['compiled']['escape']['modifier']['file'] = Smarty::$_SMARTY_PLUGINS_DIR . 'modifier.count_characters.php';
        $compiler->required_plugins['compiled']['escape']['modifier']['function'] = 'smarty_modifier_count_characters';
    }

    return "smarty_modifier_count_characters({$input}, {$whitespace})";
}
