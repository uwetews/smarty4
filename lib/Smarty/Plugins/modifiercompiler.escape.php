<?php

/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsModifierCompiler
 */
/**
 * @ignore
 */

/**
 * Smarty escape modifier plugin
 * Type:     modifier<br>
 * Name:     escape<br>
 * Purpose:  escape string for output
 *
 * @link   http://www.smarty.net/docs/en/language.modifier.escape.tpl (Smarty online manual)
 * @author Rodney Rehm
 *
 * @param  Smarty_Compiler_CompilerCore $compiler      compiler object
 * @param string                        $input         input string
 * @param string                        $esc_type      escape type
 * @param string                        $char_set      character set, used for htmlspecialchars() or htmlentities()
 * @param bool|string                   $double_encode encode already encoded entitites again, used for htmlspecialchars() or htmlentities()
 *
 * @return string with compiled code
 */
// NOTE: The parser does pass all parameter as strings which could be directly inserted into the compiled code string
function smarty_modifiercompiler_escape(Smarty_Compiler_CompilerCore $compiler, $input, $esc_type = 'html', $char_set = 'null', $double_encode = 'true')
{
    static $_double_encode = null;
    if ($_double_encode === null) {
        $_double_encode = version_compare(PHP_VERSION, '5.2.3', '>=');
    }
    if (trim($char_set, "'\"") == 'null') {
        $char_set = '\'' . Smarty::$_CHARSET . '\'';
    }
    if (preg_match('/^([\'"]?)[a-zA-Z0-9_]+(\\1)$/', $esc_type)) {
        // $esc_type is literal so we can produce compiled code
        $esc = trim($esc_type, "'\"");
        switch ($esc) {
            case 'html':
                if ($_double_encode) {
                    return "htmlspecialchars({$input}, ENT_QUOTES, {$char_set}, {$double_encode})";
                } elseif ($double_encode) {
                    return "htmlspecialchars({$input}, ENT_QUOTES, {$char_set})";
                } else {
                    // fall back to modifier.escape.php
                }
                break;

            case 'htmlall':
                if (Smarty::$_MBSTRING) {
                    if ($_double_encode) {
                        // php >=5.2.3 - go native
                        return "mb_convert_encoding(htmlspecialchars({$input}, ENT_QUOTES, {$char_set}, {$double_encode}), 'HTML-ENTITIES', {$char_set})";
                    } elseif ($double_encode) {
                        // php <5.2.3 - only handle double encoding
                        return "mb_convert_encoding(htmlspecialchars({$input}, ENT_QUOTES, {$char_set}), 'HTML-ENTITIES', {$char_set})";
                    } else {
                        // fall back to modifier.escape.php
                    }
                }

                // no MBString fallback
                if ($_double_encode) {
                    // php >=5.2.3 - go native
                    return "htmlentities({$input}, ENT_QUOTES, {$char_set}, {$double_encode})";
                } elseif ($double_encode) {
                    // php <5.2.3 - only handle double encoding
                    return "htmlentities({$input}, ENT_QUOTES, {$char_set})";
                } else {
                    // fall back to modifier.escape.php
                }
                break;
            case 'url':
                return "rawurlencode({$input})";

            case 'urlpathinfo':
                return "str_replace('%2F', '/', rawurlencode({$input}))";

            case 'quotes':
                // escape unescaped single quotes
                return 'preg_replace("%(?<!\\\\\\\\)\'%", "\\\'",' . $input . ')';

            case 'javascript':
                // escape quotes and backslashes, newlines, etc.
                return 'strtr(' . $input . ', array("\\\\" => "\\\\\\\\", "\'" => "\\\\\'", "\"" => "\\\\\"", "\\r" => "\\\\r", "\\n" => "\\\n", "</" => "<\/" ))';
        }
    }

    // could not optimize |escape call, so fallback to regular plugin
    if ($compiler->tag_nocache | $compiler->nocache) {
        $compiler->required_plugins['nocache']['escape']['modifier']['file'] = Smarty::$_SMARTY_PLUGINS_DIR . 'modifier.escape.php';
        $compiler->required_plugins['nocache']['escape']['modifier']['function'] = 'smarty_modifier_escape';
    } else {
        $compiler->required_plugins['compiled']['escape']['modifier']['file'] = Smarty::$_SMARTY_PLUGINS_DIR . 'modifier.escape.php';
        $compiler->required_plugins['compiled']['escape']['modifier']['function'] = 'smarty_modifier_escape';
    }

    return "smarty_modifier_escape(\$this->smarty, {$input}, {$esc_type}, {$char_set}, {$double_encode})";
}
