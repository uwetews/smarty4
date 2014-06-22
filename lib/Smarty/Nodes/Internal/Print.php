<?php
/**
 * Smarty Compiler Template Node Node Tag Internal Print
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Internal Print Tag Node
 *
 * @package Smarty\Compiler
 */
class Print extends Tag
{
    /**
     * Node compiler class name
     *
     * @var string
     */
    public
    $compiler_class = 'Internal_Print';

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public
    $optional_attributes = array('assign');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public
    $option_flags = array('nocache', 'nofilter');
}