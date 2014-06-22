<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for registerDefaultVariableHandler method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_registerDefaultVariableHandler
{
    /**
     * Registers a default variable handler
     *
     * @api
     *
     * @param Smarty    $smarty   smarty object
     * @param  callable $callback class/method name
     *
     * @return Smarty
     * @throws Smarty_Exception if $callback is not callable
     */
    public function registerDefaultVariableHandler(Smarty $smarty, $callback)
    {
        if (is_callable($callback)) {
            $smarty->default_variable_handler_func = $callback;
        } else {
            throw new Smarty_Exception("registerDefaultVariableHandler(): Invalid callback");
        }

        return $smarty;
    }
}
