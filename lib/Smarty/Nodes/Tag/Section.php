<?php
/**
 * Smarty Compiler Template Node Tag Section
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Section Tag Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Tag;

use Smarty\Nodes\Node;

/**
 * Class Section
 *
 * @package Smarty\Nodes\Tag
 */
class Section extends BlockTag
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
    public $base_tag = 'section';

    /**
     * Node compiler class name
     *
     * @var string
     */
    public $compiler_class = 'Tag_Section';

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $required_attributes = array('name', 'loop');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $shorttag_order = array('name', 'loop');

    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see $tpl_obj
     */
    public $optional_attributes = array('start', 'step', 'max', 'show');

    /**
     * Constructor
     *
     * @param Smarty_Compiler_Parser         $parser     parser object
     * @param string                         $type       dummy parameter
     * @param \Node|null|\Smarty\Source\Node $parentNode optional parent node
     */
    public function __construct(Smarty_Compiler_Parser $parser, $type, Node $parentNode = null)
    {
        parent::__construct($parser, $type, $parentNode);

        // for {section} we are done
        if ($this->tag == 'section') {
            return false;
        }
        // for {sectionelse} remove attributes and options
        $this->option_flags = $this->required_attributes = $this->shorttag_order = array();
        $n = $this->parser->processCloseTag($this->base_tag);
        $this->parentNode = $n;
        $this->parser->currentNode->addSubTree($n);
    }
}