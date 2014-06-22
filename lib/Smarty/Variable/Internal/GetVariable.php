<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */

/**
 * Class for static getVariable method
 *
 * @package Smarty\Variable
 */
class Smarty_Variable_Internal_GetVariable
{
    /**
     * gets the object of a template variable
     *
     * @internal
     *
     * @param Smarty | Smarty_Template_Class | Smarty_Variable_Data $object          master object
     * @param  string                                               $varname         the name of the Smarty variable
     * @param  object                                               $_ptr            optional pointer to data object
     * @param  boolean                                              $search_parents  search also in parent data
     * @param  boolean                                              $error_enable    enable error handling
     * @param  boolean                                              $disable_default if true disable default handler
     *
     * @return mixed   Smarty_variable object|property of variable
     */
    public function _getVariable($object, $varname, $_ptr = null, $search_parents = true, $error_enable = true, $disable_default = false)
    {
        $smarty = isset($object->smarty) ? $object->smarty : $object;
        if ($_ptr === null) {
            $_ptr = $smarty;
        }
        while ($_ptr !== null) {
            if (isset($_ptr->_tpl_vars->$varname)) {
                // found it, return it
                return $_ptr->_tpl_vars->$varname;
            }
            // not found, try at parent
            if ($search_parents && isset($_ptr->parent)) {
                $_ptr = $_ptr->parent;
            } else {
                $_ptr = null;
            }
        }

        // try global variable
        if (isset(Smarty::$_global_tpl_vars->$varname)) {
            // found it, return it
            return Smarty::$_global_tpl_vars->$varname;
        }

        if ($disable_default) {
            return null;
        } else {
            // try default variable
            return $smarty->_getDefaultVariable($varname, $error_enable);
        }
    }
}