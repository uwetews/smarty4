<?php

namespace Smarty\Parser;

use Smarty\Exception\Magic;
use Smarty\Parser\Rules\RxMatchOld;
use Smarty\Parser\Exception\NoRule;
use Smarty\Parser;
use Smarty\Parser\Peg\RuleRoot;

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
     * Array of known rule types
     *
     * @var array
     */
    private $ruleTypes = array('Token' => true, 'Expression' => true, 'Literal' => true, 'MatchToken' => true,
                               'Option' => true, 'Sequence' => true, 'RegExpr' => true, 'WhiteSpace' => true);

    /**
     * Array with default rule parameter
     *
     * @var array
     */
    private $defaultRuleParameter = array('pla' => false, 'nla' => false, 'min' => 1, 'max' => 1,
                                          'silent' => 0, 'tag' => '');

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
        if (isset($this->parser->ruleArray[$ruleName])) {
            $rule = $this->parser->ruleArray[$ruleName];
        } else {
            throw new NoRule($ruleName, 0, $this->parser->context);
        }
        if (is_array($rule)) {
            $rule['_ruleParser'] = $pegParser;
        } else {
            $rule = $pegParser->ruleArray[$ruleName];
            $rule['_ruleParser'] = $this->parser->ruleArray[$ruleName];
        }
        return $rule;
    }

    public function matchArrayNode($previous, &$errorResult, $ruleArray, RuleRoot; $pegParser)
    {
        $nodeName = $ruleArray['name'];
        $nodeAttributes = $pegParser->getAttributes($nodeName);
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        if ($this->parser->trace) {
            $this->parser->addBacktrace(array($nodeName, ''));
        }
        $hash = isset($nodeAttributes['hash']);
        $wasHashed = false;
        if ($hash) {
            if (isset($this->parser->packCache[$this->parser->pos][$nodeName])) {
                $wasHashed = true;
                $nodeRes = $this->parser->packCache[$this->parser->pos][$nodeName];
                $error = $this->parser->errorCache[$this->parser->pos][$nodeName];
                if ($nodeRes) {
                    $this->parser->pos = $nodeRes['_endpos'];
                    $this->parser->line = $nodeRes['_endline'];
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->matchError($errorResult, 'token', $error, $nodeName);
                }
            }
        }
        if (!$wasHashed) {
            $actionMethod = $nodeName . '_START';
            if (method_exists($pegParser, $actionMethod)) {
                $pegParser->$actionMethod($nodeRes, $previous);
            }
            $valid = $this->matchArrayRule($nodeRes, $error, $ruleArray['rule'], $pegParser, $nodeAttributes);
            if ($valid) {
                $nodeRes['_endpos'] = $this->parser->pos;
                $nodeRes['_endline'] = $this->parser->line;
                $actionMethod = $nodeName . '_FINISH';
                if (method_exists($pegParser, $actionMethod)) {
                    $pegParser->$actionMethod($nodeRes);
                }
            } else {
                $nodeRes = false;
                $this->parser->matchError($errorResult, 'token', $error, $nodeName);
            }
            if ($hash) {
                $this->parser->packCache[$pos0][$nodeName] = $nodeRes;
                $this->parser->errorCache[$pos0][$nodeName] = $error;
            }
        }
        if ($this->parser->trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if ($valid) {
            if (!(isset($ruleArray['rule']['pla']) && $ruleArray['rule']['pla'])) {
                if ($this->parser->trace) {
                    $this->parser->successNode(array($nodeName, $nodeRes['_text']));
                }
            }
            //$this->ruleArrayAction($nodeRes, $matchRes);
            if (isset($ruleArray['rule']['nla']) && $ruleArray['rule']['nla']) {
                $valid = false;
            } else {
                $valid = true;
            }
        } else {
            if (isset($ruleArray['rule']['nla']) && $ruleArray['rule']['nla']) {
                $valid = true;
            } else {
                $valid = false;
            }
            if ($this->parser->trace) {
                $this->parser->failNode($remove);
            }
            $this->parser->matchError($errorResult, 'token', $error, $nodeName);
        }
        return ($valid) ? $nodeRes : false;
    }

    public function matchArrayRule(&$nodeRes, &$error, $ruleArray, RuleRoot; $pegParser, $nodeAttributes) {
        $ruleMethod = 'matchArrayRule' . $ruleArray['type'];
        if (isset($this->ruleTypes[$ruleArray['type']])) {
            // dispatch to rule type handler
            return $this->$ruleMethod($nodeRes, $error, $ruleArray, $pegParser, $nodeAttributes);
        } else {
            //TODO Internal exception
        }
    }

    public function matchArrayToken(&$nodeRes, &$errorResult, $ruleArray, RuleRoot; $pegParser, $nodeAttributes) {
        $ruleArray = array_merge($this->defaultRuleParameter, $ruleArray);
        if ($ruleArray['pla'] || $ruleArray['nla']) {
            $backup = $nodeRes;
            $pos = $this->parser->pos;
                   $line = $this->parser->line;
        } else {
            if ($ruleArray['min'] == 0 && $ruleArray['max'] == 1) {
                $error = array();
            }
        }
        $loop = $ruleArray['min'] > 1 || $ruleArray['max'] != 1;

            $iteration = 0;
        do {
            echo "\n".substr($this->parser->source,$this->parser->pos,40)."\n";
            $valid = $this->matchArrayRule($nodeRes, $error, $ruleArray['ruleToken'], $pegParser, $nodeAttributes);
            if ($ruleArray['pla'] || $ruleArray['nla']) {
                $this->parser->pos = $pos;
                $this->parser->line = $line;
                $nodeRes = $backup;
                unset($backup);
            } else {
                //$this->php("\$nodeRes['_endpos'] = \$this->parser->pos;\n");
            }
            if ($loop) {
                $iteration = $valid ? ($iteration + 1) : $iteration;
                if ($ruleArray['max'] !== null) {
                    if ($valid && $iteration == $ruleArray['max']) {
                        break;
                    }
                }
                if (!$valid && $iteration >= $ruleArray['min']) {
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

        if ($ruleArray['min'] == 0 && $ruleArray['max'] == 1) {
            if (!($ruleArray['pla'] || $ruleArray['nla'])) {
                if (!$valid) {
                    $this->parser->logOption($errorResult, $ruleArray['ruleToken']['name'], $error);
                }
            }
            $valid = true;
        }
        return $valid;
    }

    /**
     * Match optional tokens
     *
     * @param array $nodeRes      result array
     * @param array $rule        rule parameter array
     * @param array $nodeResError error array
     *
     * @return bool result of match
     */
    public function matchArrayOption(&$nodeRes, &$errorResult, $ruleArray, RuleRoot; $pegParser, $nodeAttributes)
    {
        $backup = $nodeRes;
        $pos = $this->parser->pos;
        $line = $this->parser->line;
        $count = count($ruleArray['optionalRules']);
        $loop = 0;
        $nodeResOptionError = array();
        $index = $this->index ++;
        if ($this->parser->trace) {
            $this->parser->addBacktrace(array("_o{$index}_", ''));
        }
        do {
            //TODO
            $error = array();
            $ruleOption = $ruleArray['optionalRules'][$loop];
            if (isset($rule['_actions'])) {
                $ruleOption['_actions'] = $rule['_actions'];
            }
            $ruleOption['_name'] = $rule['_name'];
            if ($this->parser->trace) {
                array_pop($this->parser->backtrace);
                $this->parser->addBacktrace(array("_o{$index}:{$loop}_", ''));
            }
            $valid =  $this->matchArrayRule($nodeRes, $error, $ruleOption, $pegParser, $nodeAttributes);
            if ($valid) {
                if ($this->parser->trace) {
                    $this->parser->successNode(array_pop($this->parser->backtrace));
                }
                if (isset($ruleOption['nla']) && $ruleOption['nla']) {
                    $this->parser->shouldNotMatchError($error{$index}, $ruleOption['_name'], $error);
                }
                break;
            } else {
                $this->parser->logOption($nodeResOptionError, $ruleOption['_name'], $error);
            }
            if ($ruleOption['_nla']) {
                $this->parser->matchError($nodeResError, 'Option', $nodeResOptionError);
            }
            $loop ++;
            if ($loop == $count) {
                array_pop($this->parser->backtrace);
                break;
            }
        } while ($loop < $count);
        if (!$valid || $ruleOption['_nla']) {
            $this->parser->pos = $pos;
            $this->parser->line = $line;
            $nodeRes = $backup;
        }
        if ($ruleOption['_nla']) {
            $valid = !$valid;
        }
        return $valid;
    }

    /**
     * Match token rule
     *
     * @param        $nodeRes
     * @param string $ruleName    rule name
     * @param array  $errorResult error array
     *
     * @throws Exception\NoRule
     * @internal param array $previous previous result array
     * @return bool|array  result array or false if match failed
     */
    public function matchArrayRulex(&$nodeRes, $ruleName, &$errorResult, $pegParser)
    {
        $this->index = 0;
        $rule = $this->buildParams($this->getRuleAsArray($ruleName));
        if ($this->parser->trace) {
            $this->parser->addBacktrace(array($ruleName, ''));
        }
        $error = array();
        // TODO  get hash attribute
        //$hash = $this->parser->getAttribute($rule['_name'], 'hash');
        $hash = false;
        $wasHashed = false;
        if ($hash) {
            if (isset($this->parser->packCache[$this->parser->pos][$rule['_name']])) {
                $wasHashed = true;
                $matchRes = $this->parser->packCache[$this->parser->pos][$rule['_name']];
                $error = $this->parser->errorCache[$this->parser->pos][$rule['_name']];
                if ($matchRes) {
                    $this->parser->pos = $matchRes['_endpos'];
                    $this->parser->line = $matchRes['_endline'];
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->matchError($errorResult, 'token', $error, $rule['_name']);
                }
            }
        }
        if (!$wasHashed) {
            $matchRes = $this->parser->resultDefault;
            if (isset($rule['_actions']['_start'])) {
                foreach ($rule['_actions']['_start'] as $method => $foo) {
                    $rule['_ruleParser']->{$method}($matchRes, $nodeRes);
                }
            }
            if (isset($rule['_actions'])) {
                $matchRes['_actions'] = $rule['_actions'];
                $matchRes['_ruleParser'] = $rule['_ruleParser'];
            }
            if (isset($rule['_name'])) {
                $matchRes['_name'] = $rule['_name'];
            }
            if (isset($rule['_tag'])) {
                $matchRes['_tag'] = $rule['_tag'];
            }
            $pos0 = $matchRes['_startpos'] = $matchRes['_endpos'] = $this->parser->pos;
            $matchRes['_lineno'] = $this->parser->line;
            $valid = $this->matchArrayToken($matchRes, $rule, $error);
            if ($valid) {
                $matchRes['_endpos'] = $this->parser->pos;
                $matchRes['_endline'] = $this->parser->line;
                if (isset($rule['_actions']['_finish'])) {
                    foreach ($rule['_actions']['_finish'] as $method => $foo) {
                        if ($nodeRes !== false) {
                            $rule['_ruleParser']->{$method}($matchRes);
                        }
                    }
                }
            } else {
                $matchRes = false;
            }
            if ($hash) {
                $this->parser->packCache[$pos0][$rule['_name']] = $matchRes;
                $this->parser->errorCache[$pos0][$rule['_name']] = $error;
            }
        }
        if ($this->parser->trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if ($valid) {
            if (!$rule['_pla']) {
                if ($this->parser->trace) {
                    $this->parser->successNode(array($ruleName, $matchRes['_text']));
                }
            }
            //$this->ruleArrayAction($nodeRes, $matchRes);
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
            if ($this->parser->trace) {
                $this->parser->failNode($remove);
            }
            $this->parser->matchError($errorResult, 'token', $error, $ruleName);
        }
        return ($valid) ? $matchRes : false;
    }

    /**
     * Match token rule observing all parameter
     *
     * @param array $nodeRes result array
     * @param array $rule   rule parameter array
     * @param array $error  error array
     *
     * @return bool
     */
    public function matchArrayTokenx(&$nodeRes, $rule, &$error)
    {
        $index = $this->index ++;
        if ($rule['_pla'] || $rule['_nla']) {
            $backup = $nodeRes;
            $pos = $this->parser->pos;
            $line = $this->parser->line;
        } else {
            if ($rule['_min'] == 0 && $rule['_max'] == 1) {
                $error = array();
            }
        }
        $iteration = 0;
        do {
            echo "\n".substr($this->parser->source,$this->parser->pos,40)."\n";
            switch ($rule['_type']) {
                case 'token':
                    if ($matchRes = $this->parser->matchRule($nodeRes, $rule['_param'], $error)) {
                        $matchRes['_tag'] = isset($rule['_tag']) ? $rule['_tag'] : $matchRes['_tag'];
                        $valid = true;
                        $this->ruleArrayAction($nodeRes, $matchRes);
                    } else {
                        $valid = false;
                    }
                    //                    $valid =  $this->matchArrayRecurse($nodeRes, $rule, $error);
                    break;
                case 'rx':
                    $rx = isset($this->parser->rxCache[$rule['_param']]) ? $this->parser->rxCache[$rule['_param']] : $this->parser->rxCache[$rule['_param']] = new RxMatchOld($rule, $this->parser, $this);
                    $valid = $rx->matchRx($nodeRes, $rule);
                    break;
                case 'option':
                    $valid = $this->matchArrayOption($nodeRes, $rule, $error);
                    break;
                case 'sequence':
                case 'sequence2':
                    $valid = $this->matchArraySequence($nodeRes, $rule, $error);
                    break;
                case 'whitespace':
                    $valid = $this->matchArrayWhitespace($nodeRes, $rule, $error);
                    break;
                case 'literal':
                    $valid = $this->matchArrayLiteral($nodeRes, $rule, $error);
                    break;
                case 'expression':
                    $valid = $this->matchArrayExpression($nodeRes, $rule, $error);
                    break;
                default:
                    //TODO
                    $valid = false;
                    break;
            }
            //        $this->php("\$valid = {$neg}\$this->parser->matchToken(\$nodeRes, \$rule);\n");
            if ($rule['_pla'] || $rule['_nla']) {
                $this->parser->pos = $pos;
                $this->parser->line = $line;
                $nodeRes = $backup;
                unset($backup);
            } else {
                //$this->php("\$nodeRes['_endpos'] = \$this->parser->pos;\n");
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
     * @param array $nodeRes result array
     * @param array $rule   rule parameter array
     * @param array $error  error array
     *
     * @return bool result of match
     */
    public function matchArrayRecurse(&$nodeRes, $rule, &$error)
    {

        if ($this->parser->trace) {
            $this->parser->addBacktrace(array($rule['_param'], ''));
        }
        $matchRes = $this->parser->matchRule($nodeRes, $rule['_param'], $error);
        if ($this->parser->trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if ($matchRes) {
            if (!$rule['_pla']) {
                if ($this->parser->trace) {
                    $this->parser->successNode(array($rule['_param'], $matchRes['_text']));
                }
            }
            $this->ruleArrayAction($nodeRes, $matchRes);
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
            if ($this->parser->trace) {
                $this->parser->failNode($remove);
            }
        }
        return $valid;
    }

    /**
     * Match Token by its node name
     *     *
     *
     * @param array $nodeRes result array
     * @param array $rule   rule parameter array
     * @param array $error  error array
     *
     * @return bool result of match
     */
    public function matchArrayRecursex(&$nodeRes, $rule, &$error)
    {
        if ($this->parser->trace) {
            $this->parser->addBacktrace(array($rule['_param'], ''));
        }
        $matchRes = $this->parser->matchRule($nodeRes, $rule['_param'], $error);
        if ($this->parser->trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if ($matchRes) {
            if (!$rule['_pla']) {
                if ($this->parser->trace) {
                    $this->parser->successNode(array($rule['_param'], $matchRes['_text']));
                }
            }
            $this->ruleArrayAction($nodeRes, $matchRes);
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
            if ($this->parser->trace) {
                $this->parser->failNode($remove);
            }
        }
        return $valid;
    }

    /**
     * Calls store actions on matching rules
     *
     * @param array $nodeRes result array
     * @param array $matchRes result array of matched token
     */
    public function ruleArrayAction(&$nodeRes, $matchRes)
    {
        $nodeRes['_endpos'] = $this->parser->pos;
        if ($matchRes['_silent'] == 0) {
            $nodeRes['_text'] .= $matchRes['_text'];
        }
        $storetag = (isset($matchRes['_tag']) && !empty($matchRes['_tag'])) ? $matchRes['_tag'] : false;

        /**
         * if ($storetag) {
         * $this->_result[$storetag][$matchRes->_startpos][$matchRes->_endpos]['text'] = $matchRes->_text;
         * $this->_result[$storetag][$matchRes->_startpos][$matchRes->_endpos]['node'] = $matchRes->node;
         * $this->_result[$storetag][$matchRes->_startpos][$matchRes->_endpos]['result'] = $matchRes->_result;
         * }
         * */
        if (isset($nodeRes['_actions']['_match'])) {
            if (isset($matchRes['_pregMatch']) && !empty($matchRes['_pregMatch'])) {
                foreach ($matchRes['_pregMatch'] as $type => $foo) {
                    if (!empty($foo) && isset($nodeRes['_actions']['_match'][$type])) {
                        foreach ($nodeRes['_actions']['_match'][$type] as $method => $bar) {
                            $storetag = false;
                            $callback = array($nodeRes['_ruleParser'], $method);
                            call_user_func_array($callback, array(&$nodeRes, $matchRes));
                        }
                    }
                }
            }
            if ($storetag || isset($matchRes['_name'])) {
                $type = $storetag ? $storetag : $matchRes['_name'];
                if (false) {
                    $method = "{$nodeRes['_name']}_{$type}";
                    if (isset($nodeRes['_actions'][$method])) {
                        $callback = array($nodeRes['_ruleParser'], $method);
                        call_user_func_array($callback, array(&$nodeRes, $matchRes));
                        return;
                    }
                }
                if (isset($nodeRes['_actions']['_match'][$type])) {
                    foreach ($nodeRes['_actions']['_match'][$type] as $method => $foo) {
                        $callback = array($nodeRes['_ruleParser'], $method);
                        call_user_func_array($callback, array(&$nodeRes, $matchRes));
                        return;
                    }
                }
            }
        }

        if (isset($nodeRes['_actions']['_all'])) {
            foreach ($nodeRes['_actions']['_all'] as $method => $foo) {
                $callback = array($nodeRes['_ruleParser'], $method);
                call_user_func_array($callback, array(&$nodeRes, $matchRes));
                return;
            }
        }
        if (!empty($matchRes['_pregMatch'])) {
            $nodeRes['_pregMatch'] = array_merge($nodeRes['_pregMatch'], $matchRes['_pregMatch']);
        } elseif ($storetag) {
            if (!isset($nodeRes[$storetag])) {
                $nodeRes[$storetag] = $matchRes;
            } else {
                if (!is_array($nodeRes[$storetag])) {
                    $nodeRes[$storetag] = array($nodeRes[$storetag], $matchRes);
                }
                $nodeRes[$storetag][] = $matchRes;
            }
        }
        /**
         * else {
         * if (isset($matchRes['_pregMatch'])) {
         * $nodeRes['_pregMatch'] = array_merge($nodeRes['_pregMatch'], $matchRes['_pregMatch']);
         * }
         * }
         */
    }


    /**
     * Match sequence of tokens
     *
     * @param array $nodeRes result array
     * @param array $rule   rule parameter array
     * @param       $nodeResError
     *
     * @return bool result of match
     */
    public function matchArraySequence(&$nodeRes, $rule, &$nodeResError)
    {
        $index = $this->index ++;
        $backup = $nodeRes;
        $pos = $this->parser->pos;
        $line = $this->parser->line;
        $resultsequenceError = array();
        $count = count($rule['_param']);
        $loop = 0;
        $index = $this->index ++;
        if ($this->parser->trace) {
            $this->parser->addBacktrace(array("_s{$index}_", ''));
        }
        do {
            $error = array();
            $ruleSequence = $this->buildParams($rule['_param'][$loop]);
            /**
             * if (isset($rule['_actions'])) {
             * $ruleSequence['_actions'] = $rule['_actions'];
             * }
             * */
            $ruleSequence['_name'] = $rule['_name'];
            $valid = $this->matchArrayToken($nodeRes, $ruleSequence, $error);
            if ($valid === false) {
                $this->parser->matchError($nodeResError, 'SequenceElement', $error);
                break;
            } else {
                if ($ruleSequence['_nla']) {
                    $this->parser->shouldNotMatchError($nodeResError, 'SequenceElement', $error);
                }
            }
            $loop ++;
        } while ($loop < $count);
        if ($rule['_tag']) {
            $nodeRes['_tag'] = $rule['_tag'];
            $this->ruleArrayAction($backup, $nodeRes);
            $nodeRes = $backup;
        }
        return $valid;
    }

    /**
     * Match whitespace token
     *
     * @param array  $nodeRes result array
     * @param array  $rule   rule parameter array ($rule['_param'] == true is optional)
     * @param  array $error  error array
     *
     * @return bool result of match
     */
    public function matchArrayWhitespace(&$nodeRes, $rule, &$error)
    {
        if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
            if (!empty($match[0])) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
                if ($rule['_silent'] == 0) {
                    $nodeRes['_text'] .= ' ';
                }
                $nodeRes['_endpos'] = $this->parser->pos;
                $valid = true;
            } else {
                $valid = false;
            }
        } else {
            $valid = false;
        }
        if (!$rule['_param']) {
            if ($valid) {
                if ($this->parser->trace) {
                    $this->parser->successNode(array("' '", ' '));
                }
                if ($rule['_nla'] === false) {
                    $this->parser->shouldNotMatchError($error, 'whitespace');
                }
            } else {
                if ($this->parser->trace) {
                    $this->parser->failNode(array("' '", ''));
                }
            }
            if ($rule['_nla'] === false) {
                $this->parser->matchError($error, 'whitespace');
            }
        } else {
            if ($this->parser->trace) {
                $this->parser->successNode(array("' '", $match[0]));
            }
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
     * @param array $nodeRes result array
     * @param array $rule   rule parameter array ($rule['_param'] contains literal)
     * @param array $error  error array
     *
     * @return bool result of match
     */
    public function matchArrayLiteral(&$nodeRes, $rule, &$error)
    {
        $len = strlen($rule['_param']);
        if ($rule['_param'] == substr($this->parser->source, $this->parser->pos, $len)) {
            $this->parser->pos += $len;
            if ($rule['_silent'] == 0) {
                $nodeRes['_text'] .= $rule['_param'];
            }
            $nodeRes['_endpos'] = $this->parser->pos;
            if ($rule['_nla']) {
                $this->parser->shouldNotMatchError($error, 'literal', $rule['_param']);
            }
            if (isset($rule['_actions']['_match'])) {
                $type = (isset($rule['_tag']) && $rule['_tag'] !== false) ? $rule['_tag'] : $rule['_name'];
                if (isset($rule['_actions']['_match'][$type])) {
                    foreach ($rule['_actions']['_match'][$type] as $method => $foo) {
                        $callback = array($nodeRes['_ruleParser'], $method);
                        $matchRes = array();
                        call_user_func_array($callback, array(&$nodeRes, $matchRes));
                    }
                }
            }
            $valid = true;
            if ($this->parser->trace) {
                $this->parser->successNode(array("'{$rule['_param']}'", $rule['_param']));
            }
            if ($rule['_nla']) {
                $this->parser->shouldNotMatchError($error, 'literal', "'{$rule['_param']}'");
                $valid = false;
            }
        } else {
            if ($rule['_nla'] === false) {
                $this->parser->matchError($error, 'literal', "'{$rule['_param']}'");
            }
            if ($this->parser->trace) {
                $this->parser->failNode(array("'{$rule['_param']}'", ''));
            }
            $valid = $rule['_nla'];
        }
        return $valid;
    }

    /**
     * Match expression token
     *
     * @param array $nodeRes result array
     * @param array $rule   rule parameter array
     * @param array $error  error array
     *
     * @return bool result of match
     */
    public function matchArrayExpression(&$nodeRes, $rule, &$error)
    {
        $matchRes = $nodeRes;
        $matchRes['_tag'] = $rule['_tag'];
        if ($this->parser->trace) {
            $this->parser->addBacktrace(array("'{$rule['_name']}'", ''));
        }
        $valid = false;
        // call runtime function to perform the match
        $method = "{$nodeRes['_name']}_EXP_{$rule['_param']}";
        if (isset($nodeRes['_actions']['_expression'][$method])) {
            $callback = array($nodeRes['_ruleParser'], $method);
            $valid = call_user_func_array($callback, array(&$matchRes));
        }
        if ($this->parser->trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if ($valid) {
            if ($this->parser->trace) {
                $this->parser->successNode($matchRes);
            }
            // call matching actions
            if ($matchRes['_silent'] < 2) {
                if (isset($matchRes['_actions']['_finish'])) {
                    foreach ($matchRes['_actions']['_finish'] as $method => $foo) {
                        $callback = array($matchRes['_ruleParser'], $method);
                        call_user_func_array($callback, array(&$matchRes));
                    }
                }
                $this->ruleArrayAction($nodeRes, $matchRes);
            } else {
                $nodeRes['_endpos'] = $this->parser->pos;
            }
        } else {
            $this->parser->matchError($error, 'expression', $nodeRes['_name']);
            if ($this->parser->trace) {
                $this->parser->failNode($remove);
            }
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
