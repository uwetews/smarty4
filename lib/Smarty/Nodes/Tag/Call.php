<?php
/**
 * Smarty Compiler Template Node Node Tag Call
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Call Tag Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Tag;

use Smarty\Nodes\Node;

/**
 * Class Call
 *
 * @package Smarty\Nodes\Tag
 */
class Call extends Tag
{
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $required_attributes = array('name');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $shorttag_order = array('name');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('_any');
}