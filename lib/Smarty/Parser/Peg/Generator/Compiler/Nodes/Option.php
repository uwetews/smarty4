<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Compiler\Format;

/**
 * Class Option
 * Compile optional token rule
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class Option extends RuleBase
{
    /**
     * Name of token
     *
     * @var string
     */
    public $name = 'Option';

    /**
     * Array of option nodes
     *
     * @var array RuleBase
     */
    public $optionNodes = array();

    /**
     * Set parent node
     *
     * @param Node $node
     */
    public function setNode(Node $node)
    {
        $this->node = $node;
        foreach ($this->optionNodes as $on) {
            $on->setNode($node);
        }
    }

    /**
     * Add optional nodes
     *
     * @param $nodes
     */
    public function addOptionNodes($nodes)
    {
        $this->optionNodes = array_merge($this->optionNodes, (array) $nodes);
    }

    /**
     * Build option rule array
     *
     * @return array
     */
    public function buildRuleArray()
    {
        return array('type' => 'Option', 'name' => 'Option', 'optionalRules' => array());
    }

    /**
     * Return option rule array
     *
     * @return array
     */
    public function getRuleArray()
    {
        $ruleArray = $this->buildRuleArray();
        foreach ($this->optionNodes as $rule) {
            $ruleArray['optionalRules'][] = $rule->getRuleArray();
        }
        $this->optionNodes = array();
        return $ruleArray;
    }

    /**
     * Compile option rule in rule array format
     *
     * @param Format $target
     */
    public function compileRuleArray(Format $target)
    {
        $ruleArray = $this->buildRuleArray();
        foreach ($this->optionNodes as $rule) {
            $code = new Format;
            $rule->compileRuleArray($code);
            $ruleArray['optionalRules'][] = $code;
        }
        $target->repr($ruleArray);
        $this->optionNodes = array();
    }

    /**
     * Compile option rule into PHP code
     *
     * @param Format $target
     *
     * @throws \Smarty_Exception
     */
    public function compile(Format $target)
    {
        $this->node = isset($this->node) ? $this->node : $this->token->node;
        $index = $this->node->index ++;
        $target->code("// start option\n");
        $target->code("\$error{$index} = \$error;\n");
        $target->code("\$errorOption{$index} =array();\n")
               ->code("if (\$trace) {\n", 1)
               ->code("\$traceObj->addBacktrace(array('_o{$index}_', ''));\n")
               ->code("}\n", - 1)
               ->code("do {\n", 1);
        $i = 0;
        foreach ($this->optionNodes as $rule) {
            $rule->setNode($this->node);
            $name = $rule->getName();
            $i ++;
            $target->code("\$error = array();\n")
                   ->code("if (\$trace) {\n", 1)
                   ->code("\$traceObj->popBacktrace();\n")
                   ->code("\$traceObj->addBacktrace(array('_o{$index}:{$i}_', ''));\n")
                   ->code("}\n", - 1);
            $target->formatCode();
            $rule->compile($target);
            $target->code("if (\$valid) {\n")
                   ->indent()
                   ->code("if (\$trace) {\n", 1)
                   ->code("\$traceObj->successNode();\n")
                   ->code("}\n", - 1);
            if ($rule->nla) {
                $target->code("\$this->parser->shouldNotMatchError(\$error{$index}, '{$name}', \$error;\n;");
            }
            $target->code("\$error = \$error{$index};\n");
            $target->code("break;\n")
                   ->outdent()
                   ->code("} else {\n", 1)
                   ->code("\$this->parser->logOption(\$errorOption{$index}, '{$name}', \$error);\n")
                   ->code("}\n", - 1);
        }
        $target->code("\$error = \$error{$index};\n");
        // TODO  check this nla handling
        if ($rule->nla) {
            $target->code("\$this->parser->matchError(\$error, 'Option', \$errorOption{$index});\n");
        }
        $target->code("if (\$trace) {\n", 1)
               ->code("\$traceObj->popBacktrace();\n")
               ->code("}\n", - 1);
        $target->code("break;\n");
        $target->outdent()
               ->code("} while (true);\n");
        /**
         * if ($this->token->nla) {
         * $target->code("\$valid = !\$valid;\n");
         * }
         * */
        //        $target->code("unset(\$error{$index}, \$errorOption{$index});\n");
        $target->code("// end option\n");
        $target->formatCode();
        $this->optionNodes = array();
    }
}

