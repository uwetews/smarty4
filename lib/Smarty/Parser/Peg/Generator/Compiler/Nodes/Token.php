<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Compiler\Format;

/**
 * Class Token
 * Basic token compiler
 *  - compile token frame
 *  - call rule type dependent compiler
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class Token extends RuleBase
{
    /**
     * Rule sub token depending on token type
     *
     * @var RuleBase
     */
    public $ruleToken = null;

    /**
     * Default positive look ahead value
     *
     * @var bool
     */
    public $pla = false;

    /**
     * Default negative look ahead value
     *
     * @var bool
     */
    public $nla = false;

    /**
     * Default maximum repeat value
     *
     * @var int
     */
    public $min = 1;

    /**
     * Default maximum repeat value
     *
     * @var int|null
     */
    public $max = 1;

    /**
     * Default silent mode of token
     *
     * @var int
     */
    public $silent = 0;

    /**
     * Rule source text
     *
     * @var string
     */
    public $ruleText = '';

    /**
     * Optional tag parameter
     *
     * @var string
     */
    public $tag = '';

    /**
     * Set maximum repeat parameter
     *
     * @param int|null $max
     */
    public function setMax($max)
    {
        $this->max = $max;
    }

    /**
     * Set minimum repeat parameter
     *
     * @param int $min
     */
    public function setMin($min)
    {
        $this->min = $min;
    }

    /**
     * Set negative look ahead parameter
     */
    public function setNla()
    {
        $this->nla = true;
    }

    /**
     * Set positive look ahead parameter
     */
    public function setPla()
    {
        $this->pla = true;
    }

    /**
     * Set silent parameter
     *
     * @param int $silent
     */
    public function setSilent($silent)
    {
        $this->silent = $silent;
    }

    /**
     * Set rule sub token
     *
     * @param RuleBase $token
     */
    public function setRuleToken(RuleBase $token)
    {
        $token->setToken($this);
        $this->ruleToken = $token;
    }

    /**
     * Set rule text
     *
     * @param string $text
     */
    public function setRuleText($text)
    {
        $this->ruleText = $text;
    }

    /**
     * Set name of optional token tag
     *
     * @param string $name
     */
    public function setTag($name)
    {
        $this->tag = $name;
    }

    /**
     * Get name from rule token
     *
     * @return string
     */
    public function getName()
    {
        return $this->ruleToken->getName();
    }

    /**
     * Get name of parent node
     *
     * @return string
     */
    public function getNodeName()
    {
        return $this->node->getName();
    }

    /**
     * Build rule Array
     *
     * @return array
     */
    public function buildRuleArray()
    {
        $ruleArray = array('type' => 'Token', 'name' => $this->name);
        if ($this->pla) {
            $ruleArray['pla'] = true;
        }
        if ($this->nla) {
            $ruleArray['nla'] = true;
        }
        if ($this->silent !== 0) {
            $ruleArray['silent'] = $this->silent;
        }
        if ($this->min !== 1) {
            $ruleArray['min'] = $this->min;
        }
        if ($this->max !== 1) {
            $ruleArray['max'] = $this->max;
        }
        if (!empty($this->tag)) {
            $ruleArray['tag'] = $this->tag;
        }
        return $ruleArray;
    }

    /**
     * Return token as rule array
     *
     * @return array
     */
    public function getRuleArray()
    {
        $ruleArray = $this->buildRuleArray();
        if (!empty($this->ruleText)) {
            $ruleArray['ruleText'] = $this->ruleText;
        }
        $ruleArray['ruleToken'] = $this->ruleToken->getRuleArray();
        $this->ruleToken = null;
        return $ruleArray;
    }

    /**
     * Compile token in rule array format
     *
     * @param Format $target
     */
    public function compileRuleArray(Format $target)
    {
        $ruleArray = $this->buildRuleArray();
        $code = new Format;
        $this->ruleToken->compileRuleArray($code);
        $this->ruleToken = null;
        $ruleArray['ruleToken'] = $code;
        $target->repr($ruleArray);
    }

    /**
     * Compile token into PHP code
     *
     * @param Format $target
     */
    public function compile(Format $target, $delete = true)
    {
        $this->node = isset($this->node) ? $this->node : $this->token->node;
        $index = $this->node->index ++;
        $com = isset($this->ruleText) ? $this->ruleText : $this->token->name;
        $target->code("/*\n")
               ->code(" * Start rule: {$com}\n");
        if (!empty($this->tag)) {
            $target->code(" *       tag: '{$this->tag}'\n");
        }
        $target->code(" *       min: {$this->min} max: ");
        if ($this->max === null) {
            $target->raw("null\n");
        } else {
            $target->raw("{$this->max}\n");
        }
        if ($this->pla) {
            $target->code(" *       look ahead: 'positive'\n");
        }
        if ($this->nla) {
            $target->code(" *       look ahead: 'negative'\n");
        }
        $target->code(" */\n");
        if ($this->pla || $this->nla) {
            $target->code("\$backup{$index} = \$nodeRes;\n")
                   ->code("\$pos{$index} = \$this->parser->pos;\n")
                   ->code("\$line{$index} = \$this->parser->line;\n");
        } else {
            if ($this->min == 0 && $this->max == 1) {
                $target->code("\$error = array();\n");
            }
        }
        $loop = $this->min > 1 || $this->max != 1;
        if ($loop) {
            $target->code("\$iteration{$index} = 0;\n")
                   ->code("do {\n", 1);
        }
        $this->ruleToken->compile($target, $this);
        if ($this->pla || $this->nla) {
            $target->code("\$this->parser->pos = \$pos{$index};\n")
                   ->code("\$this->parser->line = \$line{$index};\n")
                   ->code("\$nodeRes = \$backup{$index};\n")
                   ->code("unset(\$backup{$index});\n");
        }
        if ($loop) {
            $target->code("\$iteration{$index} = \$valid ? (\$iteration{$index} + 1) : \$iteration{$index};\n");
            if ($this->max !== null) {
                $target->code("if (\$valid && \$iteration{$index} == {$this->max}) break;\n");
            }
            $target->code("if (!\$valid && \$iteration{$index} >= {$this->min}) {\n")
                   ->indent()
                   ->code("\$valid = true;\n")
                   ->code("break;\n")
                   ->code("}\n", - 1)
                   ->code("if (!\$valid) break;\n")
                   ->code("} while (true);\n", - 1);
        }
        if ($this->min == 0 && $this->max == 1) {
            if (!($this->pla || $this->nla)) {
                $target->code("if (!\$valid) {\n", 1)
                       ->code("\$this->parser->logOption(\$errorResult, '{$this->ruleToken->getName()}', \$error);\n")
                       ->code("}\n", - 1);
            }
            $target->code("\$valid = true;\n");
        }
        $target->code("/*\n")
               ->code(" * End rule: {$com}\n")
               ->code(" */\n");
        $target->formatCode();
        $this->ruleToken = null;
    }
}

