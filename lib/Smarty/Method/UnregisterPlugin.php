<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for unregisterPlugin method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_UnregisterPlugin
{
    /**
     * Unregister Plugin
     *
     * @api
     *
     * @param Smarty  $smarty smarty object
     * @param  string $type   of plugin
     * @param  string $tag    name of plugin
     *
     * @return Smarty
     */
    public function unregisterPlugin(Smarty $smarty, $type, $tag)
    {
        if (isset($smarty->_registered['plugin'][$type][$tag])) {
            unset($smarty->_registered['plugin'][$type][$tag]);
        }

        return $smarty;
    }
}
