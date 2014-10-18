<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Compiler\Format;

/**
 * Class Literal
 * Compile literal rule
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class Literal extends RuleBase
{
    /**
     * Literal string
     *
     * @var string
     */
    public $literal = '';

    /**
     * Constructor
     *
     * @param string $literal
     */
    public function __construct($literal)
    {
        $this->literal = substr($literal, 1, strlen($literal) - 2);
    }

    /**
     * Return literal rule array
     *
     * @return array
     */
    public function buildRuleArray()
    {
        return array('type' => 'Literal', 'literal' => $this->literal);
    }

    /**
     * Compile literal rule into PHP
     *
     * @param Format $target
     */
    function compile(Format $target)
    {
        $len = strlen($this->literal);
        $literal = addcslashes($this->literal, "'\\");
        $target->code("if ('{$literal}' == substr(\$this->parser->source, \$this->parser->pos, {$len})) {\n", 1)
               ->code("\$this->parser->pos += {$len};\n");
        if ($this->token->silent == 0) {
            $target->code("\$nodeRes['_text'] .= '{$literal}';\n");
        }
        if (!empty($this->token->tag) && $this->token->node->actions['match'][$this->token->tag]) {
            $target->code("\$this->{$this->token->node->actions['match'][$this->token->tag]->getMethod()}(\$nodeRes,array('_text' => '{$this->literal}'));\n");
        }
        $target->code("if (\$trace) {\n", 1)
               ->code("\$traceObj->successNode(array('\\'{$literal}\\'', '{$literal}'));\n")
               ->code("}\n", - 1);
        if ($this->token->nla) {
            $target->code("\$this->parser->shouldNotMatchError(\$error, 'literal', '{$literal}');\n");
        }
        $nodeRes = ($this->token->nla) ? 'false' : 'true';
        $target->code("\$valid = {$nodeRes};\n")
               ->outdent()
               ->code("} else {\n", 1);
        if (!$this->token->nla) {
            $target->code("\$this->parser->matchError(\$error, 'literal', '{$literal}');\n");
        }
        $target->code("if (\$trace) {\n", 1)
               ->code("\$traceObj->failNode(array('\\'{$literal}\\'',  ''));\n")
               ->code("}\n", - 1);
        $nodeRes = ($this->token->nla) ? 'true' : 'false';
        $target->code("\$valid = {$nodeRes};\n")
               ->code("}\n", - 1);
        $target->formatCode();
    }
}

