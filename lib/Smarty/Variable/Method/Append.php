<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */

/**
 * Class for static append method
 *
 * @package Smarty\Variable
 */
class Smarty_Variable_Method_Append
{
    /**
     * appends values to template variables
     *
     * @api
     *
     * @param  Smarty | Smarty_Template_Class | Smarty_Variable_Data $object  master object
     * @param  array|string                                          $tpl_var the template variable name(s)
     * @param  mixed                                                 $value   the value to append
     * @param  boolean                                               $merge   flag if array elements shall be merged
     * @param  boolean                                               $nocache if true any output of this variable will be not cached
     * @param int                                                    $scope_type
     *
     * @return Smarty_Variable_Methods current Smarty_Variable_Methods (or Smarty) instance for chaining
     */
    public function append($object, $tpl_var, $value = null, $merge = false, $nocache = false, $scope_type = Smarty::SCOPE_LOCAL)
    {
        if (!is_array($tpl_var)) {
            if ($tpl_var == '' || !isset($value)) {
                return $object;
            }
            $tpl_var = array($tpl_var => $value);
        }

        foreach ($tpl_var as $varname => $_val) {
            if ($varname != '') {
                if (!isset($object->_tpl_vars->$varname)) {
                    $_var = $object->_getVariable($varname, null, true, false);
                    if ($_var === null) {
                        $_var = new Entry(null, $nocache);
                    } else {
                        $_var = clone $_var;
                    }
                } else {
                    $_var = $object->_tpl_vars->$varname;
                }
                if (!(is_array($_var->value) || $_var->value instanceof ArrayAccess)) {
                    settype($_var->value, 'array');
                }
                if ($merge && is_array($_val)) {
                    foreach ($_val as $_mkey => $_mval) {
                        $_var->value[$_mkey] = $_mval;
                    }
                } else {
                    $_var->value[] = $_val;
                }
            }
            if ($object->_usage == Smarty::IS_TEMPLATE || $scope_type != Smarty::SCOPE_LOCAL) {
                $object->_assignInScope($varname, $_var, $scope_type);
            } else {
                $object->_tpl_vars->$varname = $_var;
            }
        }
        return $object;
    }
}