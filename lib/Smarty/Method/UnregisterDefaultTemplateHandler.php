<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for unregisterDefaultTemplateHandler method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_UnregisterDefaultTemplateHandler
{
    /**
     * Registers a default template handler
     *
     * @api
     *
     * @param Smarty $smarty smarty object
     *
     * @return Smarty
     * @throws Smarty_Exception if $callback is not callable
     */
    public function unregisterDefaultTemplateHandler(Smarty $smarty)
    {
        $smarty->default_template_handler_func = null;

        return $smarty;
    }
}
