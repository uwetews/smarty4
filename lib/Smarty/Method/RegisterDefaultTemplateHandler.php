<?php
/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for registerDefaultTemplateHandler method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_RegisterDefaultTemplateHandler
{
    /**
     * Registers a default template handler
     *
     * @api
     *
     * @param Smarty    $smarty   smarty object
     * @param  callable $callback class/method name
     *
     * @return Smarty
     * @throws Smarty_Exception if $callback is not callable
     */
    public function registerDefaultTemplateHandler(Smarty $smarty, $callback)
    {
        if (is_callable($callback)) {
            $smarty->default_template_handler_func = $callback;
        } else {
            throw new Smarty_Exception("registerDefaultTemplateHandler(): Invalid callback");
        }
        return $smarty;
    }
}
