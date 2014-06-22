<?php

/**
 * Smarty Variable
 * This file contains the class of a template variable.
 *
 * @package Smarty\Variable
 * @author  Uwe Tews
 */
namespace Smarty\Variable;
/**
 * class for the Smarty variable object
 * This class defines the Smarty variable object
 *
 * @package Smarty\Variable
 */
class Entry
{

    /**
     * variable value
     *
     * @var mixed
     */
    public $value = null;

    /**
     * if true any output of this variable will be not cached
     *
     * @var boolean
     */
    public $nocache = false;

    /**
     * create Smarty variable object
     *
     * @param mixed   $value   the value to assign
     * @param boolean $nocache if true any output of this variable will be not cached
     */
    public function __construct($value = null, $nocache = false)
    {
        $this->value = $value;
        $this->nocache = $nocache;
    }

    /**
     * <<magic>> String conversion
     *
     * @return string
     */
    /**
     * public function __toString()
     * {
     * return (string) $this->value;
     * }
     */
}
