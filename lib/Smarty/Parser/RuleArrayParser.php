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
    private  $parser = null;

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
     * @param  string $ruleName  rule name
     *

     * @return mixed
     */
    public function getRuleAsArray($ruleName)
    {
        $pegParser = $this->parser->getPegParser($ruleName);
        if (isset($this->parser->rules[$ruleName])) {
            $rule = $this->parser->rules[$ruleName];
        } else {
            throw new NoRule($ruleName, 0, $this->context);
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
     * Rule result array initialization
     *
     * @param array     $result
     * @param null|array $previous optional result array of calling rule
     */
    public function ruleStart(&$result, $previous = null)
    {
        if (!isset($result['_parser'])) {
            $result['_parser'] = $this;
        }
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        if (isset($result['_actions']['_start'])) {
            foreach ($result['_actions']['_start'] as $method => $foo) {
                $callback = array($result['_ruleParser'], $method);
                call_user_func_array($callback, array(&$result, $previous));
            }
        }
    }

    /**
     * Match token rule observing all parameter
     *
     * @param array $result result array
     * @param array $params rule parameter array
     *
     * @return bool
     */
    public function matchRuleArray(&$result, $params)
    {
        $iteration = 0;
        if ($params['_pla'] || $params['_nla']) {
            $backup = $result;
        }
        $pos = $this->parser->pos;
        $line = $this->parser->line;
        do {
            $a = substr($this->parser->source, $this->parser->pos, 30);
            $valid = $this->matchTokenArray($result, $params);
            if ($params['_pla'] || $params['_nla']) {
                $this->parser->pos = $pos;
                $this->parser->line = $line;
                $result = $backup;
            }
            if ($params['_nla']) {
                $valid = !$valid;
            }
            if ($valid) {
                $iteration ++;
            }
            if ($valid && $params['_max'] != null && $iteration == $params['_max']) {
                break;
            }
            if (!$valid && $iteration >= $params['_min']) {
                $valid = true;
                break;
            }
            if (!$valid) {
                break;
            }
        } while (true);
        return $valid;
    }

    /**
     * Match rule token by its type
     *
     * @param array $result   result array
     * @param array $params   rule parameter array
     *
     * @return bool  result of match
     */
    public function matchTokenArray(&$result, $params)
    {
        switch ($params['_type']) {
            case 'recurse':
                return $this->matchRecurseArray($result, $params);
                break;
            case 'rx':
                $rx = isset($this->parser->rxCache[$params['_param']]) ? $this->parser->rxCache[$params['_param']] : $this->parser->rxCache[$params['_param']] = new RxMatchOld($params, $this->parser, $this);
                return $rx->matchRx($result, $params);
                break;
            case 'option':
                return $this->matchOptionArray($result, $params);
                break;
            case 'sequence':
                return $this->matchSequenceArray($result, $params);
                break;
            case 'whitespace':
                return $this->matchWhitespaceArray($result, $params);
                break;
            case 'literal':
                return $this->matchLiteralArray($result, $params);
                break;
            case 'expression':
                return $this->matchExpressionArray($result, $params);
                break;
            default:
                //TODO
                return false;
                break;
        }
    }

    /**
     * Match Token by its node name
     *     *
     *
     * @param array     $result result array
     * @param array $params rule parameter array
     *
     * @return bool result of match
     */
    public function matchRecurseArray(&$result, $params)
    {
        $subres = array_merge($this->parser->resultDefault, $this->getRuleAsArray($params['_param']));
        $newParams = $this->parser->buildParams($subres);

        $this->parser->backtrace[] = $subres;
        $hashed = isset($subres['_attr']['hash']);
        $pos = $this->parser->pos;
        $hashvalid = false;
        if ($hashed && isset($this->parser->packCache[$pos][$subres['_name']])) {
            $subres = $this->parser->packCache[$pos][$subres['_name']];
            $hashvalid = $valid = !(false === $subres);
            if ($hashvalid) {
                $subres['_tag'] = $params['_tag'];
                $this->parser->pos = $subres['_endpos'];
            }
        } else {
            $this->ruleStart($subres, $result);
            $subres['_tag'] = $params['_tag'];
            $valid = ($newParams['_extended']) ? $this->matchRuleArray($subres, $newParams) : $this->matchTokenArray($subres, $newParams);
            if ($hashed) {
                if ($valid) {
                    $this->parser->packCache[$pos][$subres['_name']] = $subres;
                } else {
                    $this->parser->packCache[$pos][$subres['_name']] = false;
                }
            }
        }
        $remove = array_pop($this->parser->backtrace);
        if ($valid) {
            $this->parser->successNode($subres);
            if ($subres['_silent'] < 2) {
                if (!$hashvalid && isset($subres['_actions']['_finish'])) {
                    foreach ($subres['_actions']['_finish'] as $method => $foo) {
                        $callback = array($subres['_ruleParser'], $method);
                        call_user_func_array($callback, array(&$subres));
                        if ($subres === false) {
                            return false;
                        }
                    }
                }
                $this->ruleMatchArray($result, $subres);
            } else {
                $result['_endpos'] = $this->parser->pos;
            }
        } else {
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
    public function ruleMatchArray(&$result, $subres)
    {
        $result['_endpos'] = $this->parser->pos;
        if ($subres['_silent'] == 0) {
            $result['_text'] .= $subres['_text'];
        }
        $storetag = (isset($subres['_tag']) && !empty($subres['_tag'])) ? $subres['_tag'] : false;
        // TODO
        if (false && $this->parser->trace) {
            $backlinks = $this->parser->getBacklinks();
            fprintf($this->parser->traceFile, "%sParser Match [", $this->parser->tracePrompt);
            foreach ($backlinks as $bl) {
                fprintf($this->parser->traceFile, "%s ", $bl['_name']);
            }
            fprintf($this->parser->traceFile, "= %s]\n", $subres['_name']);
        }

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
     * @param array $result result array
     * @param array $params rule parameter array
     *
     * @return bool result of match
     */
    public function matchOptionArray(&$result, $params)
    {
        $backup = $result;
        $pos = $this->parser->pos;
        $line = $this->parser->line;
        $count = count($params['_param']);
        $loop = 0;
        do {
            $newParams = $this->parser->buildParams($params['_param'][$loop]);
            $valid = ($newParams['_extended']) ? $this->matchRuleArray($result, $newParams) : $this->matchTokenArray($result, $newParams);
            if ($valid) {
                return true;
            }
            $loop ++;
        } while ($loop < $count);
        $this->parser->pos = $pos;
        $this->parser->line = $line;
        $result = $backup;
        return false;
    }

    /**
     * Match sequence of tokens
     *
     * @param array $result result array
     * @param array $params rule parameter array
     *
     * @return bool result of match
     */
    public function matchSequenceArray(&$result, $params)
    {
        $backup = $result;
        $pos = $this->parser->pos;
        $line = $this->parser->line;
        $count = count($params['_param']);
        $loop = 0;
        do {
            $newParams = $this->parser->buildParams($params['_param'][$loop]);
            $valid = ($newParams['_extended']) ? $this->matchRuleArray($result, $newParams) : $this->matchTokenArray($result, $newParams);
            if ($valid === false) {
                $this->parser->pos = $pos;
                $this->parser->line = $line;
                $result = $backup;
                return false;
            }
            $loop ++;
        } while ($loop < $count);
       if ($params['_tag']) {
            $result['_tag'] = $params['_tag'];
            $this->ruleMatchArray($backup, $result);
            $result = $backup;
        }
        return true;
    }

    /**
     * Match whitespace token
     *
     * @param array $result result array
     * @param array $params rule parameter array ($params['_param'] == true is optional)
     *
     * @return bool result of match
     */
    public function matchWhitespaceArray(&$result, $params)
    {
        if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
            $result['_text'] .= ' ';
            $this->parser->pos += strlen($match[0]);
            $this->parser->line += substr_count($match[0], "\n");
            $result['_endpos'] = $this->parser->pos;
            return true;
        }
        if ($params['_param']) {
            return true;
        }
        return false;
    }

    /**
     * Match literal token
     *
     * @param array $result result array
     * @param array $params rule parameter array ($params['_param'] contains literal)
     *
     * @return bool result of match
     */
    public function matchLiteralArray(&$result, $params)
    {
        if ($params['_param'] == substr($this->parser->source, $this->parser->pos, strlen($params['_param']))) {
            $this->parser->pos += strlen($params['_param']);
            $result['_text'] .= $params['_param'];
            $result['_endpos'] = $this->parser->pos;
            $this->parser->successLiteral($params['_param']);
            // if literal was tagged call matching action
            if ($params['_tag']) {
                if (isset($result['_actions']['_match'][$params['_tag']])) {
                    foreach ($result['_actions']['_match'][$params['_tag']] as $method => $foo) {
                        $callback = array($result['_ruleParser'], $method);
                        $subres = array();
                        call_user_func_array($callback, array(&$result, $subres));
                        return true;
                    }
                }
            }
            return true;
        }
        $this->parser->failLiteral($params['_param']);
        return false;
    }


    /**
     * Match expression token
     *
     * @param array $result result array
     * @param array $params rule parameter array
     *
     * @return bool result of match
     */
    public function matchExpressionArray(&$result, $params)
    {
        $subres = $result;
        $subres['_tag'] = $params['_tag'];
        $this->parser->backtrace[] = $result;
        $valid = false;
        // call runtime function to perform the match
        $method = "{$result['_name']}_EXP_{$params['_param']}";
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
                $this->ruleMatchArray($result, $subres);
            } else {
                $result['_endpos'] = $this->parser->pos;
            }
        } else {
            $this->parser->failNode($remove);
        }
        return $valid;
    }

}
