<?php

Namespace Smarty\Tool\Parser\Peg\Nodes;

/**
 * Class ParserCompiler
 *
 * @package Smarty\Tool\Parser\Peg\Nodes
 */
class ParserCompiler
{
    /**
     * @var string
     */
    public $_name = 'Parser';
    /**
     * @var string
     */
    public $_type = 'parser';
    /**
     * @var array
     */
    public $nodes = array();
    /**
     * @var array
     */
    public $actions = array();
    /**
     * @var array
     */
    public $comments = array();
    /**
     * @var string
     */
    public $output = '';
    /**
     * @var int
     */
    public $indentation = 1;
     /**
     * @var bool
     */
    public $indent_on = true;
    /**
     * @var bool
     */
    public $no_indent = false;
    /**
     * @var int
     */
    public $index = 0;
    /**
     * @var array
     */
    public $nodeAttributes = array();

    /**
     * Compile nodes
     *
     * @param $filename
     * @param $filetime
     *
     * @return string
     */
    public function compile($filename, $filetime)
    {
        foreach ($this->nodes as $name => $dummy) {
            if (isset($this->actions[$name])) {
                foreach ($this->actions[$name] as $action) {
                    switch ($action['funcname']) {
                        case '_finish' :
                            $this->nodes[$name]['_actions']['_finish']["{$name}___FINISH"] = true;
                            break;
                        case '_start':
                            $this->nodes[$name]['_actions']['_start']["{$name}___START"] = true;
                            break;
                        case '_expression':
                            $this->nodes[$name]['_actions']['_expression']["{$name}_EXP_{$action['argument']}"] = true;
                            break;
                        case '_init':
                            $this->nodes[$name]['_actions']['_init']["{$name}_INIT_{$action['argument']}"] = true;
                            break;
                        case '_all':
                            $this->nodes[$name]['_actions']['_all']["{$name}___ALL"] = true;
                            break;
                        default:
                            $this->nodes[$name]['_actions']['_match'][$action['funcname']]["{$name}_{$action['funcname']}"] = true;
                            break;
                    }
                }
            }
        }
        $this->newline()
             ->php("/**")
             ->newline();
        $this->php(" *")
             ->newline();
        $this->php(" * Parser generated on " . strftime("%Y-%m-%d %H:%M:%S"))
             ->newline();
        $this->php(" *  Rule filename '{$filename}' dated " . strftime("%Y-%m-%d %H:%M:%S", $filetime))
             ->newline();
        $this->php(" *")
             ->newline();
        $this->php("*/")
             ->newline();

        $this->newline()
             ->php("/**\n")
             ->php(" Flag that compiled Peg Parser class is valid\n")
             ->php(" *\n")
             ->php(" * @var bool\n")
             ->php(" */\n")
             ->php("public \$valid = true;")
             ->newline();

        $matchMethods = array();
        foreach ($this->nodes as $rule) {
            $name = $rule['_name'];
            $method = "matchNode{$name}";
            $matchMethods[$name] = $method;
        }
        $this->newline()
             ->php("/**\n")
             ->php(" * Array of match method names for rules of this Peg Parser\n")
             ->php(" *\n")
             ->php(" * @var array\n")
             ->php(" */\n")
             ->php('public $matchMethods = ')
             ->Repr($matchMethods)
             ->raw(';')
             ->newline();

        $this->nodeAttributes = array();
        foreach ($this->nodes as $rule) {
            if (isset($rule['_attr'])) {
                $name = $rule['_name'];
                $attr = $rule['_attr'];
                $this->nodeAttributes[$name] = $attr;
            }
        }
        $this->newline()
             ->php("/**\n")
             ->php(" * Array of node attributes\n")
             ->php(" *\n")
             ->php(" * @var array\n")
             ->php(" */\n")
             ->php('public $nodeAttributes = ')
             ->Repr($this->nodeAttributes)
             ->raw(';')
             ->newline();

        foreach ($this->nodes as $rule) {
            $name = $rule['_name'];
            if (isset($this->comments[$name])) {
                $this->php("/**")
                     ->newline();
                $this->php(" *")
                     ->newline();
                $this->php(" * Parser rules and action for node '{$name}'")
                     ->newline();
                $this->php(" *")
                     ->newline();
                $this->php(" *  Rule:")
                     ->newline();
                $this->php($this->comments[$name])
                     ->newline();
                $this->php(" *")
                     ->newline();
                $this->php("*/")
                     ->newline();
            }
            $this->compileMatchNode($rule);
            if (isset($this->actions[$name])) {
                foreach ($this->actions[$name] as $action) {
                    $func = "public function {$name}";
                    switch ($action['funcname']) {
                        case '_finish' :
                            $func .= "___FINISH (&\$result) ";
                            break;
                        case '_start':
                            $func .= "___START (&\$result, \$previous) ";
                            break;
                        case '_expression':
                            $func .= "_EXP_{$action['argument']} (&\$result) ";
                            break;
                        case '_init':
                            $func .= "_INIT_{$action['argument']} (&\$rule) ";
                            break;
                        case '_all':
                            $func .= "___ALL (&\$result, \$subres) ";
                            break;
                        default:
                            $func .= "_{$action['funcname']} (&\$result, \$subres) ";
                            break;
                    }
                    $this->formatPHP(trim($func . $action['code']));
                    $this->newline();
                }
            }
            $this->newline();
        }

        return $this->output;
    }

