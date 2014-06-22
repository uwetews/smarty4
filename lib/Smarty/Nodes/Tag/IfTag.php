<?php
/**
 * Smarty Compiler Template Node Tag If
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * If Tag Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Tag;

use Smarty\Nodes\BlockTag;

class IfTag extends BlockTag
{
    /**
     * Tag name
     *
     * @var string
     */
    public $tag = null;

    /**
     * Base tag name
     *
     * @var string
     */
    public $base_tag = 'if';

    /**
     * Node compiler class name
     *
     * @var string
     */
    public $compiler_class = 'Tag_If';

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