<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for unregisterDefaultPluginHandler method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_UnregisterDefaultPluginHandler
{
    /**
     * Unregisters a default plugin handler
     *
     * @api
     *
     * @param Smarty $smarty smarty object
     *
     * @return Smarty
     */
    public function unregisterDefaultPluginHandler(Smarty $smarty)
    {
        $smarty->default_plugin_handler_func = null;

        return $smarty;
    }
}
