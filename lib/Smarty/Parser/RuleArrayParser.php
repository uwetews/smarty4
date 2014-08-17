<?php

namespace Smarty\Parser;

use Smarty\Exception\Magic;
use Smarty\Parser\Rules\RxMatchOld;
use Smarty\Parser\Exception\NoRule;
use Smarty\Parser;

/**
 * Class RuleArrayParser
 *
 * @package Smarty
 */
class RuleArrayParser
{
    /**
     * Parser object
     *
     * @var Parser
     */
    private $parser = null;

    /**
     * Index for temporary variables
     *
     * @var int
     */
    private $index = 0;

    /**
     * Constructor
     *
     * @param Parser $parser
     */
    function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Get rule definition as array
     *
     * @param  string $ruleName rule name
     *
     * @throws Exception\NoRule
     * @return mixed
     */
    public function getRuleAsArray($ruleName)
    {
        $pegParser = $this->parser->getPegParser($ruleName);
        if (isset($this->parser->rules[$ruleName])) {
            $rule = $this->parser->rules[$ruleName];
        } else {
            throw new NoRule($ruleName, 0, $this->parser->context);
        }
        if (is_array($rule)) {
            $rule['_ruleParser'] = $pegParser;
        } else {
            $rule = $rule->parser->rules[$ruleName];
            $rule['_ruleParser'] = $this->parser->rules[$ruleName];
        }
        return $rule;
    }

    /**
     * Match token rule
     *
     * @param        $result
     * @param string $ruleName    rule name
     * @param array  $errorResult error array
     *
     * @throws Exception\NoRule
     * @internal param array $previous previous result array
     * @return bool|array  result array or false if match failed
     */
    public function matchArrayRule(&$result, $ruleName, &$errorResult)
    {
        $this->index = 0;
        $rule = $this->buildParams($this->getRuleAsArray($ruleName));
        $this->parser->addBacktrace(array($ruleName, ''));
        $error = array();
        // TODO  get hash attribute
        //$hash = $this->parser->getAttribute($rule['_name'], 'hash');
        $hash = false;
        $wasHashed = false;
        if ($hash) {
            if (isset($this->parser->packCache[$this->parser->pos][$rule['_name']])) {
                $wasHashed = true;
                $subres = $this->parser->packCache[$this->parser->pos][$rule['_name']];
                $error = $this->parser->errorCache[$this->parser->pos][$rule['_name']];
                if ($subres) {
                    $this->parser->pos = $subres['_endpos'];
                    $this->parser->line = $subres['_endline'];
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->matchError($errorResult, 'token', $error, $rule['_name']);
                }
            }
        }
        if (!$wasHashed) {
            $subres = $this->parser->resultDefault;
            if (isset($result['node'])) {
                $subres['node'] = $result['node'];
            }
            $pos0 = $subres['_startpos'] = $subres['_endpos'] = $this->parser->pos;
            $subres['_lineno'] = $this->parser->line;
            if (isset($rule['_actions']['_start'])) {
                foreach ($rule['_actions']['_start'] as $method => $foo) {
                    $rule['_ruleParser']->{$method}($subres, $result);
                }
            }

            if (isset($rule['_actions'])) {
                $subres['_actions'] = $rule['_actions'];
                $subres['_ruleParser'] = $rule['_ruleParser'];
            }
            $valid = $this->matchArrayToken($subres, $rule, $error);
            if ($valid) {
                $subres['_endpos'] = $this->parser->pos;
                $subres['_endline'] = $this->parser->line;
                if (isset($rule['_actions']['_finish'])) {
                    foreach ($rule['_actions']['_finish'] as $method => $foo) {
                        if ($result !== false) {
                            $rule['_ruleParser']->{$method}($subres);
                        }
                    }
                }
            } else {
                $subres = false;
            }
            if ($hash) {
                $this->parser->packCache[$pos0][$rule['_name']] = $subres;
                $this->parser->errorCache[$pos0][$rule['_name']] = $error;
            }
        }
        $remove = array_pop($this->parser->backtrace);
        if ($valid) {
            if (!$rule['_pla']) {
                $this->parser->successNode(array($ruleName, $subres['_text']));
            }
            $this->ruleArrayAction($result, $subres);
            if ($rule['_nla']) {
                $valid = false;
            } else {
                $valid = true;
            }
        } else {
            if ($rule['_nla']) {
                $valid = true;
            } else {
                $valid = false;
            }
            $this->parser->failNode($remove);
            $this->parser->matchError($errorResult, 'token', $error, $ruleName);
        }
        return ($valid) ? $result : false;
    }

