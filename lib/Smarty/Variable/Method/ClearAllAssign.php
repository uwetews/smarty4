<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */

/**
 * Class for static clearAssign method
 *
 * @package Smarty\Variable
 */
class Smarty_Variable_Method_ClearAllAssign
{
    /**
     * clear all the assigned template variables.
     *
     * @api
     *
     * @param Smarty | Smarty_Template_Class | Smarty_Variable_Data $object master object
     *
     * @return Smarty_Variable_Methods current Smarty_Variable_Methods (or Smarty) instance for chaining
     */
    public function clearAllAssign($object)
    {
        $object->_tpl_vars = new Scope();
        return $object;
    }
}