    /**
     * Add newline to the current buffer.
     *
     * @return $this
     */
    public function newline()
    {
        if (!$this->no_indent) {
            $this->output .= "\n";
        }

        return $this;
    }

    /**
     * Add a line of PHP code to output.
     *
     * @param  string $value PHP source
     * @param int     $indent negative = outdent before code, positive indent after code
     *
     * @return $this
     */
    public function php($value, $indent = 0)
    {
        if ($indent < 0) {
            $this->outdent(- $indent);
        }
        $this->addIndentation();
        $this->output .= $value;
        if ($indent > 0) {
            $this->indent($indent);
        }

        return $this;
    }

    /**
     * Add an indentation to the current buffer.
     *
     * @return $this
     */
    public function addIndentation()
    {
        if ($this->indent_on && !$this->no_indent) {
            $this->output .= str_repeat(' ', $this->indentation * 4);
        }

        return $this;
    }

    /**
     * @param $rule
     */
    public function compileMatchNode($rule)
    {
        $this->index = 0;
        $this->php("public function matchNode{$rule['_name']}(\$previous, &\$errorResult){\n")
             ->indent()
             ->php("\$result = \$this->parser->resultDefault;\n")
             ->php("\$error = array();\n")
             ->php("\$pos0 = \$result['_startpos'] = \$result['_endpos'] = \$this->parser->pos;\n")
             ->php("\$result['_lineno'] = \$this->parser->line;\n");
        $hash = $this->getAttribute($rule['_name'], 'hash');
        if ($hash) {
            $this->php("if (isset(\$this->parser->packCache[\$this->parser->pos]['{$rule['_name']}'])) {\n", 1)
                 ->php("\$result = \$this->parser->packCache[\$this->parser->pos]['{$rule['_name']}'];\n")
                 ->php("\$error = \$this->parser->errorCache[\$this->parser->pos]['{$rule['_name']}'];\n")
                 ->php("if (\$result) {\n", 1)
                 ->php("\$this->parser->pos = \$result['_endpos'];\n")
                 ->php("\$this->parser->line = \$result['_endline'];\n")
                 ->outdent()
                 ->php("} else {\n", 1)
                 ->php("\$this->parser->matchError(\$errorResult, 'token', \$error, '{$rule['_name']}');\n")
                 ->php("}\n", - 1)
                 ->php("return \$result;\n")
                 ->php("}\n", - 1);
        }
        if (isset($rule['_actions']['_start'])) {
            foreach ($rule['_actions']['_start'] as $method => $foo) {
                $this->php("\$this->{$method}(\$result, \$previous);\n");
            }
        }
        $this->compileMatchRule($rule);
        $this->php("if (\$valid) {\n")
             ->indent()
             ->php("\$result['_endpos'] = \$this->parser->pos;\n")
             ->php("\$result['_endline'] = \$this->parser->line;\n");
        if (isset($rule['_actions']['_finish'])) {
            $loop = 0;
            foreach ($rule['_actions']['_finish'] as $method => $foo) {
                if ($loop > 0) {
                    $this->php("if (\$result !== false) {\n", 1);
                }
                $this->php("\$this->{$method}(\$result);\n");
                if ($loop > 0) {
                    $this->php("}\n", - 1);
                }
            }
        }
        $this->php("}\n", - 1)
             ->php("if (!\$valid) {\n", 1)
             ->php("\$result = false;\n")
             ->php("\$this->parser->matchError(\$errorResult, 'token', \$error, '{$rule['_name']}');\n")
             ->php("}\n", - 1);
        if ($hash) {
            $this->php("\$this->parser->packCache[\$pos0]['{$rule['_name']}'] = \$result;\n");
            $this->php("\$this->parser->errorCache[\$pos0]['{$rule['_name']}'] = \$error;\n");
        }
        $this->php("return \$result;\n")
             ->php("}\n", - 1);
    }

