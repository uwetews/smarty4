<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for registerDefaultConfigHandler method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_RegisterDefaultConfigHandler
{
    /**
     * Registers a default config handler
     *
     * @api
     *
     * @param Smarty    $smarty   smarty object
     * @param  callable $callback class/method name
     *
     * @return Smarty
     * @throws Smarty_Exception if $callback is not callable
     */
    public function registerDefaultConfigHandler(Smarty $smarty, $callback)
    {
        if (is_callable($callback)) {
            $smarty->default_config_handler_func = $callback;
        } else {
            throw new Smarty_Exception("registerDefaultConfigHandler(): Invalid callback");
        }

        return $smarty;
    }
}
