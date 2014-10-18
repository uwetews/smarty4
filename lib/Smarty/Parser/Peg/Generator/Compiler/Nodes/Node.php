<?php

Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Compiler\Format;
use Smarty\Exception\Magic;

/**
 * Class Node
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class Node extends Magic
{
    /**
     * Match name of token/node
     *
     * @var string
     */
    public $name = '';

    /**
     * Type of  this token: 'token' or 'node'
     *
     * @var string
     */
    public $type = '';

    /**
     * String with token definition
     *
     * @var string
     */
    public $definition = '';

    /**
     * Array of attributes
     *
     * @var array
     */
    public $attributes = array();

    /**
     * Rule node
     *
     * @var Rule
     */
    public $rule = null;

    /**
     * Array of action node
     *
     * @var array Action
     */
    public $actions = array();

    public $index = 0;

    /**
     * Set match name of token
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name of token

     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set token type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Set token definition String
     *
     * @param string $definition
     */
    public function setDefinition($definition)
    {
        $this->definition = $definition;
    }

    /**
     * Add token attribute
     *
     * @param attribute
     */
    public function addAttribute($attribute)
    {
        $this->attributes = array_merge($this->attributes, $attribute);
    }

    /**
     * Get attribute by name
     *
     * @param string $name
     */
    public function getAttribute($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : false;
    }

    /**
     * Add action
     *
     * @param $action
     */
    public function addAction(Action $action)
    {
        $action->addActionToNode($this);
    }

    /**
     * Add rule
     *
     * @param $rule
     */
    public function setRule($rule)
    {
        $rule->setNode($this);
        $this->rule = $rule;
    }

    /**
     * Build node rule array
     *
     * @return array
     */
    public function buildRuleArray()
    {
        return array('type' => 'Node', 'name' => $this->name);
    }

    /**
     * Return node rule array
     *
     * @return array
     */
    public function getRuleArray()
    {
        $ruleArray = $this->buildRuleArray();
        $ruleArray['rule'] = $this->rule->getRuleArray();
        $this->rule = null;
        return $ruleArray;
    }

    /**
     * Compile node in rule array format
     *
     * @param Format $target
     */
    public function compileRuleArray(Format $target)
    {
        $target->newline();
        $this->compileHeader($target, false);
        $target->code("public function matchNode{$this->name}(\$previous, &\$errorResult){\n")
               ->indent()
               ->code("\$ruleArrayParser = \$this->parser->instanceRuleArrayParser();\n");
        $ruleArray = $this->buildRuleArray();
        $code = new Format;
        $this->rule->compileRuleArray($code);
        $this->rule = null;
        $ruleArray['rule'] = $code;
        $target->code("return \$ruleArrayParser->matchArrayNode (\$previous, \$errorResult, ")
               ->repr($ruleArray)
               ->raw(", \$this);\n")
               ->code("}\n", - 1);
        $target->formatCode();
        // compile actions
        $this->compileActions($target);
    }

    public function compile(Format $target)
    {
        $this->compileHeader($target);
        $target->code("public function matchNode{$this->name}(\$previous, &\$errorResult){\n")
               ->indent()
               ->code("\$trace = \$this->parser->trace;\n")
               ->code("if (\$trace) {\n", 1)
               ->code("\$traceObj = \$this->parser->getTraceObj();\n")
               ->code("}\n", - 1)
               ->code("\$nodeRes = \$this->parser->resultDefault;\n")
               ->code("\$error = array();\n")
               ->code("\$pos0 = \$nodeRes['_startpos'] = \$nodeRes['_endpos'] = \$this->parser->pos;\n")
               ->code("\$nodeRes['_lineno'] = \$this->parser->line;\n");
        $hash = $this->getAttribute('hash');
        if ($hash) {
            $target->code("if (isset(\$this->parser->packCache[\$this->parser->pos]['{$this->name}'])) {\n", 1)
                   ->code("\$nodeRes = \$this->parser->packCache[\$this->parser->pos]['{$this->name}'];\n")
                   ->code("\$error = \$this->parser->errorCache[\$this->parser->pos]['{$this->name}'];\n")
                   ->code("if (\$nodeRes) {\n", 1)
                   ->code("\$this->parser->pos = \$nodeRes['_endpos'];\n")
                   ->code("\$this->parser->line = \$nodeRes['_endline'];\n")
                   ->outdent()
                   ->code("} else {\n", 1)
                   ->code("\$this->parser->matchError(\$errorResult, 'token', \$error, '{$this->name}');\n")
                   ->code("}\n", - 1)
                   ->code("return \$nodeRes;\n")
                   ->code("}\n", - 1);
        }
        if (isset($this->actions['_start'])) {
            $target->code("\$this->{$this->actions['_start']->getMethod()}(\$nodeRes, \$previous);\n");
        }
        $target->formatCode();
        $this->rule->compile($target);
        $this->rule = null;
        $target->code("if (\$valid) {\n", 1)
               ->code("\$nodeRes['_endpos'] = \$this->parser->pos;\n")
               ->code("\$nodeRes['_endline'] = \$this->parser->line;\n");
        if (isset($this->actions['_finish'])) {
            $target->code("\$this->{$this->actions['_finish']->getMethod()}(\$nodeRes);\n");
        }
        $target->code("}\n", - 1)
               ->code("if (!\$valid) {\n", 1)
               ->code("\$nodeRes = false;\n")
               ->code("\$this->parser->matchError(\$errorResult, 'token', \$error, '{$this->name}');\n")
               ->code("}\n", - 1);
        if ($hash) {
            $target->code("\$this->parser->packCache[\$pos0]['{$this->name}'] = \$nodeRes;\n");
            $target->code("\$this->parser->errorCache[\$pos0]['{$this->name}'] = \$error;\n");
        }
        $target->code("return \$nodeRes;\n")
               ->code("}\n", - 1);
        $target->formatCode();
        // compile actions
        $this->compileActions($target);
    }

    public function compileActions(Format $target)
    {
        foreach ($this->actions as $key => $action) {
            if ($key == 'match' || $key == '_init' || $key == '_expression') {
                foreach ($action as $matchAction) {
                    $matchAction->compile($target);
                }
            } else {
                $action->compile($target);
            }
            unset($this->actions[$key]);
        }
    }

    public function compileHeader(Format $target, $actions = true)
    {
        $definition = explode("\n", $this->definition);
        $target->code("/**\n")
               ->code(" *\n")
               ->code(" * Parser rules ");
        if ($actions) {
            $target->raw("and actions ");
        }
        $target->raw("for node '{$this->name}'\n")
               ->code(" *\n")
               ->code(" *  Rule:\n");
        foreach ($definition as $def) {
            $target->code(" * {$def}\n");
        }
        $target->code(" *\n")
               ->code("*/\n");
    }

    /**
     * @param $params
     * @param $nodeRes
     * @param $matchRes
     */
    public function compileRuleMatch(Format $target, Token $token, $nodeRes, $matchRes)
    {
        if ($token->silent == 0) {
            $target->code("\${$nodeRes}['_text'] .= \${$matchRes}['_text'];\n");
        }
        $found = false;
        if (isset($this->actions['_all'])) {
            $target->code("\$this->{$this->actions['_all']->getMethod()}(\${$nodeRes}, \${$matchRes});\n");
            $found = true;
        }
        if (!$found) {
            $name = (!empty($token->tag)) ? $token->tag : $token->getName();
            if (isset($name)) {
                if (isset($this->actions['match'][$name])) {
                    $target->code("\$this->{$this->actions['match'][$name]->getMethod()}(\${$nodeRes}, \${$matchRes});\n");
                    $found = true;
                }
                if (!$found) {
                    $target->code("if(!isset(\${$nodeRes}['{$name}'])) {\n", 1)
                           ->code("\${$nodeRes}['{$name}'] = \${$matchRes};\n")
                           ->outdent()
                           ->code("} else {\n", 1)
                           ->code("if (!is_array(\${$nodeRes}['{$name}'])) {\n", 1)
                           ->code("\${$nodeRes}['{$name}'] = array(\${$nodeRes}['{$name}']);\n")
                           ->code("}\n", - 1)
                           ->code("\${$nodeRes}['{$name}'][] = \${$matchRes};\n")
                           ->code("}\n", - 1);
                }
            }
        }
        $target->formatCode();
    }
}