    /**
     * @param $params
     */
    public function compileMatchRule(&$params)
    {
        $com = isset($params['_tagcomment']) ? $params['_tagcomment'] : $params['_name'];
        $params = $this->buildParams($params);
        $comment = "// Start '{$com}' ";
        if (isset($params['_tag']) && $params['_tag'] !== false) {
            $comment .= "tag '{$params['_tag']}' ";
        }
        $comment .= "min '{$params['_min']}' max ";
        if ($params['_max'] === null) {
            $comment .= "'null'";
        } else {
            $comment .= "'{$params['_max']}'";
        }
        $la = null;
        if ($params['_pla']) {
            $la = true;
            $comment .= " positive lookahead";
        }
        if ($params['_nla']) {
            $la = false;
            $comment .= " negative lookahead";
        }
        $comment .= "\n";
        $this->php($comment);
        $index = $this->index ++;
        if ($params['_pla'] || $params['_nla']) {
            $this->php("\$backup{$index} = \$result;\n")
                 ->php("\$pos{$index} = \$this->parser->pos;\n")
                 ->php("\$line{$index} = \$this->parser->line;\n");
        } else {
            if ($params['_min'] == 0 && $params['_max'] == 1) {
                $this->php("\$error = array();\n");
            }
        }
        if ($params['_loop']) {
            $this->php("\$iteration{$index} = 0;\n")
                 ->php("do {\n", 1);
        }
        //        $neg = $params['_nla'] ? '!' : '';
        $this->compileToken($params, $la);
        //        $this->php("\$valid = {$neg}\$this->parser->matchToken(\$result, \$params);\n");
        if ($params['_pla'] || $params['_nla']) {
            $this->php("\$this->parser->pos = \$pos{$index};\n")
                 ->php("\$this->parser->line = \$line{$index};\n")
                 ->php("\$result = \$backup{$index};\n")
                 ->php("unset(\$backup{$index});\n");
        } else {
            //$this->php("\$result['_endpos'] = \$this->parser->pos;\n");
        }
        if ($params['_loop']) {
            $this->php("\$iteration{$index} = \$valid ? (\$iteration{$index} + 1) : \$iteration{$index};\n");
            if ($params['_max'] !== null) {
                $this->php("if (\$valid && \$iteration{$index} == {$params['_max']}) break;\n");
            }
            $this->php("if (!\$valid && \$iteration{$index} >= {$params['_min']}) {\n")
                 ->indent()
                 ->php("\$valid = true;\n")
                 ->php("break;\n")
                 ->outdent()
                 ->php("}\n")
                 ->php("if (!\$valid) break;\n")
                 ->outdent()
                 ->php("} while (true);\n");
        }
        if ($params['_min'] == 0 && $params['_max'] == 1) {
            if (!($params['_pla'] || $params['_nla'])) {
                $this->php("if (!\$valid) {\n", 1)
                     ->php("\$this->parser->logOption(\$errorResult, '{$params['_name']}', \$error);\n")
                     ->php("}\n", - 1);
            }
            $this->php("\$valid = true;\n");
        }
        $this->php("// End '{$com}'\n");
    }

    /**
     * @param      $params
     * @param bool $la
     *
     * @return bool|null|void
     */
    public function compileToken(&$params, $la = false)
    {
        switch ($params['_type']) {
            case 'recurse':
                $this->compileRecurse($params, $la);
                break;
            case 'rx':
                $this->compileRx($params, $la);
                $regexp = addcslashes($params['_param'], '"\\');
                $this->php("if (\$valid) {\n", 1);
                $this->compileRuleMatch($params, 'result', 'subres');
                $this->php("} else {\n", 1)
                     ->php("\$this->parser->matchError(\$error, 'rx', \"{$regexp}\");\n")
                     ->php("}\n", - 1);
                return null;
                break;
            case 'option':
                $this->compileOption($params, $la);
                break;
            case 'sequence':
                $this->compileSequence($params, $la);
                break;
            case 'whitespace':
                $this->compileWhitespace($params, $la);
                break;
            case 'literal':
                $this->compileLiteral($params, $la);
                break;
            case 'expression':
                $this->compileExpression($params, $la);
                break;
            default:
                //TODO
                return false;
                break;
        }
    }

    /**
     * @param      $params
     * @param bool $la
     */
    public function compileRecurse($params, $la = false)
    {
        $neg = ($la === false) ? '!' : '';
        $tracename = (isset($params['_tag']) && $params['_tag'] !== false) ? $params['_tag'] : $params['_param'];
        $this->php("\$this->parser->addBacktrace(array('{$params['_param']}', ''));\n")
             ->php("\$subres = \$this->parser->matchRule(\$result, '{$params['_param']}', \$error);\n")
             ->php("\$remove = array_pop(\$this->parser->backtrace);\n")
             ->php("if (\$subres) {\n")
             ->indent();
        if($la !== true) {
            $this->php("\$this->parser->successNode(array('{$params['_param']}',  \$subres['_text']));\n");
        }
        $this->compileRuleMatch($params, 'result', 'subres');
        if ($la === false) {
            $this->php("\$valid = false;\n");
        } else {
            $this->php("\$valid = true;\n");
        }
        $this->outdent()
             ->php("} else {\n")
             ->indent();
        if ($la === false) {
            $this->php("\$valid = true;\n");
        } else {
            $this->php("\$valid = false;\n");
        }
        $this->php("\$this->parser->failNode(\$remove);\n")
             ->outdent()
             ->php("}\n");
    }

