<?php

Namespace Smarty\Parser\Rules;

Use Smarty\Parser\Rule;
Use Smarty\Parser\Token;

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
class RxMatch
{
    static $init_rx = '/ { (\w+) } /x';
    static $expression_rx = '/ \$(\w+) /x';
    /**
     * @var null
     */
    public $_regexp = null;
    public $_hasExpression = false;
    public $regexpCache = array();
    public $_result = null;
    public $parser = null;

    /**
     * @param      $rule
     * @param      $ruleParser
     * @param null $peg
     */
    public function __construct($rule, $parser)
    {
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
     * @param \Smarty\Parser\Token $result
     *
     * @return bool
     */
    public function matchRx(&$result, $params)
    {
        if ($this->_hasExpression) {
            $this->_result = $result;
            $key = $this->insert_expression($this->_regexp);
            $this->_result = null;
        } else {
            $key = $this->_regexp;
        }
        $pos = $this->parser->pos;
        if (isset($this->regexpCache[$pos])) {
            $res = $this->regexpCache[$pos];
        } elseif (isset($result['_attr']['matchall'])) {
            if (empty($this->regexpCache) && preg_match_all($key . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                //                var_dump($matches);
                $this->regexpCache[- 1] = true;
                foreach ($matches[0] as $match) {
                    $res = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]));
                    foreach ($match as $n => $v) {
                        if (is_string($n)) {
                            $res['_matchres'][$n] = $v[0];
                        }
                    }
                    $this->regexpCache[$match[1]] = $res;
                    if (isset($result['match'])) {
                        $result['_matchres'] = $match[0];
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
                        $res['_matchres'][$n] = $v[0];
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
            $res['_tag'] = $params['_tag'];
            $res['_name'] = $result['_name'];
            if ($result['_silent'] < 2) {
                $this->parser->ruleMatch($result, $res);
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

