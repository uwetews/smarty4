<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */

/**
 * Class for assignCallback method
 *
 * @package Smarty\Variable
 */
class Smarty_Variable_Method_AssignCallback
{
    /**
     * assigns a variable hook
     *
     * @api
     *
     * @param Smarty | Smarty_Template_Class | Smarty_Variable_Data $object   master object
     * @param  string                                               $varname  the variable name
     * @param  callback                                             $callback PHP callback to get variable value
     * @param  boolean                                              $nocache  if true any output of this variable will be not cached
     * @param int                                                   $scope_type
     *
     * @throws Smarty_Exception
     * @return Smarty_Variable_Methods current Smarty_Variable_Methods (or Smarty) instance for chaining
     */
    public function assignCallback($object, $varname, $callback, $nocache = false, $scope_type = Smarty::SCOPE_LOCAL)
    {
        if ($varname != '') {
            if (!is_callable($callback)) {
                throw new Smarty_Exception("assignHook(): Hook for variable \"{$varname}\" not callable");
            } else {
                if (is_object($callback)) {
                    $callback = array($callback, '__invoke');
                }
                if ($object->_usage == Smarty::IS_TEMPLATE || $scope_type != Smarty::SCOPE_LOCAL) {
                    $object->_assignInScope($varname, new Entry_Callback($varname, $callback, $nocache), $scope_type);
                } else {
                    $object->_tpl_vars->$varname = new Entry_Callback($varname, $callback, $nocache);
                }
            }
        }
        return $object;
    }
}