    /**
     * @param      $params
     * @param bool $la
     */
    public function compileRx(&$params, $la = false)
    {
        $this->index ++;
        $cacheName = "{$params['_name']}{$this->index}";
        $regexp = $params['_param'];
        //       if (isset($params['_actions']['_match'])) {
        $regquo = preg_quote('/?<(\w+)>/', '"');
        preg_match_all('/\?<(\w+)>/', $regexp, $matches);
        //        }
        $regexp = addcslashes($regexp, '"\\');
        $this->php("\$regexp = \"{$regexp}\";\n");
        $hasInitExpression = preg_match('/{(\w+)}/', $regexp);
        $hasExpression = preg_match('/\$(\w+)/', $regexp);
        if ($hasExpression) {
            $this->php("\$regexp = \$this->parser->dynamicRxReplace('{$params['_name']}',\$regexp);\n");
        }
        $matchall = $this->getAttribute($params['_name'], 'matchall');
        if ($matchall && !$hasExpression) {
            $this->php("\$pos = \$this->parser->pos;\n")
                 ->php("if (isset(\$this->parser->regexpCache['{$cacheName}'][\$pos])) {\n", 1)
                 ->php("\$subres = \$this->parser->regexpCache['{$cacheName}'][\$pos];\n")
                 ->outdent()
                 ->php("} else {\n", 1);
            if ($hasInitExpression) {
                $this->php("if (isset(\$this->parser->rxCache['{$cacheName}'])) {\n", 1)
                     ->php("\$regexp = \$this->parser->rxCache['{$cacheName}'];\n")
                     ->outdent()
                     ->php("} else {\n", 1)
                     ->php("\$this->parser->rxCache['{$cacheName}'] = \$regexp = \$this->parser->initRxReplace('{$params['_name']}',\$regexp);\n")
                     ->php("}\n", - 1);
            }
            $this->php("if (empty(\$this->parser->regexpCache['{$cacheName}']) && preg_match_all(\$regexp . 'Sx', \$this->parser->source, \$matches, PREG_OFFSET_CAPTURE+PREG_SET_ORDER, \$pos)) {\n", 1)
                 ->php("\$this->parser->regexpCache['{$cacheName}'][- 1] = true;\n")
                 ->php("foreach (\$matches as  \$match) {\n", 1);
            $this->php("\$subres = array('_silent' => 0, '_text' => \$match[0][0], '_startpos' => \$match[0][1], '_endpos' => \$match[0][1] + strlen(\$match[0][0]), '_matchres' => array());\n");
            if (isset($matches[1][0])) {
                $this->php("foreach (\$match as \$n => \$v) {\n", 1)
                     ->php("if (is_string(\$n) && !empty(\$v[0])) {\n", 1)
                     ->php("\$subres['_matchres'][\$n] = \$v[0];\n")
                     ->php("}\n", - 1)
                     ->php("}\n", - 1);
            }
            $this->php("\$this->parser->regexpCache['{$cacheName}'][\$match[0][1]] = \$subres;\n")
                 ->php("}\n", - 1)
                 ->outdent()
                 ->php("} else {\n", 1)
                 ->php("\$this->parser->regexpCache['{$cacheName}'][- 1] = false;\n")
                 ->php("\$subres = false;\n")
                 ->php("}\n", - 1)
                 ->php("}\n", - 1)
                 ->php("if (isset(\$this->parser->regexpCache['{$cacheName}'][\$pos])) {\n", 1)
                 ->php("\$subres = \$this->parser->regexpCache['{$cacheName}'][\$pos];\n")
                 ->outdent()
                 ->php("} else {\n", 1)
                 ->php("\$this->parser->regexpCache['{$cacheName}'][\$pos] = false;\n")
                 ->php("\$subres = false;\n")
                 ->php("}\n", - 1);
        } else {
            $this->php("\$pos = \$this->parser->pos;\n")
                 ->php("if (isset(\$this->parser->regexpCache['{$cacheName}'][\$pos])) {\n", 1)
                 ->php("\$subres = \$this->parser->regexpCache['{$cacheName}'][\$pos];\n")
                 ->outdent()
                 ->php("} else {\n", 1);
            if ($hasInitExpression) {
                $this->php("if (isset(\$this->parser->rxCache['{$cacheName}'])) {\n", 1)
                     ->php("\$regexp = \$this->parser->rxCache['{$cacheName}'];\n")
                     ->outdent()
                     ->php("} else {\n", 1)
                     ->php("\$this->parser->rxCache['{$cacheName}'] = \$regexp = \$this->parser->initRxReplace('{$params['_name']}',\$regexp);\n")
                     ->php("}\n", - 1);
            }
            $this->php("if (preg_match(\$regexp . 'Sxs', \$this->parser->source, \$match, PREG_OFFSET_CAPTURE, \$pos)) {\n", 1);
            if (isset($matches[1][0])) {
                $this->php("if (strlen(\$match[0][0]) != 0) {\n", 1);
            }
            $this->php("\$subres = array('_silent' => 0, '_text' => \$match[0][0], '_startpos' => \$match[0][1], '_endpos' => \$match[0][1] + strlen(\$match[0][0]), '_matchres' => array());\n");
            if (isset($matches[1][0])) {
                $this->php("foreach (\$match as \$n => \$v) {\n", 1)
                     ->php("if (is_string(\$n) && !empty(\$v[0])) {\n", 1)
                     ->php("\$subres['_matchres'][\$n] = \$v[0];\n")
                     ->php("}\n", - 1)
                     ->php("}\n", - 1);
            }
            $this->php("if (\$subres['_startpos'] != \$pos) {\n", 1)
                 ->php("\$this->parser->regexpCache['{$cacheName}'][\$subres['_startpos']] = \$subres;\n")
                 ->php("\$this->parser->regexpCache['{$cacheName}'][\$pos] = false;\n")
                 ->php("\$subres = false;\n")
                 ->php("}\n", - 1)
                 ->outdent()
                 ->php("} else {\n", 1)
                 ->php("\$this->parser->regexpCache['{$cacheName}'][\$pos] = false;\n")
                 ->php("\$subres = false;\n")
                 ->php("}\n", - 1);
            if (isset($matches[1][0])) {
                $this->outdent()
                     ->php("} else {\n", 1)
                     ->php("\$this->parser->regexpCache['{$cacheName}'][\$pos] = false;\n")
                     ->php("\$subres = false;\n")
                     ->php("}\n", - 1);
            }
            $this->php("}\n", - 1);
        }
        $this->php("if (\$subres) {\n", 1)
             ->php("\$subres['_lineno'] = \$this->parser->line;\n")
             ->php("\$this->parser->pos = \$subres['_endpos'];\n")
             ->php("\$this->parser->line += substr_count(\$subres['_text'], \"\\n\");\n");
        /**
         * if (isset($params['_actions']['_finish'])) {
         * foreach ($params['_actions']['_finish'] as $method => $foo) {
         * $this->php("\$this->{$method}(\$subres);\n")
         * ->php("if (\$subres === false) {\n")
         * ->indent()
         * ->php("\$valid = false;\n")
         * ->outdent()
         * ->php("}\n");
         * }
         * unset($params['_actions']['_finish']);
         * }
         */
        if (isset($params['_tag']) && $params['_tag'] !== false) {
            $this->php("\$subres['_tag'] = '{$params['_tag']}';\n");
        } else {
            $this->php("\$subres['_tag'] = false;\n");
        }
        if (isset($params['_name'])) {
            $this->php("\$subres['_name'] = '{$params['_name']}';\n");
        }
        if (isset($params['_actions']['_match']) && isset($matches[1][0])) {
            foreach ($matches[1] as $match) {
                if (isset($params['_actions']['_match'][$match])) {
                    $this->php("if (isset(\$subres['_matchres']['{$match}'])) {\n", 1);
                    foreach ($params['_actions']['_match'][$match] as $method => $foo) {
                        $this->php("\$this->{$method}(\$result, \$subres);\n");
                    }
                    $this->php("unset(\$subres['_matchres']['{$match}']);\n")
                         ->php("}\n", - 1);
                }
            }
        }
        if (isset($matches[1][0])) {
            $this->php("\$result['_matchres'] = array_merge(\$result['_matchres'], \$subres['_matchres']);\n");
        }
        //        if ($params['_silent'] == 0) {
        //            $this->php("\$result['_text'] .= \$subres['_text'];\n");
        //        }
        if ($la === false) {
            $this->php("\$valid = false;\n");
        } else {
            $this->php("\$valid = true;\n");
        }
        $this->outdent()
             ->php("} else {\n")
             ->indent();
        if ($la === false) {
            $this->php("\$valid = true;\n");
        } else {
            $this->php("\$valid = false;\n");
        }
        $this->outdent()
             ->php("}\n");
    }

