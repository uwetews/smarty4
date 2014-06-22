<?php

/**
 * Smarty Variable Callback
 * This file contains the class of a callback handler for an undefined template variable.
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */

/**
 * class for the Smarty variable callback object
 * This class defines the Smarty variable callback object
 *
 * @package Smarty\Variable
 */
class Smarty_Variable_Callback
{

    /**
     * if true any output of this variable will be not cached
     *
     * @var boolean
     */
    public $nocache = false;

    /**
     * callback to be called at undefined variable
     *
     * @var callback
     */
    public $callback = null;

    /**
     * create Smarty variable object
     *
     * @param string   $varname  name this variable
     * @param callback $callback callback
     * @param boolean  $nocache  if true any output of this variable will be not cached
     *
     * @throws Smarty_Exception
     */
    public function __construct($varname, $callback, $nocache = false)
    {
        if (!is_callable($callback)) {
            throw new Smarty_Exception("assignCallback(): Hook for variable \"{$varname}\" not callable");
        } else {
            if (is_object($callback)) {
                $callback = array($callback, '__invoke');
            }
            $this->callback = $callback;
        }
        $this->nocache = $nocache;
    }

    /**
     * <<magic>> getter will call the callback to obtain the variable value
     *
     * @param string $property name of property
     *
     * @return mixed variable value
     */
    public function __get($property)
    {
        if ($property == 'value') {
            return $this->value = $this->callback($this->varname);
        } else {
            return null;
        }
    }

    /**
     * <<magic>> setter will save the value for later use
     *
     * @param string $property name of property
     * @param mixed  $value    to save
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
    }
}
