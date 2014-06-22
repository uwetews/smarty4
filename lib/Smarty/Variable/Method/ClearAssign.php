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
class Smarty_Variable_Method_ClearAssign
{
    /**
     * clear the given assigned template variable.
     *
     * @api
     *
     * @param Smarty | Smarty_Template_Class | Smarty_Variable_Data $object  master object
     * @param  string|array                                         $tpl_var the template variable(s) to clear
     *
     * @return Smarty_Variable_Methods current Smarty_Variable_Methods (or Smarty) instance for chaining
     */
    public function clearAssign($object, $tpl_var)
    {
        if (is_array($tpl_var)) {
            foreach ($tpl_var as $curr_var) {
                unset($object->_tpl_vars->$curr_var);
            }
        } else {
            unset($object->_tpl_vars->$tpl_var);
        }

        return $object;
    }
}