    /**
     * @param      $params
     * @param bool $la
     */
    public function compileSequence($params, $la = false)
    {
        $index = $this->index ++;
        $this->php("// start sequence\n")
             ->php("\$backup{$index} = \$result;\n")
             ->php("\$pos{$index} = \$this->parser->pos;\n")
             ->php("\$line{$index} = \$this->parser->line;\n")
             ->php("\$error{$index} = \$error;\n")
        ->php("\$this->parser->addBacktrace(array('_s{$index}_', ''));\n")
             ->php("do {\n")
             ->indent();
        foreach ($params['_param'] as $rule) {
            if (isset($params['_actions'])) {
                $rule['_actions'] = $params['_actions'];
            }
            $rule['_name'] = $params['_name'];
            $this->php("\$error = array();\n");
            $this->compileMatchRule($rule);
            $this->php("if (!\$valid) {\n")
                 ->indent()
                 ->php("\$this->parser->matchError(\$error{$index}, 'SequenceElement', \$error);\n")
                 ->php("\$error = \$error{$index};\n")
                 ->php("break;\n")
                 ->outdent()
                 ->php("}\n");
        }
        $this->php("break;\n")
             ->outdent()
             ->php("} while (true);\n")
            ->php("\$remove = array_pop(\$this->parser->backtrace);\n")
            ->php("if (!\$valid) {\n")
             ->indent()
            ->php("\$this->parser->failNode(\$remove);\n")
             ->php("\$this->parser->pos = \$pos{$index};\n")
             ->php("\$this->parser->line = \$line{$index};\n")
             ->php("\$result = \$backup{$index};\n")
             ->outdent()
             ->php("} else {\n", 1)
             ->php("\$this->parser->successNode(\$remove);\n")
        ->php("}\n")
        ->php("\$error = \$error{$index};\n");
        if ($la === false) {
            $this->php("\$valid = !\$valid;\n");
        }

        if ($params['_tag']) {
            $this->php("if (\$valid) {\n")
                 ->indent();
            $this->compileRuleMatch($params, "backup{$index}", 'result');
            $this->outdent()
                 ->php("}\n")
                 ->php("\$result = \$backup{$index};\n");
        }
        $this->php("unset(\$backup{$index});\n");
        $this->php("// end sequence\n");
    }

