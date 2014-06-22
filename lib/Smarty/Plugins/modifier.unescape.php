<?php

/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty unescape modifier plugin
 * NOTE: This plugin is called only when smarty_modifiercompiler_escape() is not able to produce inline code
 * Type:     modifier<br>
 * Name:     unescape<br>
 * Purpose:  unescape html entities
 *
 * @link    http://www.smarty.net/docs/en/language.modifier.unescape.tpl
 *          regex_replace (Smarty online manual)
 * @author  Uwe Tews
 * @author  Rodney Rehm
 *
 * @param Smarty $tpl_obj  template object
 * @param string $input    output string
 * @param string $esc_type escape type
 * @param string $char_set character set
 *
 * @throws Smarty_Exception_Runtime
 * @return string with compiled code
 */
function smarty_modifier_unescape(Smarty $tpl_obj, $input, $esc_type = 'html', $char_set = null)
{
    if (!$char_set) {
        $char_set = SMARTY_RESOURCE_CHAR_SET;
    }
    switch ($esc_type) {
        case 'entity':
            return mb_convert_encoding($input, $char_set, 'HTML-ENTITIES');

        case 'htmlall':
            if (SMARTY_MBSTRING /* ^phpunit */ && empty($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']) /* phpunit$ */) {
                return mb_convert_encoding($input, $char_set, 'HTML-ENTITIES');
            }

            return html_entity_decode($input, ENT_QUOTES, $char_set);

        case 'html':
            return htmlspecialchars_decode($input, ENT_QUOTES);

        default:
            throw new Smarty_Exception_Runtime("Modifier unescape: Illegal unescape type '{$esc_type}'", $tpl_obj);
    }
}
