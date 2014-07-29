<?php
/**
 * Smarty Compiler Template Node Expression
 *
 * @package Smarty\Compiler
 * @author  Uwe Tews
 */

/**
 * Expression Node
 *
 * @package Smarty\Compiler
 */
namespace Smarty\Nodes\Value;

use Smarty\Nodes\Node;

/**
 * Class Expression
 *
 * @package Smarty\Nodes\Value
 */
class Expression extends Value
{
    /**
     * Add node to subtree of current node
     *
     * @param array|Node $node
     *
     * @return Node  current node
     */
    public function addSubTree($node)
    {
        if (is_array($node)) {
            foreach ($node as $n) {
                $this->addSubTree($n);
            }
        } else {
            if ($this->nodeType == $node->nodeType) {
                $this->subtreeNodes = array_merge($this->subtreeNodes, (array) $node->subtreeNodes);
            } else {
                $this->subtreeNodes[] = $node;
            }
        }
        return $this;
    }
}