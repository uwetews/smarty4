<?php

/**
 * Smarty Extension
 * Smarty class methods
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */

/**
 * Class for static clearConfig method
 *
 * @package Smarty\Variable
 */
class Smarty_Variable_Method_ClearConfig
{
    /**
     * Deassigns a single or all config variables
     *
     * @api
     *
     * @param Smarty | Smarty_Template_Class | Smarty_Variable_Data $object  master object
     * @param  string                                               $varname variable name or null
     *
     * @return Smarty_Variable_Methods current Smarty_Variable_Methods (or Smarty) instance for chaining
     */
    public function clearConfig($object, $varname = null)
    {
        if (isset($varname)) {
            unset($object->_tpl_vars->{'___config_var_' . $varname});
        } else {
            foreach ($object->_tpl_vars as $key => $var) {
                if (strpos($key, '___config_var_') === 0) {
                    unset($object->_tpl_vars->$key);
                }
            }
        }

        return $object;
    }
}