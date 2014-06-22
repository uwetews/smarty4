<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for unregisterDefaultConfigHandler method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_UnregisterDefaultConfigHandler
{
    /**
     * Unregisters a default config handler
     *
     * @api
     *
     * @param Smarty $smarty smarty object
     *
     * @return Smarty
     */
    public function unregisterDefaultConfigHandler(Smarty $smarty)
    {
        $smarty->default_config_handler_func = null;

        return $smarty;
    }
}
