<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for unregisterDefaultVariableHandler method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_UnregisterDefaultVariableHandler
{
    /**
     * Unregisters a default variable handler
     *
     * @api
     *
     * @param Smarty $smarty smarty object
     *
     * @return Smarty
     */
    public function unregisterDefaultVariableHandler(Smarty $smarty)
    {
        $smarty->default_variable_handler_func = null;

        return $smarty;
    }
}
