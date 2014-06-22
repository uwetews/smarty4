<?php
/**
 * Smarty Compiler Template Node Tag Function
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Function Tag Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Tag;

use Smarty\Nodes\Node;

/**
 * Class Function_
 *
 * @package Smarty\Nodes\Tag
 */
class Function_ extends BlockTag
{
    /**
     * Tag name
     *
     * @var string
     */
    public $tag = 'function';

    /**
     * Base tag name
     *
     * @var string
     */
    public $base_tag = 'function';

    /**
     * Node compiler class name
     *
     * @var string
     */
    public $compiler_class = 'Tag_Function';

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

    /**
     * closeTag method {/function}
     * Add template function to template node
     *
     * @return null
     */
    public function closeTag()
    {
        $this->parser->templateNode->addTemplateFunction($this);
        return null;
    }
}