    /**
     * @param      $params
     * @param bool $la
     */
    public function compileOption($params, $la = false)
    {
        $this->php("// start option\n");
        $index = $this->index ++;
        $this->php("\$error{$index} = \$error;\n");
        $this->php("\$errorOption{$index} =array();\n")
        ->php("\$this->parser->addBacktrace(array('_o{$index}_', ''));\n")
        ->php("do {\n")
             ->indent();
        $i = 0;
        foreach ($params['_param'] as $rule) {
            if (isset($params['_actions'])) {
                $rule['_actions'] = $params['_actions'];
            }
            $i++;
            $rule['_name'] = $params['_name'];
            $this->php("\$error = array();\n")
                ->php("array_pop(\$this->parser->backtrace);\n")
                ->php("\$this->parser->addBacktrace(array('_o{$index}:{$i}_', ''));\n");
            $this->compileMatchRule($rule);
            $this->php("if (\$valid) {\n")
                 ->indent()
                ->php("\$this->parser->successNode(array_pop(\$this->parser->backtrace));\n");

            if ($la === false) {
                $this->php("\$this->parser->shouldNotMatchError(\$error{$index}, '{$params['_name']}', \$error;\n;");
            }
            $this->php("\$error = \$error{$index};\n");
            $this->php("break;\n")
                 ->outdent()
                 ->php("} else {\n", 1)
                 ->php("\$this->parser->logOption(\$errorOption{$index}, '{$params['_name']}', \$error);\n")
                 ->php("}\n", - 1);
        }
        $this->php("\$error = \$error{$index};\n");
        if ($la === false) {
            $this->php("\$this->parser->matchError(\$error, 'Option', \$errorOption{$index});\n");
        }
        $this->php("array_pop(\$this->parser->backtrace);\n");
        $this->php("break;\n");
        $this->outdent()
             ->php("} while (true);\n");
        if ($la === false) {
            $this->php("\$valid = !\$valid;\n");
        }
        //        $this->php("unset(\$error{$index}, \$errorOption{$index});\n");
        $this->php("// end option\n");
    }

    /**
     * @param      $params
     * @param bool $la
     */
    public function compileWhitespace($params, $la = false)
    {
        $this->php("if (preg_match(\$this->parser->whitespacePattern, \$this->parser->source, \$match, 0, \$this->parser->pos)) {\n")
             ->indent()
             ->php("if (!empty(\$match[0])) {\n", 1)
             ->php("\$this->parser->pos += strlen(\$match[0]);\n")
             ->php("\$this->parser->line += substr_count(\$match[0], \"\\n\");\n");
        if ($params['_silent'] == 0) {
            $this->php("\$result['_text'] .= ' ';\n");
        }
        if (!$params['_param']) {
            $this->php("\$valid = true;\n");
            $this->outdent()
                 ->php("} else {\n")
                 ->indent()
                 ->php("\$valid = false;\n")
                 ->outdent()
                 ->php("}\n")
                 ->outdent()
                 ->php("} else {\n")
                 ->indent()
                 ->php("\$valid = false;\n")
                 ->outdent()
                 ->php("}\n");
            $this->php("if (\$valid) {\n", 1)
                 ->php("\$this->parser->successNode(array(\"' '\",  ' '));\n");
            if ($la === false) {
                $this->php("\$this->parser->shouldNotMatchError(\$error, 'whitespace');\n");
            }
            $this->outdent()
                 ->php("} else {\n")
                 ->php("\$this->parser->failNode(array(\"' '\",  ''));\n");
            if ($la === false) {
                $this->php("\$this->parser->matchError(\$error, 'whitespace');\n");
            }
            $this->php("}\n", - 1);
            if ($la === false) {
                $this->php("\$valid = !\$valid;\n");
            }
        } else {

            $this->outdent()
                 ->php("}\n")
                 ->outdent()
                 ->php("}\n")
                 ->php("\$this->parser->successNode(array(\"' '\",  \$match[0]));\n")
                 ->php("\$valid = true;\n");
        }
    }

    /**
     * @param      $params
     * @param bool $la
     */
    public function compileLiteral($params, $la = false)
    {
        $len = strlen($params['_param']);
        $this->php("if ('{$params['_param']}' == substr(\$this->parser->source, \$this->parser->pos, {$len})) {\n")
             ->indent()
             ->php("\$this->parser->pos += {$len};\n");
        if ($params['_silent'] == 0) {
            $this->php("\$result['_text'] .= '{$params['_param']}';\n");
        }
        if (isset($params['_actions']['_match'])) {
            $type = (isset($params['_tag']) && $params['_tag'] !== false) ? $params['_tag'] : $params['_name'];
            if (isset($params['_actions']['_match'][$type])) {
                foreach ($params['_actions']['_match'][$type] as $method => $foo) {
                    $this->php("\$this->{$method}(\$result, null);\n");
                }
            }
        }
        $this->php("\$this->parser->successNode(array('\\'{$params['_param']}\\'', '{$params['_param']}'));\n");
        if ($la === false) {
            $this->php("\$this->parser->shouldNotMatchError(\$error, 'literal', '{$params['_param']}');\n");
        }
        $result = ($la === false) ? 'false' : 'true';
        $this->php("\$valid = {$result};\n");
        $this->outdent()
             ->php("} else {\n")
             ->indent();
        if (!($la === false)) {
            $this->php("\$this->parser->matchError(\$error, 'literal', '{$params['_param']}');\n");
        }
        $this->php("\$this->parser->failNode(array('\\'{$params['_param']}\\'',  ''));\n");
        $result = ($la === false) ? 'true' : 'false';
        $this->php("\$valid = {$result};\n");
        $this->outdent()
             ->php("}\n");
    }

