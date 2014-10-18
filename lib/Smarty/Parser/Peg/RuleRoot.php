<?php
namespace Smarty\Parser\Peg;

use Smarty\Exception\Magic;

/**
 * Class RuleRoot;
 *
 * @package Smarty
 */
class RuleRoot //extends Magic
{
    /**
     * Parser object
     *
     * @var Parser
     */
    public $parser = null;

    /**
     * Flag if a valid compiled Peg Parser class
     *
     * @var bool
     */
    public $valid = false;

    /**
     * Array of match method names for rules of this Peg Parser
     *
     * @var null|array
     */
    public $ruleMethods = null;

    /**
     * Array of match method names for rules of this Peg Parser
     *
     * @var null|array
     */
    public $ruleArray = null;

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array();

    /**
     * Constructor
     *
     * @param Parser $parser parser object
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Get attribute of node
     *
     * @param string $nodeName
     *
     * @return array
     */
    public function getAttributes($nodeName)
    {
        return isset($this->nodeAttributes[$nodeName]) ? $this->nodeAttributes[$nodeName] : array();
    }
}
