<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for unegisterDefaultConfigVariableHandler method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_UnregisterDefaultConfigVariableHandler
{
    /**
     * Registers a default config variable handler
     *
     * @api
     *
     * @param Smarty $smarty smarty object
     *
     * @return Smarty
     */
    public function unregisterDefaultConfigVariableHandler(Smarty $smarty)
    {
        $smarty->default_config_variable_handler_func = null;

        return $smarty;
    }
}
