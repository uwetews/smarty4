<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Compiler\Format;

/**
 * Class Sequence
 * Compile token sequence rule
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class Sequence extends RuleBase
{
    /**
     * @var string
     */
    public $name = 'Sequence';

    /**
     * Array of sequence nodes
     *
     * @var array of RuleBase
     */
    public $sequenceNodes = array();

    /**
     * Set parent node
     *
     * @param Node $node
     */
    public function setNode(Node $node)
    {
        $this->node = $node;
        foreach ($this->sequenceNodes as $sn) {
            $sn->setNode($node);
        }
    }

    /**
     * Add sequence nodes
     *
     * @param $nodes
     */
    public function addSequenceNodes($nodes)
    {
        $this->sequenceNodes = array_merge($this->sequenceNodes, (array) $nodes);
    }

    /**
     * Build sequence rule array
     *
     * @return array
     */
    public function buildRuleArray()
    {
        return array('type' => 'Sequence', 'name' => 'Sequence', 'sequenceRules' => array());
    }

    /**
     * Return sequence rule array
     *
     * @return array
     */
    public function getRuleArray()
    {
        $ruleArray = $this->buildRuleArray();
        foreach ($this->sequenceNodes as $rule) {
            $ruleArray['sequenceRules'][] = $rule->getRuleArray();
        }
        $this->sequenceNodes = array();
        return $ruleArray;
    }

    /**
     * Compile sequence rule in rule array format
     *
     * @param Format $target
     */
    public function compileRuleArray(Format $target)
    {
        $ruleArray = $this->buildRuleArray();
        foreach ($this->sequenceNodes as $rule) {
            $code = new Format;
            $rule->compileRuleArray($code);
            $ruleArray['sequenceRules'][] = $code;
        }
        $target->repr($ruleArray);
        $this->sequenceNodes = array();
    }

    /**
     * Compile sequence rule into PHP code
     *
     * @param Format $target
     *
     * @throws \Smarty_Exception
     */
    public function compile(Format $target)
    {
        $this->node = isset($this->node) ? $this->node : $this->token->node;
        $index = $this->node->index ++;
        $target->code("// start sequence\n")
               ->code("\$backup{$index} = \$nodeRes;\n")
               ->code("\$pos{$index} = \$this->parser->pos;\n")
               ->code("\$line{$index} = \$this->parser->line;\n")
               ->code("\$error{$index} = \$error;\n")
               ->code("if (\$trace) {\n", 1)
               ->code("\$traceObj->addBacktrace(array('_s{$index}_', ''));\n")
               ->code("}\n", - 1)
               ->code("do {\n")
               ->indent();
        foreach ($this->sequenceNodes as $key => $rule) {
            $rule->setNode($this->node);
            $target->code("\$error = array();\n");
            $rule->compile($target);
            unset ($rule, $this->sequenceNodes[$key]);
            $target->code("if (!\$valid) {\n")
                   ->indent()
                   ->code("\$this->parser->matchError(\$error{$index}, 'SequenceElement', \$error);\n")
                   ->code("\$error = \$error{$index};\n")
                   ->code("break;\n")
                   ->outdent()
                   ->code("}\n");
        }
        $target->formatCode();
        $target->code("break;\n")
               ->outdent()
               ->code("} while (true);\n")
               ->code("if (!\$valid) {\n")
               ->indent()
               ->code("if (\$trace) {\n", 1)
               ->code("\$traceObj->failNode();\n")
               ->code("}\n", - 1)
               ->code("\$this->parser->pos = \$pos{$index};\n")
               ->code("\$this->parser->line = \$line{$index};\n")
               ->code("\$nodeRes = \$backup{$index};\n")
               ->outdent()
               ->code("} elseif (\$trace) {\n", 1)
               ->code("\$traceObj->successNode();\n")
               ->code("}\n", - 1)
               ->code("\$error = \$error{$index};\n");
        if (isset($this->token) && $this->token->nla) {
            $target->code("\$valid = !\$valid;\n");
        }

        if (!empty($this->token->tag)) {
            $target->code("if (\$valid) {\n")
                   ->indent();
            $this->node->compileRuleMatch($target, $this->token, "backup{$index}", 'nodeRes');
            $target->outdent()
                   ->code("}\n")
                   ->code("\$nodeRes = \$backup{$index};\n");
        }
        $target->code("unset(\$backup{$index});\n");
        $target->code("// end sequence\n");
        $target->formatCode();
    }
}

