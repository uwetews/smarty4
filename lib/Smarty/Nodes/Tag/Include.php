<?php
/**
 * Smarty Compiler Template Node Node Tag Include
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Include Tag Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Tag;

use Smarty\Nodes\Node;

/**
 * Class Include_
 *
 * @package Smarty\Nodes\Tag
 */
class Include_ extends Tag
{
    /**
     * Tag name
     *
     * @var string
     */
    public $tag = 'include';

    /**
     * Node compiler class name
     *
     * @var string
     */
    public $compiler_class = 'Tag_Include';

    /**
     * Attribute definition: Overwrites Tag.
     *
     * @var array
     */
    public $required_attributes = array('file');

    /**
     * Attribute definition: Overwrites Tag.
     *
     * @var array
     */
    public $shorttag_order = array('file');

    /**
     * Attribute definition: Overwrites Tag.
     *
     * @var array
     */
    public $option_flags = array('nocache', 'inline', 'caching');

    /**
     * Attribute definition: Overwrites Tag.
     *
     * @var array
     */
    public $optional_attributes = array('_any');

}