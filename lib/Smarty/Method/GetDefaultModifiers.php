<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for getDefaultModifiers method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_GetDefaultModifiers
{
    /**
     * Get default modifiers
     *
     * @api
     *
     * @param Smarty $smarty smarty object
     *
     * @return array list of default modifiers
     */
    public function getDefaultModifiers(Smarty $smarty)
    {
        return $smarty->_defaultModifier;
    }
}
