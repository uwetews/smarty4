<?php

/**
 * Smarty Resource Source Eval Plugin
 *
 * @package Smarty\Resource\Source
 * @author  Uwe Tews
 * @author  Rodney Rehm
 */

/**
 * Smarty Resource Source Eval Plugin
 * Implements the strings as resource for Smarty template
 * {@internal unlike string-resources the compiled state of eval-resources is NOT saved for subsequent access}}
 *
 * @package Smarty\Resource\Source
 */
class Smarty_Resource_Source_Eval extends Smarty_Resource_Source_String
{
    /*
     * set recompiled flag
     * @var boolean
     */
    public $recompiled = true;
}
