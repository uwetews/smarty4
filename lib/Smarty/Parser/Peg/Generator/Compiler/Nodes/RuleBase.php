<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Compiler\Format;
use Smarty\Exception\Magic;

/**
 * Class RuleBase
 * Basic rule processing properties and methods
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class RuleBase extends Magic
{
    /**
     * Name of token
     *
     * @var string|null
     */

    public $name = null;

    /**
     * Basic token object
     *
     * @var Token
     */
    public $token = null;

    /**
     * Parent node
     *
     * @var Node
     */
    public $node = null;

    /**
     * Return rule token name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get name of parent node
     *
     * @return string
     */
    public function getNodeName()
    {
        return $this->token->getNodeName();
    }

    /**
     * Set basic token object
     *
     * @param Token $token
     */
    public function setToken(Token $token)
    {
        $this->token = $token;
    }

    /**
     * Set parent node
     *
     * @param Node $node
     */
    public function setNode(Node $node)
    {
        $this->node = $node;
    }

    /**
     * Build rule array
     *
     * @return array
     */
    public function buildRuleArray()
    {
        return array();
    }

    /**
     * Return token rule array
     *
     * @return array
     */
    public function getRuleArray()
    {
        return $this->buildRuleArray();
    }

    /**
     * Compile token rule in rule array format
     *
     * @param Format $target
     */
    public function compileRuleArray(Format $target)
    {
        $target->repr($this->buildRuleArray());
    }

    /**
     * Compile token rule into PHP
     *
     * @param Format $target
     */
    function compile(Format $target)
    {
    }
}

