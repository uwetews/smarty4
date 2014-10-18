<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Exception\Magic;
use Smarty\Compiler\Format;

/**
 * Class RuleRoot;
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class PegParser// ; extends Magic
{
    /**
     * Name of parser
     *
     * @var string
     */
    public $name = '';

    /**
     * Array of attributes
     *
     * @var array
     */
    public $attributes = array();

    /**
     * Array of nodes
     *
     * @var array
     */
    public $nodes = array();

    /**
     * Set name of parser
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Add parser attribute
     *
     * @param attribute
     */
    public function addAttribute($attribute)
    {
        $this->attributes[] = $attribute;
    }

    /**
     * Add node
     *
     * @param $node
     */
    public function addNode($node)
    {
        $this->nodes[] = $node;
    }

    public function compileRuleArray(Root $target)
    {
        $this->compileHeader($target);
        foreach ($this->nodes as $key => $node) {
            $node->compileRuleArray($target);
            unset ($this->nodes[$key]);
        }
        $target->outdent();
    }

    public function compile(Root $target)
    {
        $this->compileHeader($target);

        // Compile node definitions
        foreach ($this->nodes as $key => $node) {
            $node->compile($target);
            unset ($this->nodes[$key]);
        }
        $target->outdent();
    }

    public function compileHeader(Root $target)
    {
        $target->newline()
               ->indent()
               ->code("/**\n")
               ->code(" *\n")
               ->code(" * Parser generated on " . strftime("%Y-%m-%d %H:%M:%S") . "\n")
               ->code(" *  Rule filename '{$target->filename}' dated " . strftime("%Y-%m-%d %H:%M:%S", $target->filetime) . "\n")
               ->code(" *\n")
               ->code("*/\n")
               ->newline()
               ->code("/**\n")
               ->code(" Flag that compiled Peg Parser class is valid\n")
               ->code(" *\n")
               ->code(" * @var bool\n")
               ->code(" */\n")
               ->code("public \$valid = true;\n")
               ->newline();
        //compile array of match method name
        $ruleMethods = array();
        foreach ($this->nodes as $node) {
            $name = $node->getName();
            $method = "matchNode{$name}";
            $ruleMethods[$name] = $method;
        }
        $target->newline()
               ->code("/**\n")
               ->code(" * Array of match method names for rules of this Peg Parser\n")
               ->code(" *\n")
               ->code(" * @var array\n")
               ->code(" */\n")
               ->code('public $ruleMethods = ')
               ->repr($ruleMethods)
               ->raw(';')
               ->newline();

        $nodeAttributes = array();
        foreach ($this->nodes as $node) {
            if (!empty($node->attributes)) {
                $nodeAttributes[$node->getName()] = $node->attributes;
            }
        }
        $target->newline()
               ->code("/**\n")
               ->code(" * Array of node attributes\n")
               ->code(" *\n")
               ->code(" * @var array\n")
               ->code(" */\n")
               ->code('public $nodeAttributes = ')
               ->Repr($nodeAttributes)
               ->raw(';')
               ->newline();
        $target->formatCode();
    }
}

