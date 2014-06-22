<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */

/**
 * Class for getTemplateVars method
 *
 * @package Smarty\Variable
 */
class Smarty_Variable_Method_GetTemplateVars
{
    /**
     * Returns a single or all template variables
     *
     * @api
     *
     * @param Smarty | Smarty_Template_Class | Smarty_Variable_Data $object         master object
     * @param  string                                               $varname        variable name or null
     * @param  string                                               $_ptr           optional pointer to data object
     * @param  boolean                                              $search_parents include parent templates?
     *
     * @return string  variable value or or array of variables
     */
    public function getTemplateVars($object, $varname = null, $_ptr = null, $search_parents = true)
    {
        $smarty = isset($object->smarty) ? $object->smarty : $object;
        if (isset($varname)) {
            $result = $smarty->_getVariable($varname, $_ptr, $search_parents, false);
            if ($result === null) {
                return false;
            } else {
                return $result->value;
            }
        } else {
            $_result = array();
            if ($_ptr === null) {
                $_ptr = $this->smarty;
            }
            while ($_ptr !== null) {
                foreach ($_ptr->_tpl_vars AS $varname => $data) {
                    if (strpos($varname, '___') !== 0 && !isset($_result[$varname])) {
                        $_result[$varname] = $data->value;
                    }
                }
                // not found, try at parent
                if ($search_parents) {
                    $_ptr = $_ptr->parent;
                } else {
                    $_ptr = null;
                }
            }
            if ($search_parents && isset(Smarty::$_global_tpl_vars)) {
                foreach (Smarty::$_global_tpl_vars AS $varname => $data) {
                    if (strpos($varname, '___') !== 0 && !isset($_result[$varname])) {
                        $_result[$varname] = $data->value;
                    }
                }
            }

            return $_result;
        }
    }
}