<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for registerDefaultConfigVariableHandler method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_RegisterDefaultConfigVariableHandler
{
    /**
     * Registers a default config variable handler
     *
     * @api
     *
     * @param Smarty    $smarty   smarty object
     * @param  callable $callback class/method name
     *
     * @return Smarty
     * @throws Smarty_Exception if $callback is not callable
     */
    public function registerDefaultConfigVariableHandler(Smarty $smarty, $callback)
    {
        if (is_callable($callback)) {
            $smarty->default_config_variable_handler_func = $callback;
        } else {
            throw new Smarty_Exception("registerDefaultConfigVariableHandler(): Invalid callback");
        }

        return $smarty;
    }
}
