<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Compiler\Format;

/**
 * Class Expression
 * Compile expression rule
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class Expression extends RuleBase
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
        return array('type' => 'Expression', 'name' => $this->name);
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
        $method = "{$this->getNodeName()}_EXP_{$this->name}";
        $target->code("\$matchRes = \$nodeRes;\n")
               ->code("if (\$trace) {\n", 1)
               ->code("\$traceObj->addBacktrace(array('{$method}', ''));\n")
               ->code("}\n", - 1)
               ->code("\$valid = \$this->{$method}(\$matchRes);\n");
        if (isset($params['_actions']['_finish'])) {
            $target->code("if (\$valid) {\n", 1);
            foreach ($params['_actions']['_finish'] as $method => $foo) {
                $target->code("\$this->{$method}(\$matchRes);\n")
                       ->code("if (\$matchRes === false) {\n", 1)
                       ->code("\$valid = false;\n")
                       ->code("}\n", - 1);
            }
            $target->code("}\n", - 1);
        }
        $target->code("if (\$valid) {\n", 1)
               ->code("if (\$trace) {\n", 1)
               ->code("\$traceObj->successNode();\n")
               ->code("}\n", - 1);
        $this->token->node->compileRuleMatch($target, $this->token, 'nodeRes', 'matchRes');
        $target->outdent()
               ->code("} else {\n", 1)
               ->code("\$this->parser->matchError(\$error, 'expression', '{$method}');\n")
               ->code("if (\$trace) {\n", 1)
               ->code("\$traceObj->failNode();\n")
               ->code("}\n", - 1)
               ->code("}\n", - 1);
    }
}

