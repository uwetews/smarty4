<?php

Namespace Smarty\Parser\Rules;

Use Smarty\Parser\Rule;
Use Smarty\Parser\Token;
Use Smarty\Parser\RuleArrayParser;
Use Smarty\Parser;

/**
 * Class Rx
 *
 * @package Smarty\Parser\Peg\Nodes
 */

/**
 * Class Rx
 *
 * @package Smarty\Parser\Peg\Nodes
 */
class RxMatchOld
{
    /**
     * @var string
     */
    static $init_rx = '/ { (\w+) } /x';
    /**
     * @var string
     */
    static $expression_rx = '/ \$(\w+) /x';
    /**
     * @var null
     */
    public $_regexp = null;
    /**
     * @var bool
     */
    public $_hasExpression = false;
    /**
     * @var array
     */
    public $regexpCache = array();
    /**
     * @var null
     */
    public $_result = null;
    /**
     * @var null|Parser
     */
    public $parser = null;
    /**
     * @var null|RuleArrayParser
     */
    public $ruleArrayParser = null;

    /**
     * @param      $rule
     * @param      $parser
     */
    public function __construct($rule, Parser $parser, RuleArrayParser $ruleArrayParser)
    {
        $this->ruleArrayParser = $ruleArrayParser;
        $this->parser = $parser;
        $this->_result = $rule;
        $this->_regexp = $rule['_param'];
        if ($this->contains_expression($this->_regexp)) {
            $this->_hasExpression = true;
        }
        $this->_regexp = preg_replace_callback(self::$init_rx, array($this, 'init_replace'), $this->_regexp);
        $this->_result = null;
    }

    /**
     * @param $value
     *
     * @return int
     */
    function contains_expression($value)
    {
        return preg_match(self::$expression_rx, $value);
    }

    /**
     * match regular expression
     *
     * @return bool
     */
    public function matchRx(&$nodeRes, $params)
    {
        if ($this->_hasExpression) {
            $this->_result = $nodeRes;
            $key = $this->insert_expression($this->_regexp);
            $this->_result = null;
        } else {
            $key = $this->_regexp;
        }
        $pos = $this->parser->pos;
        if (isset($this->regexpCache[$pos])) {
            $res = $this->regexpCache[$pos];
        } elseif (isset($nodeRes['_attr']['matchall'])) {
            if (empty($this->regexpCache) && preg_match_all($key . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                //                var_dump($matches);
                $this->regexpCache[- 1] = true;
                foreach ($matches[0] as $match) {
                    $res = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]));
                    foreach ($match as $n => $v) {
                        if (is_string($n)) {
                            $res['_pregMatch'][$n] = $v[0];
                        }
                    }
                    $this->regexpCache[$match[1]] = $res;
                    if (isset($nodeRes['match'])) {
                        $nodeRes['_pregMatch'] = $match[0];
                    }
                }
            } else {
                $this->regexpCache[- 1] = false;
                return false;
            }
            if (isset($this->regexpCache[$pos])) {
                $res = $this->regexpCache[$pos];
            } else {
                $this->regexpCache[$pos] = false;
                return false;
            }
        } else {
            $a = substr($this->parser->source, $pos, 30);
            if (preg_match($key . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                //                var_dump($matches);
                $res = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]));
                foreach ($match as $n => $v) {
                    if (is_string($n)) {
                        $res['_pregMatch'][$n] = $v[0];
                    }
                }
                if ($res['_startpos'] != $pos) {
                    $this->regexpCache[$res['_startpos']] = $res;
                    $this->regexpCache[$pos] = false;
                    $res = false;
                }
            } else {
                $this->regexpCache[$pos] = false;
                $res = false;
            }
        }
        if ($res === false) {
            return false;
        } else {
            $this->parser->pos = $res['_endpos'];
            $this->parser->line += substr_count($res['_text'], "\n");
            if ($nodeRes['_silent'] < 2) {
                $res['_tag'] = $params['_tag'];
                if (isset($nodeRes['_name'])) {
                    $res['_name'] = $nodeRes['_name'];
                }
                $this->ruleArrayParser->ruleArrayAction($nodeRes, $res);
            }
            return true;
        }
    }

    /**
     * @param $value
     *
     * @return $this
     */
    function insert_expression($value)
    {
        return preg_replace_callback(self::$expression_rx, array($this, 'expression_replace'), $value);
    }

    /**
     * @param $matches
     *
     * @return string
     */
    function expression_replace($matches)
    {
        return $this->parser->expression($this->_result, $matches[1]);
    }

    /**
     * @param $matches
     *
     * @return string
     */
    function init_replace($matches)
    {
        $method = "{$this->_result['_name']}_INIT_{$matches[1]}";
        return $this->_result['_ruleParser']->$method($this);
    }
}

