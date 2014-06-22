<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Extension
 * @author  Uwe Tews
 */

/**
 * Class for setDefaultModifiers method
 *
 * @package Smarty\Extension
 */
class Smarty_Method_SetDefaultModifiers
{
    /**
     *  Smarty object
     *
     * @var Smarty
     */
    public $smarty;

    /**
     *  Constructor
     *
     * @param Smarty $smarty Smarty object
     */
    public function __construct(Smarty $smarty)
    {
        $smarty = $smarty;
    }

    /**
     * Set default modifiers
     *
     * @api
     *
     * @param  array|string $modifiers modifier or list of modifiers to set
     *
     * @return Smarty       current Smarty instance for chaining
     */
    public function setDefaultModifiers($modifiers)
    {
        $smarty->_defaultModifier = (array) $modifiers;

        return $smarty;
    }
}
