<?php
/**
 * Smarty Compiler Template Node Node Tag Delim
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Delim Tag Node
 * Node for processing {ldelim} and {rdelim} tags
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Tag;

use Smarty\Nodes\Node;

/**
 * Class Delim
 *
 * @package Smarty\Nodes\Tag
 */
class Delim extends Tag
{
    /**
     * Array of names of valid option flags
     *
     * @var array
     */
    public $option_flags = array();

    /**
     * Compile delimiter and move compiled code into target node if specified
     *
     * @param \Node|null|\Smarty\Source\Node $target optional target node for compiled code
     * @param bool                           $delete
     *
     * @return Node  current node
     */
    public function compileNode(Node $target = null, $delete = true)
    {
        if ($target == null) {
            $target = $this;
        }
        $target->lineNo($this->sourceLineNo);
        if (isset($this->compiler->output_var)) {
            $target->code("\${$this->compiler->output_var} .= ");
        } else {
            $target->code('echo ');
        }
        if ($this->tag == 'ldelim') {
            $target->raw("\$this->smarty->left_delimiter;\n");
        } else {
            $target->raw("\$this->smarty->rigth_delimiter;\n");
        }
        return $this;
    }
}