<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Compiler\Format;

/**
 * Class MatchToken
 * Compile match token rule
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class MatchToken extends RuleBase
{

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Build match token rule array
     *
     * @return array
     */
    public function buildRuleArray()
    {
        return array('type' => 'MatchToken', 'name' => $this->name);
    }

    /**
     * Compile match token rule into PHP code
     *
     * @param Format $target
     *
     * @throws \Smarty_Exception
     */
    public function compile(Format $target)
    {
        $this->node = isset($this->node) ? $this->node : $this->token->node;
        $target->code("if (\$trace) {\n", 1)
               ->code("\$traceObj->addBacktrace(array('{$this->name}', ''));\n")
               ->code("}\n", - 1)
               ->code("\$matchRes = \$this->parser->matchRule(\$nodeRes, '{$this->name}', \$error);\n")
               ->code("if (\$trace) {\n", 1)
               ->code("\$remove = \$traceObj->popBacktrace();\n")
               ->code("}\n", - 1)
               ->code("if (\$matchRes) {\n")
               ->indent();
        if (!$this->token->pla) {
            $target->code("if (\$trace) {\n", 1)
                   ->code("\$traceObj->successNode(array('{$this->name}',  \$matchRes['_text']));\n")
                   ->code("}\n", - 1);
        }
        $this->node->compileRuleMatch($target, $this->token, 'nodeRes', 'matchRes');
        if ($this->token->nla) {
            $target->code("\$valid = false;\n");
        } else {
            $target->code("\$valid = true;\n");
        }
        $target->outdent()
               ->code("} else {\n")
               ->indent();
        if ($this->token->nla) {
            $target->code("\$valid = true;\n");
        } else {
            $target->code("\$valid = false;\n");
        }
        $target->code("if (\$trace) {\n", 1)
               ->code("\$traceObj->failNode(\$remove);\n")
               ->code("}\n", - 1)
               ->outdent()
               ->code("}\n");
        $target->formatCode();
        $this->node = null;
        $this->token = null;
    }
}

