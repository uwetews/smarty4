<?php
/**
 * Smarty Config Variable Scope
 * This file contains the Class for a variable scope
 *
 * @package Template
 * @author  Uwe Tews
 */

/**
 * class for a variable scope
 * This class holds all assigned variables
 * The special property ___attributes is used to store control information

 */
class Smarty_Config_Scope
{

    /**
     * constructor
     */
    public function __construct()
    {
    }

    /**
     * magic __get function called at access of unknown variable
     *
     * @param  string $varname name of variable
     *
     * @return mixed  Entry object | null
     */
    public function __get($varname)
    {
        return $this->$varname = Smarty_Template::$call_stack[0]->tpl_obj->_getVariable($varname, Smarty_Template::$call_stack[0]->parent);
    }
    /**
     * public function __destruct()
     * {
     * }
     */
}
