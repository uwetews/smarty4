<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for getDebugTemplate method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_GetDebugTemplate
{
    /**
     * return name of debugging template
     *
     * @api
     *
     * @param Smarty $smarty smarty object
     *
     * @return string
     */
    public function getDebugTemplate(Smarty $smarty)
    {
        return $smarty->debugTpl;
    }
}
