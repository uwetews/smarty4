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
namespace Smarty\Compiler\Source\Shared\Node;

use Smarty\Node;

/**
 * Class TagIf
 *
 * @package Smarty\Compiler\Source\Shared\Node
 */
class TagIf extends Node
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'TagIf';

    /**
     * If condition node
     *
     * @var Node
     */
    public $conditionNode = null;

    /**
     * If body node
     *
     * @var Node
     */
    public $bodyNode = null;

    /**
     * Optional elseif condition and body node pairs
     *
     * @var array
     */
    public $elseifNodes = array();

    /**
     * Optional else body node
     *
     * @var Node
     */
    public $elseBodyNode = null;

    /**
     * Set if nodes
     *
     * @param array $nodes array of condition and body node
     */
    public function setIf($nodes)
    {
        $this->conditionNode = $nodes[0];
        $this->bodyNode = $nodes[1];
    }

    /**
     * Set elseif nodes
     *
     * @param array $nodes array of condition and body node
     */
    public function setElseif($nodes)
    {
        $this->elseifNodes = array_merge($this->elseifNodes, (array) $nodes);
    }

    /**
     * Set else body node
     *
     * @param Node $node
     */
    public function setElse(Node $body)
    {
        $this->elseBodyNode = $body;
    }
}