    /**
     * @param      $params
     * @param bool $la
     */
    public function compileExpression($params, $la = false)
    {
        $this->php("\$subres = \$result;\n")
             ->php("\$this->parser->addBacktrace(array('{$params['_name']}', ''));\n")
             ->php("\$valid = false;\n")
             ->php("\$method = '{$params['_name']}_EXP_{$params['_param']}';\n")
             ->php("\$valid = \$this->\$method(\$subres);\n")
             ->php("\$remove = array_pop(\$this->parser->backtrace);\n");
        if (isset($params['_actions']['_finish'])) {
            $this->php("if (\$valid) {\n")
                 ->indent();
            foreach ($params['_actions']['_finish'] as $method => $foo) {
                $this->php("\$this->{$method}(\$subres);\n")
                     ->php("if (\$subres === false) {\n")
                     ->indent()
                     ->php("\$valid = false;\n")
                     ->outdent()
                     ->php("}\n");
            }
            $this->outdent()
                 ->php("}\n");
        }
        $this->php("if (\$valid) {\n")
             ->indent()
             ->php("\$this->parser->successNode(\$remove);\n");
        $this->compileRuleMatch($params, 'result', 'subres');
        $this->outdent()
             ->php("} else {\n")
             ->indent()
             ->php("\$this->parser->matchError(\$error, 'expression', '{$params['_name']}');\n")
             ->php("\$this->parser->failNode(\$remove);\n")
             ->outdent()
             ->php("}\n");
    }

    /**
     * @param $params
     * @param $result
     * @param $subres
     */
    public function compileRuleMatch($params, $result, $subres)
    {
        if ($params['_silent'] == 0) {
            $this->php("\${$result}['_text'] .= \${$subres}['_text'];\n");
        }
        if (isset($params['_actions']['_match'])) {
            $type = (isset($params['_tag']) && $params['_tag'] !== false) ? $params['_tag'] : $params['_name'];
            if (isset($params['_actions']['_match'][$type])) {
                foreach ($params['_actions']['_match'][$type] as $method => $foo) {
                    $this->php("\$this->{$method}(\${$result}, \${$subres});\n");
                }
                return;
            }
        }
        if (isset($params['_actions']['_all'])) {
            foreach ($params['_actions']['_all'] as $method => $foo) {
                $this->php("\$this->{$method}(\${$result}, \${$subres});\n");
            }
            return;
        }
        if (isset($params['_tag']) && $params['_tag'] !== false) {
            $tag = $params['_tag'];
            $this->php("if(!isset(\${$result}['{$tag}'])) {\n")
                 ->indent()
                 ->php("\${$result}['{$tag}'] = \${$subres};\n")
                 ->outdent()
                 ->php("} else {\n")
                 ->indent()
                 ->php("if (!is_array(\${$result}['{$tag}'])) {\n")
                 ->indent()
                 ->php("\${$result}['{$tag}'] = array(\${$result}['{$tag}']);\n")
                 ->outdent()
                 ->php("}\n")
                 ->php("\${$result}['{$tag}'][] = \${$subres};\n")
                 ->outdent()
                 ->php("}\n");
        }
    }

    /**
     * Build rule parameter array
     *
     * @param array $rule rule array
     *
     * @return array
     */
    public function buildParams($rule)
    {
        $param = array();
        $param['_pla'] = isset($rule['_pla']) ? $rule['_pla'] : false;
        $param['_nla'] = isset($rule['_nla']) ? $rule['_nla'] : false;
        $param['_min'] = array_key_exists('_min', $rule) ? $rule['_min'] : 1;
        $param['_max'] = array_key_exists('_max', $rule) ? $rule['_max'] : 1;
        $param['_tag'] = isset($rule['_tag']) ? $rule['_tag'] : false;
        $param['_silent'] = isset($rule['_silent']) ? $rule['_silent'] : 0;
        if (isset($rule['_type'])) {
            $param['_type'] = $rule['_type'];
        }
        if (isset($rule['_name'])) {
            $param['_name'] = $rule['_name'];
        }
        if (isset($rule['_param'])) {
            $param['_param'] = $rule['_param'];
        }
        if (isset($rule['_ruleParser'])) {
            $param['_ruleParser'] = $rule['_ruleParser'];
        }
        if (isset($rule['_actions'])) {
            $param['_actions'] = $rule['_actions'];
        }
        if (isset($rule['_attr'])) {
            $param['_attr'] = $rule['_attr'];
        }
        if (isset($rule['_tagcomment'])) {
            $param['_tagcomment'] = $rule['_tagcomment'];
        }
        $param['_loop'] = ($param['_min'] != 0 && $param['_min'] != 1) || $param['_max'] != 1;
        return $param;
    }

    /**
     * @param $rule
     * @param $attribute
     *
     * @return bool
     */
    public function getAttribute($rule, $attribute)
    {
        return isset($this->nodeAttributes[$rule][$attribute]) ? $this->nodeAttributes[$rule][$attribute] : false;
    }

    /**
     * Outdents the generated code.
     *
     * @param integer $step The number of indentation to remove
     *
     * @throws SmartyException
     * @return object          the current instance
     */
    public function outdent($step = 1)
    {
        // can't outdent by more steps that the current indentation level
        if ($this->indentation < $step) {
            //throw new SmartyException('Unable to call outdent() as the indentation would become negative');
        } else {
            $this->indentation -= $step;
        }
        return $this;
    }

