<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */

/**
 * Class for static getConfigVars method
 *
 * @package Smarty\Variable
 */
class Smarty_Variable_Method_GetConfigVars
{
    /**
     * Returns a single or all config variables
     *
     * @api
     *
     * @param Smarty | Smarty_Template_Class | Smarty_Variable_Data $object         master object
     * @param  string                                               $varname        variable name or null
     * @param  boolean                                              $search_parents include parent templates?
     *
     * @return string  variable value or or array of variables
     */
    public function getConfigVars($object, $varname = null, $search_parents = true)
    {
        $_ptr = $object;
        if (isset($varname)) {
            $result = $object->_getVariable('___config_var_' . $varname, $_ptr, $search_parents, false);

            return $result;
        } else {
            $_result = array();
            while ($_ptr !== null) {
                foreach ($_ptr->_tpl_vars AS $varname => $data) {
                    $real_varname = substr($varname, 14);
                    if (strpos($varname, '___config_var_') === 0 && !isset($_result[$real_varname])) {
                        $_result[$real_varname] = $data;
                    }
                }
                // not found, try at parent
                if ($search_parents) {
                    $_ptr = $_ptr->parent;
                } else {
                    $_ptr = null;
                }
            }

            return $_result;
        }
    }
}