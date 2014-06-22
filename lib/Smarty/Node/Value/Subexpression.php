<?php
/**
 * Smarty Compiler Template Node Expression Value Subexpression
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Subexpression Value Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Node\Value;

use Smarty\Node;
use Smarty\Parser;
use Smarty\Compiler\Code;
/**
 * Class Subexpression
 *
 * @package Smarty\Nodes\Value
 */
class Subexpression extends Node
{

    public $hasLocalCompiler = true;
    /**
     * Constructor
     *
     * @param Smarty_Compiler_Parser         $parser parser object
     * @param string                         $type   dummy parameter
     * @param \Node|null|\Smarty\Source\Node $node   optional
     */
    public function __construct(Parser $parser, $node = null)
    {
        parent::__construct($parser);
        if ($node !== null) {
            $this->internalNodeTrees = array_merge($this->internalNodeTrees, (array) $node);
        }
    }

    /**
     * Compile sub expression and move compiled code into target node if specified
     *
     * @param Node $target optional target node for compiled code
     * @param bool $delete flag if compiled nodes shall be deleted
     *
     * @return Node  current node
     */
    public function compile(Code $codeTargetObj, $delete = true)
    {
        if (!empty($this->internalNodeTrees)) {
            $codeTargetObj->raw('(')
                ->compileNodeArray($this->internalNodeTrees, $codeTargetObj, $delete)
                ->raw(')');
        }
        return $this;
    }
}