<?php
/**
 * Smarty Compiler Template Node Body
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Body Token Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Parser\Source\Language\Smarty\Node;

use Smarty\Node;
use Smarty\Compiler\Format;
use Smarty\Compiler\Code;

/**
 * Class Body
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node
 */
class Body extends Node
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'Body';

    /**
     * Body nodes array
     *
     * @var array
     */
    public $subtreeNodes = array();

    /**
     * Flag that node does not need an external compiler module
     *
     * @var bool
     */
    public $hasLocalCompiler = true;

    /**
     * Add node(s) to subtree of current node
     *
     * @param array|Node $nodes
     *
     * @return Node  current node
     */
    public function addSubTree($nodes, $name = null, $multiple = false)
    {
        if (is_array($nodes)) {
            $this->subtreeNodes = array_merge($this->subtreeNodes, $nodes);
        } else {
            $this->subtreeNodes[] = $nodes;
        }
        return $this;
    }

    public function getCountSubTree() {
        return count($this->subtreeNodes);
    }

    /**
     * Compile body into target node
     * No Compiler class needed for this node
     *
     * @param Node $targetNode
     * @param bool $delete
     */
    public function compile(Code $codeTargetObj = null, $delete = true)
    {
        if (!isset($codeTargetObj) && !isset($this->codeObj)) {
            $this->codeObj = new Format($this);
        }
        $codeTargetObj = isset($codeTargetObj) ? $codeTargetObj : $this->codeObj;

        $this->parser->compiler->compileNodeArray($this->subtreeNodes, $codeTargetObj, $delete);
        return $codeTargetObj;
    }
}