    /**
     * Format and add aPHP code block to current buffer.
     *
     * @param  string $value PHP source to format
     *
     * @return object the current instance
     */
    public function formatPHP($value)
    {
        $save = $this->indent_on;
        $this->indent_on = true;
        preg_replace_callback('%(\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|"[^"\\\\]*(?:\\\\.[^"\\\\]*)*")|([\r\n\t ]*(\?>|<\?php)[\r\n\t ]*)|(;[\r\n\t ]*)|({[\r\n\t ]*)|([\r\n\t ]*}[\r\n\t ]*)|([\r\n\t ]*)|([\r\n\t ]*/\*(.*)?\*/[\r\n\t ]*)|(.*?(?=[\'";{}/\n]))%', array($this, '_processPHPoutput'), $value);
        $this->output .= "\n";
        $this->indent_on = $save;

        return $this;
    }

    /**
     * Enable indentation
     *
     * @return object the current instance
     */
    public function indent_on()
    {
        $this->indent_on = true;

        return $this;
    }

    /**
     * Enable indentation
     *
     * @return object the current instance
     */
    public function indent_off()
    {
        $this->indent_on = false;

        return $this;
    }

    /**
     * Adds the PHP representation of a given value to the current buffer
     *
     * @param  mixed $value        The value to convert
     * @param  bool  $double_qoute flag to use double quotes on strings
     *
     * @return object the current instance
     */
    public function repr($value, $double_qoute = true)
    {
        if (is_int($value) || is_float($value)) {
            if (false !== $locale = setlocale(LC_NUMERIC, 0)) {
                setlocale(LC_NUMERIC, 'C');
            }

            $this->raw($value);

            if (false !== $locale) {
                setlocale(LC_NUMERIC, $locale);
            }
        } elseif (null === $value) {
            $this->raw('null');
        } elseif (is_bool($value)) {
            $this->raw($value ? 'true' : 'false');
        } elseif (is_array($value)) {
            $this->raw("array(\n")
                 ->indent(2)
                 ->addIndentation();
            $i = 0;
            foreach ($value as $key => $val) {
                if ($i ++) {
                    $this->raw(",\n")
                         ->addIndentation();
                }
                $this->repr($key, $double_qoute);
                $this->raw(' => ');
                $this->repr($val, $double_qoute);
            }
            $this->outdent()
                 ->raw("\n")
                 ->addIndentation()
                 ->raw(')')
                 ->outdent();
        } else {
            $this->string($value, $double_qoute);
        }

        return $this;
    }

    /**
     * Adds a raw string to the compiled code.
     *
     * @param  string $string The string
     *
     * @return object the current instance
     */
    public function raw($string)
    {
        $this->output .= $string;

        return $this;
    }

    /**
     * Adds a quoted string to the compiled code.
     *
     * @param string $value        The string
     * @param bool   $double_quote flag if double quotes shall be used
     *
     * @return object the current instance
     */
    public function string($value, $double_quote = true)
    {
        $length = strlen($value);
        if ($length <= 1000) {
            if ($double_quote) {
                $this->output .= sprintf('"%s"', addcslashes($value, "\0\n\r\t\"\$\\"));
            } else {
                $this->output .= "'" . $value . "'";
            }
        } else {
            $i = 0;
            while (true) {
                if ($double_quote) {
                    $this->output .= sprintf('"%s"', addcslashes(substr($value, $i, 1000), "\0\n\r\t\"\$\\"));
                } else {
                    $this->output .= "'" . substr($value, $i, 1000) . "'";
                }
                if ($i == 0) {
                    $this->indent();
                }
                $i += 1000;
                if ($i >= $length) {
                    $this->outdent();
                    break;
                }
                $this->raw("\n")
                     ->addIndentation()
                     ->raw(', ');
            }
        }

        return $this;
    }

    /**
     * Indents the generated code.
     *
     * @param  integer $step The number of indentation to add
     *
     * @return object  the current instance
     */
    public function indent($step = 1)
    {
        $this->indentation += $step;

        return $this;
    }

    /**
     * preg_replace callback function to process PHP output
     *
     * @param  string $match match string
     *
     * @return string replacement
     */
    public function _processPHPoutput($match)
    {
        if (empty($match[0]) || !empty($match[2])) {
            return;
        }
        if ($this->indent_on) {
            $this->raw("\n");
        }
        if (!empty($match[7])) {
            return;
        }
        if (!empty($match[1])) {
            $this->raw($match[1]);

            return;
        }
        if (!empty($match[4])) {
            $this->raw(";");
            $this->indent_on = true;

            return;
        }
        if (!empty($match[5])) {
            $this->raw("{")
                 ->indent();
            $this->indent_on = true;

            return;
        }
        if (!empty($match[6])) {
            if (!$this->indent_on) {
                $this->raw("\n");
                $this->indent_on = true;
            }
            $this->outdent()
                 ->addIndentation()
                 ->raw('}');

            return;
        }
        if (!empty($match[9])) {
            $this->addIndentation()
                 ->raw("/*{$match[9]}*/");

            return;
        }
        if (!empty($match[10])) {
            if ($this->indent_on) {
                $this->addIndentation();
            }
            $this->raw($match[10]);
            $this->indent_on = false;

            return;
        }

        return;
    }
}

