<?php
/**
 * Smarty Variable Scope
 * This file contains the Class for a variable scope
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */
namespace Smarty\Variable;
/**
 * class for a variable scope
 * This class holds all assigned variables
 *
 * @package Smarty\Variable
 */
class Scope
{
    /**
     * magic __get function called at access of unknown or global variable
     *
     * @param  string $varname name of variable
     *
     * @return mixed  Smarty_Variable object | null
     */
    public function __get($varname)
    {
        if (class_exists('Smarty_Template', false) && Smarty_Template::$call_stack[0][0]->smarty) {
            //get variable from default handler
            $var = Smarty_Template::$call_stack[0][0]->smarty->_getDefaultVariable($varname);
            if ($var != null) {
                //assign value and bubble up if necessary
                Smarty_Template::$call_stack[0][0]->_assignInScope($varname, $var);
            }
            return $var;
        } else {
            return null;
        }
    }
}
