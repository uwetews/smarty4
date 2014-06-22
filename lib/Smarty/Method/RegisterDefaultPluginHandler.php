<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for registerDefaultPluginHandler method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_RegisterDefaultPluginHandler
{
    /**
     * Registers a default plugin handler
     *
     * @api
     *
     * @param Smarty    $smarty   smarty object
     * @param  callable $callback class/method name
     *
     * @return Smarty
     * @throws Smarty_Exception if $callback is not callable
     */
    public function registerDefaultPluginHandler(Smarty $smarty, $callback)
    {
        if (is_callable($callback)) {
            $smarty->default_plugin_handler_func = $callback;
        } else {
            throw new Smarty_Exception("registerDefaultPluginHandler(): Invalid callback");
        }

        return $smarty;
    }
}
