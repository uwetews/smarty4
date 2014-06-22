<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for loadFilter method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_LoadFilter
{
    /**
     * load a filter of specified type and name
     *
     * @api
     *
     * @param Smarty  $smarty smarty object
     * @param  string $type   filter type
     * @param  string $name   filter name
     *
     * @throws Smarty_Exception
     * @return bool
     */
    public function loadFilter(Smarty $smarty, $type, $name)
    {
        if (!in_array($type, array('pre', 'post', 'output', 'variable'))) {
            throw new Smarty_Exception("loadFilter(): Invalid filter type \"{$type}\"");
        }
        $_plugin = "smarty_{$type}filter_{$name}";
        $_filter_name = $_plugin;
        if ($smarty->_loadPlugin($_plugin)) {
            if (class_exists($_plugin, false)) {
                $_plugin = array($_plugin, 'execute');
            }
            if (is_callable($_plugin)) {
                $smarty->_registered['filter'][$type][$name] = $_plugin;
                return true;
            }
        }
        throw new Smarty_Exception("loadFilter(): {$type}filter \"{$name}\" not callable");
    }
}
