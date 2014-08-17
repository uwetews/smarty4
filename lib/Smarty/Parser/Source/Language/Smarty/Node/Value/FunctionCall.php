<?php
namespace Smarty\Parser\Source\Language\Smarty\Node\Value;

use Smarty\Node;
use Smarty\Parser;
use Smarty\Compiler\Code;

/**
 * Class FunctionCall
 *
 * @package Smarty\Parser\Source\Language\Smarty\Node\Value
 */
class FunctionCall extends Node
{
    /**
     * Node name
     *
     * @var string
     */
    public $name = 'FunctionCall';
    /**
     * Rule name
     *
     * @var string
     */
    public $ruleName = 'FunctionCall';
    /**
     * Parser node name (defaults to node name)
     *
     * @var string
     */
    public $parserNode = 'Expression';

    /**
     * Compiler class name (defaults to node name)
     *
     * @var string
     */
    public $compilerClass = 'FunctionCall';

    /**
     * Function name node
     *
     * @var Node
     */
    public $nameNode = null;

    /**
     * Array of parameter nodes
     *
     * @var array of parameter nodes
     */
    public $parameterNodes = array();

    /**
     * Set function name node
     *
     * @param Node $nameNode
     */
    public function setNameNode(Node $nameNode)
    {
        $this->nameNode = $nameNode;
    }

    /**
     * Get function name node
     *
     * @return Node
     */
    public function getNameNode()
    {
        return $this->nameNode;
    }

    /**
     * Set array of parameter nodes
     *
     * @param array $parameterNodes function parameter
     */
    public function setParameterNodes($parameterNodes)
    {
        $this->parameterNodes = $parameterNodes;
    }

    /**
     * Get function parameter nodes
     *
     * @return array
     */
    public function getParameterNodes()
    {
        return $this->parameterNodes;
    }
}