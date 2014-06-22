<?php
/**
 * Smarty Compiler Template Node Node Tag Assign
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Assign Tag Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Tag;

use Smarty\Nodes\Node;

/**
 * Class Assign
 *
 * @package Smarty\Nodes\Tag
 */
class Assign extends Node\Tag
{
    /**
     * Node compiler class name
     *
     * @var string
     */
    public $compiler_class = 'Tag_Assign';

    /**
     * Attribute definition: Overwrites Tag.
     *
     * @var array
     */
    public $required_attributes = array('var', 'value');

    /**
     * Attribute definition: Overwrites Tag.
     *
     * @var array
     */
    public $shorttag_order = array('var', 'value');

    /**
     * Attribute definition: Overwrites Tag.
     *
     * @var array
     */
    public $option_flags = array('nocache', 'cachevalue');

    /**
     * Attribute definition: Overwrites Tag.
     *
     * @var array
     */
    public $optional_attributes = array('scope');

}