    /**
     * Match token rule observing all parameter
     *
     * @param array $result result array
     * @param array $rule   rule parameter array
     * @param array $error  error array
     *
     * @return bool
     */
    public function matchArrayToken(&$result, $rule, &$error)
    {
        $index = $this->index ++;
        if ($rule['_pla'] || $rule['_nla']) {
            $backup = $result;
            $pos = $this->parser->pos;
            $line = $this->parser->line;
        } else {
            if ($rule['_min'] == 0 && $rule['_max'] == 1) {
                $error = array();
            }
        }
        $iteration = 0;
        do {
            switch ($rule['_type']) {
                case 'recurse':
                    if ($subres = $this->parser->matchRule($result, $rule['_param'], $error)) {
                        $result = array_merge($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                    }
                    //                    $valid =  $this->matchArrayRecurse($result, $rule, $error);
                    break;
                case 'rx':
                    $rx = isset($this->parser->rxCache[$rule['_param']]) ? $this->parser->rxCache[$rule['_param']] : $this->parser->rxCache[$rule['_param']] = new RxMatchOld($rule, $this->parser, $this);
                    $valid = $rx->matchRx($result, $rule);
                    break;
                case 'option':
                    $valid = $this->matchArrayOption($result, $rule, $error);
                    break;
                case 'sequence':
                    $valid = $this->matchArraySequence($result, $rule, $error);
                    break;
                case 'whitespace':
                    $valid = $this->matchArrayWhitespace($result, $rule, $error);
                    break;
                case 'literal':
                    $valid = $this->matchArrayLiteral($result, $rule, $error);
                    break;
                case 'expression':
                    $valid = $this->matchArrayExpression($result, $rule, $error);
                    break;
                default:
                    //TODO
                    $valid = false;
                    break;
            }
            //        $this->php("\$valid = {$neg}\$this->parser->matchToken(\$result, \$rule);\n");
            if ($rule['_pla'] || $rule['_nla']) {
                $this->parser->pos = $pos;
                $this->parser->line = $line;
                $result = $backup;
                unset($backup);
            } else {
                //$this->php("\$result['_endpos'] = \$this->parser->pos;\n");
            }
            if ($rule['_loop']) {
                $iteration = $valid ? ($iteration + 1) : $iteration;
                if ($rule['_max'] !== null) {
                    if ($valid && $iteration == $rule['_max']) {
                        break;
                    }
                }
                if (!$valid && $iteration >= $rule['_min']) {
                    $valid = true;
                    break;
                }
                if (!$valid) {
                    break;
                }
            } else {
                break;
            }
        } while (true);

        if ($rule['_min'] == 0 && $rule['_max'] == 1) {
            if (!($rule['_pla'] || $rule['_nla'])) {
                if (!$valid) {
                    $this->parser->logOption($errorResult, $rule['_name'], $error);
                }
            }
            $valid = true;
        }
        return $valid;
    }

    /**
     * Match Token by its node name
     *     *
     *
     * @param array $result result array
     * @param array $rule   rule parameter array
     * @param array $error  error array
     *
     * @return bool result of match
     */
    public function matchArrayRecurse(&$result, $rule, &$error)
    {

        $this->parser->addBacktrace(array($rule['_param'], ''));
        $subres = $this->parser->matchRule($result, $rule['_param'], $error);
        $remove = array_pop($this->parser->backtrace);
        if ($subres) {
            if (!$rule['_pla']) {
                $this->parser->successNode(array($rule['_param'], $subres['_text']));
            }
            $this->ruleArrayAction($result, $subres);
            if ($rule['_nla']) {
                $valid = false;
            } else {
                $valid = true;
            }
        } else {
            if ($rule['_nla']) {
                $valid = true;
            } else {
                $valid = false;
            }
            $this->parser->failNode($remove);
        }
        return $valid;
    }

    /**
     * Match Token by its node name
     *     *
     *
     * @param array $result result array
     * @param array $rule   rule parameter array
     * @param array $error  error array
     *
     * @return bool result of match
     */
    public function matchArrayRecursex(&$result, $rule, &$error)
    {

        $this->parser->addBacktrace(array($rule['_param'], ''));
        $subres = $this->parser->matchRule($result, $rule['_param'], $error);
        $remove = array_pop($this->parser->backtrace);
        if ($subres) {
            if (!$rule['_pla']) {
                $this->parser->successNode(array($rule['_param'], $subres['_text']));
            }
            $this->ruleArrayAction($result, $subres);
            if ($rule['_nla']) {
                $valid = false;
            } else {
                $valid = true;
            }
        } else {
            if ($rule['_nla']) {
                $valid = true;
            } else {
                $valid = false;
            }
            $this->parser->failNode($remove);
        }
        return $valid;
    }

    /**
     * Calls store actions on matching rules
     *
     * @param array $result result array
     * @param array $subres result array of matched token
     */
    public function ruleArrayAction(&$result, $subres)
    {
        $result['_endpos'] = $this->parser->pos;
        if ($subres['_silent'] == 0) {
            $result['_text'] .= $subres['_text'];
        }
        $storetag = (isset($subres['_tag']) && !empty($subres['_tag'])) ? $subres['_tag'] : false;

        /**
         * if ($storetag) {
         * $this->_result[$storetag][$subres->_startpos][$subres->_endpos]['text'] = $subres->_text;
         * $this->_result[$storetag][$subres->_startpos][$subres->_endpos]['node'] = $subres->node;
         * $this->_result[$storetag][$subres->_startpos][$subres->_endpos]['result'] = $subres->_result;
         * }
         * */
        if (isset($result['_actions']['_match'])) {
            if (isset($subres['_matchres']) && !empty($subres['_matchres'])) {
                foreach ($subres['_matchres'] as $type => $foo) {
                    if (!empty($foo) && isset($result['_actions']['_match'][$type])) {
                        foreach ($result['_actions']['_match'][$type] as $method => $bar) {
                            $storetag = false;
                            $callback = array($result['_ruleParser'], $method);
                            call_user_func_array($callback, array(&$result, $subres));
                        }
                    }
                }
            }
            if ($storetag || isset($subres['_name'])) {
                $type = $storetag ? $storetag : $subres['_name'];
                if (false) {
                    $method = "{$result['_name']}_{$type}";
                    if (isset($result['_actions'][$method])) {
                        $callback = array($result['_ruleParser'], $method);
                        call_user_func_array($callback, array(&$result, $subres));
                        return;
                    }
                }
                if (isset($result['_actions']['_match'][$type])) {
                    foreach ($result['_actions']['_match'][$type] as $method => $foo) {
                        $callback = array($result['_ruleParser'], $method);
                        call_user_func_array($callback, array(&$result, $subres));
                        return;
                    }
                }
            }
        }

        if (isset($result['_actions']['_all'])) {
            foreach ($result['_actions']['_all'] as $method => $foo) {
                $callback = array($result['_ruleParser'], $method);
                call_user_func_array($callback, array(&$result, $subres));
                return;
            }
        }
        if (!empty($subres['_matchres'])) {
            $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
        } elseif ($storetag) {
            if (!isset($result[$storetag])) {
                $result[$storetag] = $subres;
            } else {
                if (!is_array($result[$storetag])) {
                    $result[$storetag] = array($result[$storetag], $subres);
                }
                $result[$storetag][] = $subres;
            }
        }
        /**
         * else {
         * if (isset($subres['_matchres'])) {
         * $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
         * }
         * }
         */
    }

    /**
     * Match optional tokens
     *
     * @param array $result      result array
     * @param array $rule        rule parameter array
     * @param array $resultError error array
     *
     * @return bool result of match
     */
    public function matchArrayOption(&$result, $rule, &$resultError)
    {
        $backup = $result;
        $pos = $this->parser->pos;
        $line = $this->parser->line;
        $count = count($rule['_param']);
        $loop = 0;
        $resultOptionError = array();
        $index = $this->index ++;
        $this->parser->addBacktrace(array('_o{$index}_', ''));
        do {
            //TODO
            $error = array();
            $ruleOption = $this->buildParams($rule['_param'][$loop]);
            if (isset($rule['_actions'])) {
                $ruleOption['_actions'] = $rule['_actions'];
            }
            $ruleOption['_name'] = $rule['_name'];
            array_pop($this->parser->backtrace);
            $this->parser->addBacktrace(array("_o{$index}:{$loop}_", ''));
            $valid = $this->matchArrayToken($result, $ruleOption, $error);
            if ($valid) {
                $this->parser->successNode(array_pop($this->parser->backtrace));
                if ($ruleOption['_nla']) {
                    $this->parser->shouldNotMatchError($error{$index}, $ruleOption['_name'], $error);
                }
                break;
            } else {
                $this->parser->logOption($resultOptionError, $ruleOption['_name'], $error);
            }
            if ($ruleOption['_nla']) {
                $this->parser->matchError($resultError, 'Option', $resultOptionError);
            }
            $loop ++;
            if ($loop == $count) {
                array_pop($this->parser->backtrace);
                break;
            }
        } while ($loop < $count);
        if ($ruleOption['_nla']) {
            $valid = !$valid;
        }
        $this->parser->pos = $pos;
        $this->parser->line = $line;
        $result = $backup;
        return $valid;
    }

    /**
     * Match sequence of tokens
     *
     * @param array $result result array
     * @param array $rule   rule parameter array
     * @param       $resultError
     *
     * @return bool result of match
     */
    public function matchArraySequence(&$result, $rule, &$resultError)
    {
        $index = $this->index ++;
        $backup = $result;
        $pos = $this->parser->pos;
        $line = $this->parser->line;
        $resultSequenceError = array();
        $count = count($rule['_param']);
        $loop = 0;
        $index = $this->index ++;
        $this->parser->addBacktrace(array("_s{$index}_", ''));
        do {
            $error = array();
            $ruleSequence = $this->buildParams($rule['_param'][$loop]);
            /**
             * if (isset($rule['_actions'])) {
             * $ruleSequence['_actions'] = $rule['_actions'];
             * }
             * */
            $ruleSequence['_name'] = $rule['_name'];
            $valid = $this->matchArrayToken($result, $ruleSequence, $error);
            if ($valid === false) {
                $this->parser->matchError($resultError, 'SequenceElement', $error);
                break;
            } else {
                if ($ruleSequence['_nla']) {
                    $this->parser->shouldNotMatchError($resultError, 'SequenceElement', $error);
                }
            }
            $loop ++;
        } while ($loop < $count);
        if ($rule['_tag']) {
            $result['_tag'] = $rule['_tag'];
            $this->ruleArrayAction($backup, $result);
            $result = $backup;
        }
        return $valid;
    }

    /**
     * Match whitespace token
     *
     * @param array  $result result array
     * @param array  $rule   rule parameter array ($rule['_param'] == true is optional)
     * @param  array $error  error array
     *
     * @return bool result of match
     */
    public function matchArrayWhitespace(&$result, $rule, &$error)
    {
        if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
            if (!empty($match[0])) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
                if ($rule['_silent'] == 0) {
                    $result['_text'] .= ' ';
                }
                $result['_endpos'] = $this->parser->pos;
                $valid = true;
            } else {
                $valid = false;
            }
        } else {
            $valid = false;
        }
        if (!$rule['_param']) {
            if ($valid) {
                $this->parser->successNode(array("' '", ' '));;
                if ($rule['_nla'] === false) {
                    $this->parser->shouldNotMatchError($error, 'whitespace');
                }
            } else {
                $this->parser->failNode(array("' '", ''));
            }
            if ($rule['_nla'] === false) {
                $this->parser->matchError($error, 'whitespace');
            }
        } else {

            $this->parser->successNode(array("' '", $match[0]));
            $valid = true;
            if ($rule['_nla']) {
                if ($valid) {
                    $this->parser->shouldNotMatchError($error, 'whitespace');
                }
            } else {
                if (!$valid) {
                    $this->parser->matchError($error, 'whitespace');
                }
            }
        }
        if ($rule['_nla']) {
            $valid = !$valid;
        }
        return $valid;
    }

    /**
     * Match literal token
     *
     * @param array $result result array
     * @param array $rule   rule parameter array ($rule['_param'] contains literal)
     * @param array $error  error array
     *
     * @return bool result of match
     */
    public function matchArrayLiteral(&$result, $rule, &$error)
    {
        $len = strlen($rule['_param']);
        if ($rule['_param'] == substr($this->parser->source, $this->parser->pos, $len)) {
            $this->parser->pos += $len;
            if ($rule['_silent'] == 0) {
                $result['_text'] .= $rule['_param'];
            }
            $result['_endpos'] = $this->parser->pos;
            if ($rule['_nla']) {
                $this->parser->shouldNotMatchError($error, 'literal', $rule['_param']);
            }
            if (isset($rule['_actions']['_match'])) {
                $type = (isset($rule['_tag']) && $rule['_tag'] !== false) ? $rule['_tag'] : $rule['_name'];
                if (isset($rule['_actions']['_match'][$type])) {
                    foreach ($rule['_actions']['_match'][$type] as $method => $foo) {
                        $callback = array($result['_ruleParser'], $method);
                        $subres = array();
                        call_user_func_array($callback, array(&$result, $subres));
                    }
                }
            }
            $valid = true;
            $this->parser->successNode(array("'{$rule['_param']}'", $rule['_param']));
            if ($rule['_nla']) {
                $this->parser->shouldNotMatchError($error, 'literal', "'{$rule['_param']}'");
                $valid = false;
            }
        } else {
            if ($rule['_nla'] === false) {
                $this->parser->matchError($error, 'literal', "'{$rule['_param']}'");
            }
            $this->parser->failNode(array("'{$rule['_param']}'", ''));
            $valid = $rule['_nla'];
        }
        return $valid;
    }

    /**
     * Match expression token
     *
     * @param array $result result array
     * @param array $rule   rule parameter array
     * @param array $error  error array
     *
     * @return bool result of match
     */
    public function matchArrayExpression(&$result, $rule, &$error)
    {
        $subres = $result;
        $subres['_tag'] = $rule['_tag'];
        $this->parser->addBacktrace(array("'{$rule['_name']}'", ''));
        $valid = false;
        // call runtime function to perform the match
        $method = "{$result['_name']}_EXP_{$rule['_param']}";
        if (isset($result['_actions']['_expression'][$method])) {
            $callback = array($result['_ruleParser'], $method);
            $valid = call_user_func_array($callback, array(&$subres));
        }
        $remove = array_pop($this->parser->backtrace);
        if ($valid) {
            $this->parser->successNode($subres);
            // call matching actions
            if ($subres['_silent'] < 2) {
                if (isset($subres['_actions']['_finish'])) {
                    foreach ($subres['_actions']['_finish'] as $method => $foo) {
                        $callback = array($subres['_ruleParser'], $method);
                        call_user_func_array($callback, array(&$subres));
                    }
                }
                $this->ruleArrayAction($result, $subres);
            } else {
                $result['_endpos'] = $this->parser->pos;
            }
        } else {
            $this->parser->matchError($error, 'expression', $result['_name']);
            $this->parser->failNode($remove);
        }
        return $valid;
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
        if (isset($rule['_actions'])) {
            $param['_actions'] = $rule['_actions'];
        }
        if (isset($rule['_ruleParser'])) {
            $param['_ruleParser'] = $rule['_ruleParser'];
        }
        $param['_loop'] = ($param['_min'] != 0 && $param['_min'] != 1) || $param['_max'] != 1;
        return $param;
    }
}
