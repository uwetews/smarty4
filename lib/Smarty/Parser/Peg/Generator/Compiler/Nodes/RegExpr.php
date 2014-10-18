<?php
Namespace Smarty\Parser\Peg\Generator\Compiler\Nodes;

use Smarty\Compiler\Format;

/**
 * Class RegExpr
 * Compile regular expression rule
 *
 * @package Smarty\Parser\Peg\Generator\Compiler\Nodes
 */
class RegExpr extends RuleBase
{
    /**
     * Rule regular expression
     *
     * @var string
     */
    public $regExpr = '';

    /**
     * Constructor
     *
     * @param string $regExpr
     */
    public function __construct($regExpr)
    {
        $this->regExpr = $regExpr;
    }

    /**
     * Build regular expression rule array
     *
     * @return array
     */
    public function buildRuleArray()
    {
        return array('type' => 'RegExpr', 'regExpr' => $this->regExpr);
    }

    /**
     * Compile regular expression rule into PHP
     *
     * @param Format $target
     */
    function compile(Format $target)
    {
        $index = $this->token->node->index ++;
        $cacheName = "Rx_{$this->token->node->name}{$index}";
        preg_match_all('/\?<(\w+)>/', $this->regExpr, $pregMatch);
        //        }
        $regExpr = addcslashes($this->regExpr, '"\\');
        $target->code("\$regexp = \"{$regExpr}\";\n");
        $hasInitExpression = preg_match('/{(\w+)}/', $regExpr);
        $hasExpression = preg_match('/\$(\w+)/', $regExpr);
        if ($hasExpression) {
            $target->code("\$regexp = \$this->parser->dynamicRxReplace('{$this->token->node->name}',\$regExpr);\n");
        }
        $matchAll = $this->token->node->getAttribute('matchall');
        if ($matchAll && !$hasExpression) {
            $target->code("\$pos = \$this->parser->pos;\n")
                   ->code("if (isset(\$this->parser->regexpCache['{$cacheName}'][\$pos])) {\n", 1)
                   ->code("\$matchRes = \$this->parser->regexpCache['{$cacheName}'][\$pos];\n")
                   ->outdent()
                   ->code("} else {\n", 1);
            if ($hasInitExpression) {
                $target->code("if (isset(\$this->parser->rxCache['{$cacheName}'])) {\n", 1)
                       ->code("\$regexp = \$this->parser->rxCache['{$cacheName}'];\n")
                       ->outdent()
                       ->code("} else {\n", 1)
                       ->code("\$this->parser->rxCache['{$cacheName}'] = \$regexp = \$this->parser->initRxReplace('{$this->token->node->name}',\$regexp);\n")
                       ->code("}\n", - 1);
            }
            $target->code("if (empty(\$this->parser->regexpCache['{$cacheName}']) && preg_match_all(\$regexp . 'Sx', \$this->parser->source, \$pregMatches, PREG_OFFSET_CAPTURE+PREG_SET_ORDER, \$pos) && strlen(\$pregMatches[0][0][0])) {\n", 1)
                   ->code("\$this->parser->regexpCache['{$cacheName}'][- 1] = true;\n")
                   ->code("foreach (\$pregMatches as  \$pregMatch) {\n", 1)
                   ->code("\$matchRes = array('_silent' => 0, '_text' => \$pregMatch[0][0], '_startpos' => \$pregMatch[0][1], '_endpos' => \$pregMatch[0][1] + strlen(\$pregMatch[0][0]), '_pregMatch' => array());\n");
            if (isset($pregMatch[1][0])) {
                $target->code("foreach (\$pregMatch as \$n => \$v) {\n", 1)
                       ->code("if (is_string(\$n) && strlen(\$v[0])) {\n", 1)
                       ->code("\$matchRes['_pregMatch'][\$n] = \$v[0];\n")
                       ->code("}\n", - 1)
                       ->code("}\n", - 1);
            }
            $target->code("\$this->parser->regexpCache['{$cacheName}'][\$pregMatch[0][1]] = \$matchRes;\n")
                   ->code("}\n", - 1)
                   ->outdent()
                   ->code("} else {\n", 1)
                   ->code("\$this->parser->regexpCache['{$cacheName}'][- 1] = false;\n")
                   ->code("\$matchRes = false;\n")
                   ->code("}\n", - 1)
                   ->code("}\n", - 1)
                   ->code("if (isset(\$this->parser->regexpCache['{$cacheName}'][\$pos])) {\n", 1)
                   ->code("\$matchRes = \$this->parser->regexpCache['{$cacheName}'][\$pos];\n")
                   ->outdent()
                   ->code("} else {\n", 1)
                   ->code("\$this->parser->regexpCache['{$cacheName}'][\$pos] = false;\n")
                   ->code("\$matchRes = false;\n")
                   ->code("}\n", - 1);
        } else {
            $cache = false;
            $target->code("\$pos = \$this->parser->pos;\n");
            if ($cache) {
                $target->code("if (isset(\$this->parser->regexpCache['{$cacheName}'][\$pos])) {\n", 1)
                       ->code("\$matchRes = \$this->parser->regexpCache['{$cacheName}'][\$pos];\n")
                       ->outdent()
                       ->code("} else {\n", 1);
            }
            if ($hasInitExpression) {
                $target->code("if (isset(\$this->parser->rxCache['{$cacheName}'])) {\n", 1)
                       ->code("\$regexp = \$this->parser->rxCache['{$cacheName}'];\n")
                       ->outdent()
                       ->code("} else {\n", 1)
                       ->code("\$this->parser->rxCache['{$cacheName}'] = \$regexp = \$this->parser->initRxReplace('{$this->token->node->name}',\$regexp);\n")
                       ->code("}\n", - 1);
            }
            $target->code("if (preg_match(\$regexp . 'Sxs', \$this->parser->source, \$pregMatch, PREG_OFFSET_CAPTURE, \$pos) && (strlen(\$pregMatch[0][0]) || (isset(\$pregMatch[1]) && strlen(\$pregMatch[1][0])))) {\n", 1);
            if (isset($pregMatch[1][0])) {
                $target->code("if (strlen(\$pregMatch[0][0]) != 0) {\n", 1);
            }
            $target->code("\$matchRes = array('_silent' => 0, '_text' => \$pregMatch[0][0], '_startpos' => \$pregMatch[0][1], '_endpos' => \$pregMatch[0][1] + strlen(\$pregMatch[0][0]), '_pregMatch' => array());\n");
            if (isset($pregMatch[1][0])) {
                $target->code("foreach (\$pregMatch as \$n => \$v) {\n", 1)
                       ->code("if (is_string(\$n) && strlen(\$v[0])) {\n", 1)
                       ->code("\$matchRes['_pregMatch'][\$n] = \$v[0];\n")
                       ->code("}\n", - 1)
                       ->code("}\n", - 1);
            }
            $target->code("if (\$matchRes['_startpos'] != \$pos) {\n", 1);
            if ($cache) {
                $target->code("\$this->parser->regexpCache['{$cacheName}'][\$matchRes['_startpos']] = \$matchRes;\n")
                       ->code("\$this->parser->regexpCache['{$cacheName}'][\$pos] = false;\n");
            }
            $target->code("\$matchRes = false;\n")
                   ->code("}\n", - 1)
                   ->outdent()
                   ->code("} else {\n", 1);
            if ($cache) {
                $target->code("\$this->parser->regexpCache['{$cacheName}'][\$pos] = false;\n");
            }
            $target->code("\$matchRes = false;\n")
                   ->code("}\n", - 1);
            if (isset($pregMatch[1][0])) {
                $target->outdent()
                       ->code("} else {\n", 1);
                if ($cache) {
                    $target->code("\$this->parser->regexpCache['{$cacheName}'][\$pos] = false;\n");
                }
                $target->code("\$matchRes = false;\n")
                       ->code("}\n", - 1);
            }
            if ($cache) {
                $target->code("}\n", - 1);
            }
        }
        $target->code("if (\$matchRes) {\n", 1)
               ->code("\$matchRes['_lineno'] = \$this->parser->line;\n")
               ->code("\$this->parser->pos = \$matchRes['_endpos'];\n")
               ->code("\$this->parser->line += substr_count(\$matchRes['_text'], \"\\n\");\n");
        $target->formatCode();
        $this->token->node->compileRuleMatch($target, $this->token, 'nodeRes', 'matchRes');
        if (isset($pregMatch[1][0])) {
            foreach ($pregMatch[1] as $name) {
                if (isset($this->token->node->actions['match'][$name])) {
                    $target->code("if (isset(\$matchRes['_pregMatch']['{$name}'])) {\n", 1)
                           ->code("\$this->{$this->token->node->actions['match'][$name]->getMethod()}(\$nodeRes, \$matchRes);\n")
                           ->code("unset(\$matchRes['_pregMatch']['{$name}']);\n")
                           ->code("}\n", - 1);
                }
            }
        }
        if (isset($pregMatch[1][0])) {
            $target->code("\$nodeRes['_pregMatch'] = array_merge(\$nodeRes['_pregMatch'], \$matchRes['_pregMatch']);\n");
        }
        if ($this->token->nla) {
            $target->code("\$valid = false;\n");
        } else {
            $target->code("\$valid = true;\n");
        }
        $target->outdent()
               ->code("} else {\n", 1);
        if ($this->token->nla) {
            $target->code("\$valid = true;\n");
        } else {
            $target->code("\$valid = false;\n");
        }
        $target->code("}\n", - 1);
        $regExpr = addcslashes($this->regExpr, '"\\');
        $target->code("if (!\$valid) {\n", 1);
        $target->code("\$this->parser->matchError(\$error, 'rx', \"{$regExpr}\");\n")
               ->code("}\n", - 1);
        $target->formatCode();
        $this->token = null;
    }
}

