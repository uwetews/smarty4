<?php

Namespace Smarty\Tool\Parser\Peg\Nodes;

/**
 * Class Pegparser
 *
 * @package Smarty\Tool\Parser\Peg\Nodes
 */
class Pegparser
{
    public $_name = 'Parser';
    public $_type = 'parser';
    public $nodes = array();
    public $actions = array();
    public $comments = array();
    public $output = '';
    public $indentation = 1;
    public $saved_indentation = 0;
    public $indent_on = true;
    public $no_indent = false;
    public $index = 0;
    public $nodeAttributes = array();

    /**
     * @return string
     * @throws SmartyException
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

    public function compileMatchNode($rule)
    {
        $this->index = 0;
        $this->php("public function matchNode{$rule['_name']}(\$previous){\n")
             ->indent()
             ->php("\$result = \$this->parser->resultDefault;\n")
             ->php("\$pos0 = \$result['_startpos'] = \$result['_endpos'] = \$this->parser->pos;\n")
             ->php("\$result['_lineno'] = \$this->parser->line;\n");
        $hash = $this->getAttribute($rule['_name'], 'hash');
        if ($hash) {
            $this->php("if (isset(\$this->parser->packCache[\$this->parser->pos]['{$rule['_name']}'])) {\n", 1)
                 ->php("\$result = \$this->parser->packCache[\$this->parser->pos]['{$rule['_name']}'];\n")
                 ->php("if (\$result) {\n", 1)
                 ->php("\$this->parser->pos = \$result['_endpos'];\n")
                 ->php("\$this->parser->line = \$result['_endline'];\n")
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
             ->php("}\n", - 1);
        if ($hash) {
            $this->php("\$this->parser->packCache[\$pos0]['{$rule['_name']}'] = \$result;\n");
        }
        $this->php("return \$result;\n")
             ->php("}\n", - 1);
    }

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
        if ($params['_pla']) {
            $comment .= " positive lookahead";
        }
        if ($params['_nla']) {
            $comment .= " negative lookahead";
        }
        $comment .= "\n";
        $this->php($comment);
        $index = $this->index ++;
        if ($params['_pla'] || $params['_nla']) {
            $this->php("\$backup{$index} = \$result;\n")
                 ->php("\$pos{$index} = \$this->parser->pos;\n")
                 ->php("\$line{$index} = \$this->parser->line;\n");
        }
        if ($params['_loop']) {
            $this->php("\$iteration{$index} = 0;\n")
                 ->php("do {\n")
                 ->indent();
        }
        //        $neg = $params['_nla'] ? '!' : '';
        $this->compileToken($params, $params['_nla']);
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
            $this->php("\$valid = true;\n");
        }
        $this->php("// End '{$com}'\n");
    }

    public function compileToken(&$params, $negate = false)
    {
        switch ($params['_type']) {
            case 'recurse':
                return $this->compileRecurse($params, $negate);
                break;
            case 'rx':
                $this->compileRx($params, $negate);
                $this->php("if (\$valid) {\n",1);
                $this->compileRuleMatch($params, 'result', 'subres');
                $this->php("}\n",-1);
                return;
                break;
            case 'option':
                return $this->compileOption($params, $negate);
                break;
            case 'sequence':
                return $this->compileSequence($params, $negate);
                break;
            case 'whitespace':
                return $this->compileWhitespace($params, $negate);
                break;
            case 'literal':
                return $this->compileLiteral($params, $negate);
                break;
            case 'expression':
                return $this->compileExpression($params, $negate);
                break;
            default:
                //TODO
                return false;
                break;
        }
    }

    public function compileRecurse($params, $negate = false)
    {
        $neg = $negate ? '!' : '';
        $tracename = (isset($params['_tag']) && $params['_tag'] !== false) ? $params['_tag'] : $params['_param'];
        $this->php("\$this->parser->addBacktrace(array('{$params['_param']}', \$result));\n")
             ->php("\$subres = \$this->parser->matchRule(\$result, '{$params['_param']}');\n")
             ->php("\$remove = array_pop(\$this->parser->backtrace);\n")
             ->php("if (\$subres) {\n")
             ->indent()
             ->php("\$this->parser->successNode(array('{$params['_param']}',  \$subres));\n");
        $this->compileRuleMatch($params, 'result', 'subres');
        if ($negate) {
            $this->php("\$valid = false;\n");
        } else {
            $this->php("\$valid = true;\n");
        }
        $this->outdent()
             ->php("} else {\n")
             ->indent();
        if ($negate) {
            $this->php("\$valid = true;\n");
        } else {
            $this->php("\$valid = false;\n");
        }
        $this->php("\$this->parser->failNode(\$remove);\n")
             ->outdent()
             ->php("}\n");
    }

    public function compileRx(&$params, $negate = false)
    {
        $this->index++;
        $cacheName = "{$params['_name']}{$this->index}";
        $regexp = $params['_param'];
 //       if (isset($params['_actions']['_match'])) {
            $regquo = preg_quote('/?<(\w+)>/', '"');
            preg_match_all('/\?<(\w+)>/', $regexp, $matches);
//        }
        //$regexp = preg_quote($regexp, '"');
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
            $this->php("if (empty(\$this->parser->regexpCache['{$cacheName}']) && preg_match_all(\$regexp . 'Sx', \$this->parser->source, \$matches, PREG_OFFSET_CAPTURE, \$pos)) {\n", 1)
                 ->php("\$this->parser->regexpCache['{$cacheName}'][- 1] = true;\n")
                 ->php("foreach (\$matches[0] as \$match) {\n", 1)
                 ->php("\$subres = array('_silent' => 0, '_text' => \$match[0], '_startpos' => \$match[1], '_endpos' => \$match[1] + strlen(\$match[0]));\n")
                 ->php("foreach (\$match as \$n => \$v) {\n", 1)
                 ->php("if (is_string(\$n)) {\n", 1)
                 ->php("\$subres['_matchres'][\$n] = \$v[0];\n")
                 ->php("}\n", - 1)
                 ->php("}\n", - 1)
                 ->php("\$this->parser->regexpCache['{$cacheName}'][\$match[1]] = \$subres;\n")
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
            $this->php("if (preg_match(\$regexp . 'Sxs', \$this->parser->source, \$match, PREG_OFFSET_CAPTURE, \$pos)) {\n", 1)
                 ->php("\$subres = array('_silent' => 0, '_text' => \$match[0][0], '_startpos' => \$match[0][1], '_endpos' => \$match[0][1] + strlen(\$match[0][0]));\n")
                 ->php("foreach (\$match as \$n => \$v) {\n", 1)
                 ->php("if (is_string(\$n)) {\n", 1)
                 ->php("\$subres['_matchres'][\$n] = \$v[0];\n")
                 ->php("}\n", - 1)
                 ->php("}\n", - 1)
                 ->php("if (\$subres['_startpos'] != \$pos) {\n", 1)
                 ->php("\$this->parser->regexpCache['{$cacheName}'][\$subres['_startpos']] = \$subres;\n")
                 ->php("\$this->parser->regexpCache['{$cacheName}'][\$pos] = false;\n")
                 ->php("\$subres = false;\n")
                 ->php("}\n", - 1)
                 ->outdent()
                 ->php("} else {\n", 1)
                 ->php("\$this->parser->regexpCache['{$cacheName}'][\$pos] = false;\n")
                 ->php("\$subres = false;\n")
                 ->php("}\n", - 1)
                 ->php("}\n", - 1);
        }
        $this->php("if (\$subres) {\n", 1)
            ->php("\$subres['_lineno'] = \$this->parser->line;\n")
            ->php("\$this->parser->pos = \$subres['_endpos'];\n")
             ->php("\$this->parser->line += substr_count(\$subres['_text'], \"\\n\");\n");
/**
        if (isset($params['_actions']['_finish'])) {
             foreach ($params['_actions']['_finish'] as $method => $foo) {
                $this->php("\$this->{$method}(\$subres);\n")
                     ->php("if (\$subres === false) {\n")
                     ->indent()
                     ->php("\$valid = false;\n")
                     ->outdent()
                     ->php("}\n");
            }
            unset($params['_actions']['_finish']);
        }
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
                    $this->php("if (isset(\$subres['_matchres']['{$match}'])) {\n",1);
                    foreach ($params['_actions']['_match'][$match] as $method => $foo) {
                        $this->php("\$this->{$method}(\$result, \$subres);\n");
                    }
                    $this->php("}\n",-1);
                }
            }
        }
//        if ($params['_silent'] == 0) {
//            $this->php("\$result['_text'] .= \$subres['_text'];\n");
//        }
        if ($negate) {
            $this->php("\$valid = false;\n");
        } else {
            $this->php("\$valid = true;\n");
        }
        $this->outdent()
             ->php("} else {\n")
             ->indent();
        if ($negate) {
            $this->php("\$valid = true;\n");
        } else {
            $this->php("\$valid = false;\n");
        }
        $this->outdent()
             ->php("}\n");
    }

    public function compileSequence($params, $negate = false)
    {
        $index = $this->index ++;
        $this->php("// start sequence\n")
             ->php("\$backup{$index} = \$result;\n")
             ->php("\$pos{$index} = \$this->parser->pos;\n")
             ->php("\$line{$index} = \$this->parser->line;\n")
             ->php("do {\n")
             ->indent();
        foreach ($params['_param'] as $rule) {
            if (isset($params['_actions'])) {
                $rule['_actions'] = $params['_actions'];
            }
            $rule['_name'] = $params['_name'];
            $this->compileMatchRule($rule);
            $this->php("if (!\$valid) {\n")
                 ->indent()
                 ->php("break;\n")
                 ->outdent()
                 ->php("}\n");
        }
        $this->php("break;\n")
             ->outdent()
             ->php("} while (true);\n")
             ->php("if (!\$valid) {\n")
             ->indent()
             ->php("\$this->parser->pos = \$pos{$index};\n")
             ->php("\$this->parser->line = \$line{$index};\n")
             ->php("\$result = \$backup{$index};\n")
             ->outdent()
             ->php("}\n");
        if ($negate) {
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

    public function compileOption($params, $negate = false)
    {
        $this->php("// start option\n");
        //        $index = $this->index ++;
        //        $this->php("\$backup{$index} = \$result;\n");
        //        $this->php("\$pos{$index} = \$this->parser->pos;\n");
        //        $this->php("\$line{$index} = \$this->parser->line;\n");
        $this->php("do {\n")
             ->indent();
        foreach ($params['_param'] as $rule) {
            if (isset($params['_actions'])) {
                $rule['_actions'] = $params['_actions'];
            }
            $rule['_name'] = $params['_name'];
            $this->compileMatchRule($rule);
            $this->php("if (\$valid) {\n")
                 ->indent()
                 ->php("break;\n")
                 ->outdent()
                 ->php("}\n");
        }
        $this->php("break;\n");
        $this->outdent()
             ->php("} while (true);\n");
        //        $this->php("if (!\$valid) {\n")
        //            ->indent()
        //            ->php("\$this->parser->pos = \$pos{$index};\n")
        //            ->php("\$this->parser->line = \$line{$index};\n")
        //            ->php("\$result = \$backup{$index};\n")
        //            ->outdent()
        //            ->php("}\n");
        if ($negate) {
            $this->php("\$valid = !\$valid;\n");
        }
        //        $this->php("unset(\$backup{$index});\n");
        $this->php("// end option\n");
    }

    public function compileWhitespace($params, $negate = false)
    {
        $this->php("if (preg_match(\$this->parser->whitespacePattern, \$this->parser->source, \$match, 0, \$this->parser->pos)) {\n")
             ->indent()
             ->php("\$this->parser->pos += strlen(\$match[0]);\n")
             ->php("\$this->parser->line += substr_count(\$match[0], \"\\n\");\n");
        if ($params['_silent'] == 0) {
            $this->php("\$result['_text'] .= ' ';\n");
        }
        if ($params['_param']) {
            $this->outdent()
                 ->php("}\n")
                 ->php("\$valid = true;\n");
        } else {
            $this->php("\$valid = true;\n")
                 ->outdent()
                 ->php("} else {\n")
                 ->indent()
                 ->php("\$valid = false;\n")
                 ->outdent()
                 ->php("}\n");
        }
    }

    public function compileLiteral($params, $negate = false)
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
        $this->php("\$this->parser->successLiteral('{$params['_param']}');\n");
        $result = $negate ? 'false' : 'true';
        $this->php("\$valid = {$result};\n");
        $this->outdent()
             ->php("} else {\n")
             ->indent();
        $this->php("\$this->parser->failLiteral('{$params['_param']}');\n");
        $result = $negate ? 'true' : 'false';
        $this->php("\$valid = {$result};\n");
        $this->outdent()
             ->php("}\n");
    }

    public function compileExpression($params, $negate = false)
    {
        $this->php("\$subres = \$result;\n")
             ->php("\$this->parser->addBacktrace(array('{$params['_name']}', \$result));\n")
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
             ->php("\$this->parser->successNode(array('{$params['_name']}', \$subres));\n");
        $this->compileRuleMatch($params, 'result', 'subres');
        $this->outdent()
             ->php("} else {\n")
             ->indent()
             ->php("\$this->parser->failNode(\$remove);\n")
             ->outdent()
             ->php("}\n");
    }

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
            throw new SmartyException('Unable to call outdent() as the indentation would become negative');
        }
        $this->indentation -= $step;

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

