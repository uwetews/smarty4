<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Compiler\Format;

/**
 * Class WhiteSpace
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class WhiteSpace extends RuleBase
{
    public $name = 'WhiteSpace';
    /**
     * Flag if whitespace is optional
     *
     * @var bool
     */
    public $optional = false;

    /**
     * Constructor
     *
     * @param bool $optional flag
     */
    public function __construct($optional)
    {
        $this->optional = $optional;
    }

    /**
     * Return whitespace rule array
     *
     * @return array
     */

    public function buildRuleArray()
    {
        return array('type' => 'WhiteSpace', 'literal' => $this->optional);
    }

    /**
     * @param Format $target
     */
    function compile(Format $target)
    {
        $target->code("if (preg_match(\$this->parser->whitespacePattern, \$this->parser->source, \$pregMatch, 0, \$this->parser->pos)) {\n", 1)
               ->code("if (!empty(\$pregMatch[0])) {\n", 1)
               ->code("\$this->parser->pos += strlen(\$pregMatch[0]);\n")
               ->code("\$this->parser->line += substr_count(\$pregMatch[0], \"\\n\");\n");
        if ($this->token->silent == 0) {
            $target->code("\$nodeRes['_text'] .= ' ';\n");
        }
        if (!$this->optional) {
            $target->code("\$valid = true;\n")
                   ->outdent()
                   ->code("} else {\n", 1)
                   ->code("\$valid = false;\n")
                   ->code("}\n", - 1)
                   ->outdent()
                   ->code("} else {\n", 1)
                   ->code("\$valid = false;\n")
                   ->code("}\n", - 1)
                   ->code("if (\$valid) {\n", 1)
                   ->code("if (\$trace) {\n", 1)
                   ->code("\$traceObj->successNode(array(\"' '\",  ' '));\n")
                   ->code("}\n", - 1);
            if ($this->token->nla) {
                $target->code("\$this->parser->shouldNotMatchError(\$error, 'whitespace');\n");
            }
            $target->outdent()
                   ->code("} else {\n", 1)
                   ->code("if (\$trace) {\n", 1)
                   ->code("\$traceObj->failNode(array(\"' '\",  ''));\n")
                   ->code("}\n", - 1);
            if ($this->token->nla) {
                $target->code("\$this->parser->matchError(\$error, 'whitespace');\n");
            }
            $target->code("}\n", - 1);
            if ($this->token->nla) {
                $target->code("\$valid = !\$valid;\n");
            }
        } else {

            $target->code("}\n", - 1)
                   ->code("}\n", - 1)
                   ->code("if (\$trace) {\n", 1)
                   ->code("\$traceObj->successNode(array(\"' '\",  \$pregMatch[0]));\n")
                   ->code("}\n", - 1)
                   ->code("\$valid = true;\n");
        }
        $target->formatCode();
    }
}

