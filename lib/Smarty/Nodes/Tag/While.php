<?php
/**
 * Smarty Compiler Template Node Tag While
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * While Tag Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Tag;

use Smarty\Nodes\Node;

/**
 * Class While_
 *
 * @package Smarty\Nodes\Tag
 */
class While_ extends BlockTag
{
    /**
     * Tag name
     *
     * @var string
     */
    public $tag = 'while';

    /**
     * Base tag name
     *
     * @var string
     */
    public $base_tag = 'while';

    /**
     * Node compiler class name
     *
     * @var string
     */
    public $compiler_class = 'Tag_While';

    /**
     * Attribute definition: Overwrites Tag.
     *
     * @var array
     */
    public $required_attributes = array('condition');

    /**
     * Attribute definition: Overwrites Tag.
     *
     * @var array
     */
    public $shorttag_order = array('condition');
}

