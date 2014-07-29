<?php
namespace Smarty\Parser\Source\Shared\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Value\Number;
use Smarty\Parser\Source\Language\Smarty\Node\Value\String;
use Smarty\Parser\Source\Language\Smarty\Node\Value\Boolean;
use Smarty\Parser\Source\Language\Smarty\Node\Value\Subexpression;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Math;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Unimath;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Unilog;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Condition;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Logical;
use Smarty\Parser\Source\Language\Smarty\Node\Tag\TagStatement;
use Smarty\PegParser;

/**
 * Class ExpressionParser
 *
 * @package Smarty\Parser\Source\Shared\Parser
 */
class ExpressionParser extends PegParser
{

   
    /**
     *
     * Parser generated on 2014-07-13 07:36:15
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Shared/Parser/Expression.peg.inc' dated 2014-07-13 07:36:12
     *
    */

    /**
     Flag that compiled Peg Parser class is valid
     *
     * @var bool
     */
    public $valid = true;

    /**
     * Array of match method names for rules of this Peg Parser
     *
     * @var array
     */
    public $matchMethods = array(
            "Number" => "matchNodeNumber",
            "String" => "matchNodeString",
            "Boolean" => "matchNodeBoolean",
            "Null" => "matchNodeNull",
            "AnyLiteral" => "matchNodeAnyLiteral",
            "Array" => "matchNodeArray",
            "Arrayitem" => "matchNodeArrayitem",
            "Functioncall" => "matchNodeFunctioncall",
            "Parameter" => "matchNodeParameter",
            "Value" => "matchNodeValue",
            "Statement" => "matchNodeStatement",
            "ModifierValue" => "matchNodeModifierValue",
            "Expr" => "matchNodeExpr",
            "Mathexpr" => "matchNodeMathexpr",
            "Logexpr" => "matchNodeLogexpr",
            "Condition" => "matchNodeCondition",
            "NamedCondition" => "matchNodeNamedCondition",
            "NamedCondition2" => "matchNodeNamedCondition2",
            "Logical" => "matchNodeLogical",
            "Math" => "matchNodeMath",
            "Unimath" => "matchNodeUnimath",
            "Unilog" => "matchNodeUnilog"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "Number" => array(
                    "_nodetype" => "node",
                    "hash" => true
                ),
            "String" => array(
                    "_nodetype" => "node",
                    "hash" => true
                ),
            "Boolean" => array(
                    "_nodetype" => "node",
                    "hash" => true
                ),
            "Null" => array(
                    "_nodetype" => "node",
                    "hash" => true
                ),
            "AnyLiteral" => array(
                    "_nodetype" => "token",
                    "hash" => true
                ),
            "Array" => array(
                    "_nodetype" => "token"
                ),
            "Arrayitem" => array(
                    "_nodetype" => "token"
                ),
            "Functioncall" => array(
                    "_nodetype" => "node"
                ),
            "Parameter" => array(
                    "_nodetype" => "token"
                ),
            "Value" => array(
                    "_nodetype" => "token",
                    "hash" => true
                ),
            "Statement" => array(
                    "_nodetype" => "token"
                ),
            "ModifierValue" => array(
                    "_nodetype" => "token",
                    "hash" => true
                ),
            "Expr" => array(
                    "_nodetype" => "token"
                ),
            "Mathexpr" => array(
                    "_nodetype" => "token"
                ),
            "Logexpr" => array(
                    "_nodetype" => "token"
                ),
            "Condition" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "NamedCondition" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "NamedCondition2" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "Logical" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "Math" => array(
                    "_nodetype" => "node",
                    "matchall" => true
                ),
            "Unimath" => array(
                    "_nodetype" => "node",
                    "matchall" => true
                ),
            "Unilog" => array(
                    "_nodetype" => "node",
                    "matchall" => true
                )
        );
    /**
     *
     * Parser rules and action for node 'Number'
     *
     *  Rule:
    

        <node Number>
            <attribute>hash</attribute>
            <rule>/\[0-9]+(?:\.[0-9]+)?/</rule>
            <action _finish>
            {
                $result['node'] = new Number($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

     *
    */
    public function matchNodeNumber($previous, &$errorResult){
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        if (isset($this->parser->packCache[$this->parser->pos]['Number'])) {
            $result = $this->parser->packCache[$this->parser->pos]['Number'];
            $error = $this->parser->errorCache[$this->parser->pos]['Number'];
            if ($result) {
                $this->parser->pos = $result['_endpos'];
                $this->parser->line = $result['_endline'];
            } else {
                $this->parser->matchError($errorResult, 'token', $error, 'Number');
            }
            return $result;
        }
        // Start '/\[0-9]+(?:\.[0-9]+)?/' min '1' max '1'
        $regexp = "/\\[0-9]+(?:\\.[0-9]+)?/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Number2'][$pos])) {
            $subres = $this->parser->regexpCache['Number2'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                if ($subres['_startpos'] != $pos) {
                    $this->parser->regexpCache['Number2'][$subres['_startpos']] = $subres;
                    $this->parser->regexpCache['Number2'][$pos] = false;
                    $subres = false;
                }
            } else {
                $this->parser->regexpCache['Number2'][$pos] = false;
                $subres = false;
            }
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Number';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
            } else {
                $this->parser->matchError($error, 'rx', "/\\[0-9]+(?:\\.[0-9]+)?/");
            }
            // End '/\[0-9]+(?:\.[0-9]+)?/'
            if ($valid) {
                $result['_endpos'] = $this->parser->pos;
                $result['_endline'] = $this->parser->line;
                $this->Number___FINISH($result);
            }
            if (!$valid) {
                $result = false;
                $this->parser->matchError($errorResult, 'token', $error, 'Number');
            }
            $this->parser->packCache[$pos0]['Number'] = $result;
            $this->parser->errorCache[$pos0]['Number'] = $error;
            return $result;
        }

        public function Number___FINISH (&$result) {
            $result['node'] = new Number($this->parser);
            $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
        }


        /**
         *
         * Parser rules and action for node 'String'
         *
         *  Rule:
        <node String>
            <attribute>hash</attribute>
            <rule>/'[^'\\]*(?:\\.[^'\\]*)*'/</rule>
            <action _finish>
            {
                $result['node'] = new String($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

         *
        */
        public function matchNodeString($previous, &$errorResult){
            $result = $this->parser->resultDefault;
            $error = array();
            $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
            $result['_lineno'] = $this->parser->line;
            if (isset($this->parser->packCache[$this->parser->pos]['String'])) {
                $result = $this->parser->packCache[$this->parser->pos]['String'];
                $error = $this->parser->errorCache[$this->parser->pos]['String'];
                if ($result) {
                    $this->parser->pos = $result['_endpos'];
                    $this->parser->line = $result['_endline'];
                } else {
                    $this->parser->matchError($errorResult, 'token', $error, 'String');
                }
                return $result;
            }
            // Start '/'[^'\\]*(?:\\.[^'\\]*)*'/' min '1' max '1'
            $regexp = "/'[^'\\\\]*(?:\\\\.[^'\\\\]*)*'/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['String2'][$pos])) {
                $subres = $this->parser->regexpCache['String2'][$pos];
            } else {
                if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                    if ($subres['_startpos'] != $pos) {
                        $this->parser->regexpCache['String2'][$subres['_startpos']] = $subres;
                        $this->parser->regexpCache['String2'][$pos] = false;
                        $subres = false;
                    }
                } else {
                    $this->parser->regexpCache['String2'][$pos] = false;
                    $subres = false;
                }
            }
            if ($subres) {
                $subres['_lineno'] = $this->parser->line;
                $this->parser->pos = $subres['_endpos'];
                $this->parser->line += substr_count($subres['_text'], "\n");
                $subres['_tag'] = false;
                $subres['_name'] = 'String';
                $valid = true;
            } else {
                $valid = false;
            }
            if ($valid) {
                $result['_text'] .= $subres['_text'];
                } else {
                    $this->parser->matchError($error, 'rx', "/'[^'\\\\]*(?:\\\\.[^'\\\\]*)*'/");
                }
                // End '/'[^'\\]*(?:\\.[^'\\]*)*'/'
                if ($valid) {
                    $result['_endpos'] = $this->parser->pos;
                    $result['_endline'] = $this->parser->line;
                    $this->String___FINISH($result);
                }
                if (!$valid) {
                    $result = false;
                    $this->parser->matchError($errorResult, 'token', $error, 'String');
                }
                $this->parser->packCache[$pos0]['String'] = $result;
                $this->parser->errorCache[$pos0]['String'] = $error;
                return $result;
            }

            public function String___FINISH (&$result) {
                $result['node'] = new String($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }


            /**
             *
             * Parser rules and action for node 'Boolean'
             *
             *  Rule:
            <node Boolean>
            <attribute>hash</attribute>
            <rule>/(true|false)(?![^a-zA-Z0-9])/</rule>
            <action _finish>
            {
                $result['node'] = new Boolean($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

             *
            */
            public function matchNodeBoolean($previous, &$errorResult){
                $result = $this->parser->resultDefault;
                $error = array();
                $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                $result['_lineno'] = $this->parser->line;
                if (isset($this->parser->packCache[$this->parser->pos]['Boolean'])) {
                    $result = $this->parser->packCache[$this->parser->pos]['Boolean'];
                    $error = $this->parser->errorCache[$this->parser->pos]['Boolean'];
                    if ($result) {
                        $this->parser->pos = $result['_endpos'];
                        $this->parser->line = $result['_endline'];
                    } else {
                        $this->parser->matchError($errorResult, 'token', $error, 'Boolean');
                    }
                    return $result;
                }
                // Start '/(true|false)(?![^a-zA-Z0-9])/' min '1' max '1'
                $regexp = "/(true|false)(?![^a-zA-Z0-9])/";
                $pos = $this->parser->pos;
                if (isset($this->parser->regexpCache['Boolean2'][$pos])) {
                    $subres = $this->parser->regexpCache['Boolean2'][$pos];
                } else {
                    if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                        $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                        if ($subres['_startpos'] != $pos) {
                            $this->parser->regexpCache['Boolean2'][$subres['_startpos']] = $subres;
                            $this->parser->regexpCache['Boolean2'][$pos] = false;
                            $subres = false;
                        }
                    } else {
                        $this->parser->regexpCache['Boolean2'][$pos] = false;
                        $subres = false;
                    }
                }
                if ($subres) {
                    $subres['_lineno'] = $this->parser->line;
                    $this->parser->pos = $subres['_endpos'];
                    $this->parser->line += substr_count($subres['_text'], "\n");
                    $subres['_tag'] = false;
                    $subres['_name'] = 'Boolean';
                    $valid = true;
                } else {
                    $valid = false;
                }
                if ($valid) {
                    $result['_text'] .= $subres['_text'];
                    } else {
                        $this->parser->matchError($error, 'rx', "/(true|false)(?![^a-zA-Z0-9])/");
                    }
                    // End '/(true|false)(?![^a-zA-Z0-9])/'
                    if ($valid) {
                        $result['_endpos'] = $this->parser->pos;
                        $result['_endline'] = $this->parser->line;
                        $this->Boolean___FINISH($result);
                    }
                    if (!$valid) {
                        $result = false;
                        $this->parser->matchError($errorResult, 'token', $error, 'Boolean');
                    }
                    $this->parser->packCache[$pos0]['Boolean'] = $result;
                    $this->parser->errorCache[$pos0]['Boolean'] = $error;
                    return $result;
                }

                public function Boolean___FINISH (&$result) {
                    $result['node'] = new Boolean($this->parser);
                    $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
                }


                /**
                 *
                 * Parser rules and action for node 'Null'
                 *
                 *  Rule:
                <node Null>
            <attribute>hash</attribute>
            <rule>/null(?![^a-zA-Z0-9])/</rule>
            <action _finish>
            {
                $result['node'] = new Null($this->parser);
                $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

                 *
                */
                public function matchNodeNull($previous, &$errorResult){
                    $result = $this->parser->resultDefault;
                    $error = array();
                    $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                    $result['_lineno'] = $this->parser->line;
                    if (isset($this->parser->packCache[$this->parser->pos]['Null'])) {
                        $result = $this->parser->packCache[$this->parser->pos]['Null'];
                        $error = $this->parser->errorCache[$this->parser->pos]['Null'];
                        if ($result) {
                            $this->parser->pos = $result['_endpos'];
                            $this->parser->line = $result['_endline'];
                        } else {
                            $this->parser->matchError($errorResult, 'token', $error, 'Null');
                        }
                        return $result;
                    }
                    // Start '/null(?![^a-zA-Z0-9])/' min '1' max '1'
                    $regexp = "/null(?![^a-zA-Z0-9])/";
                    $pos = $this->parser->pos;
                    if (isset($this->parser->regexpCache['Null2'][$pos])) {
                        $subres = $this->parser->regexpCache['Null2'][$pos];
                    } else {
                        if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                            $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                            if ($subres['_startpos'] != $pos) {
                                $this->parser->regexpCache['Null2'][$subres['_startpos']] = $subres;
                                $this->parser->regexpCache['Null2'][$pos] = false;
                                $subres = false;
                            }
                        } else {
                            $this->parser->regexpCache['Null2'][$pos] = false;
                            $subres = false;
                        }
                    }
                    if ($subres) {
                        $subres['_lineno'] = $this->parser->line;
                        $this->parser->pos = $subres['_endpos'];
                        $this->parser->line += substr_count($subres['_text'], "\n");
                        $subres['_tag'] = false;
                        $subres['_name'] = 'Null';
                        $valid = true;
                    } else {
                        $valid = false;
                    }
                    if ($valid) {
                        $result['_text'] .= $subres['_text'];
                        } else {
                            $this->parser->matchError($error, 'rx', "/null(?![^a-zA-Z0-9])/");
                        }
                        // End '/null(?![^a-zA-Z0-9])/'
                        if ($valid) {
                            $result['_endpos'] = $this->parser->pos;
                            $result['_endline'] = $this->parser->line;
                            $this->Null___FINISH($result);
                        }
                        if (!$valid) {
                            $result = false;
                            $this->parser->matchError($errorResult, 'token', $error, 'Null');
                        }
                        $this->parser->packCache[$pos0]['Null'] = $result;
                        $this->parser->errorCache[$pos0]['Null'] = $error;
                        return $result;
                    }

                    public function Null___FINISH (&$result) {
                        $result['node'] = new Null($this->parser);
                        $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
                    }


                    /**
                     *
                     * Parser rules and action for node 'AnyLiteral'
                     *
                     *  Rule:
                    <token AnyLiteral>
            # This combination of basic nodes is implemented for speed optimization
            <attribute>hash</attribute>
            <rule>/(?<number>([0-9]+(?:\.[0-9]+)?))|(?<string>('[^'\\]*(?:\\.[^'\\]*)*'))|(((?<null>null)|(?<bool>(true|false)))(?![_a-zA-Z0-9]))/</rule>
            <action _start> {
                $i = 1;
            }
            </action>
            <action number>
            {
                $result['node'] = new Number($this->parser);
                $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            }
            </action>
            <action string>
            {
                $result['node'] = new String($this->parser);
                $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            }
            </action>
            <action bool>
            {
                $result['node'] = new Boolean($this->parser);
                $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            }
            </action>
            <action null>
            {
                $result['node'] = new Null($this->parser);
                $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            }
            </action>
        </token>

                     *
                    */
                    public function matchNodeAnyLiteral($previous, &$errorResult){
                        $result = $this->parser->resultDefault;
                        $error = array();
                        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                        $result['_lineno'] = $this->parser->line;
                        if (isset($this->parser->packCache[$this->parser->pos]['AnyLiteral'])) {
                            $result = $this->parser->packCache[$this->parser->pos]['AnyLiteral'];
                            $error = $this->parser->errorCache[$this->parser->pos]['AnyLiteral'];
                            if ($result) {
                                $this->parser->pos = $result['_endpos'];
                                $this->parser->line = $result['_endline'];
                            } else {
                                $this->parser->matchError($errorResult, 'token', $error, 'AnyLiteral');
                            }
                            return $result;
                        }
                        $this->AnyLiteral___START($result, $previous);
                        // Start '/(?<number>([0-9]+(?:\.[0-9]+)?))|(?<string>('[^'\\]*(?:\\.[^'\\]*)*'))|(((?<null>null)|(?<bool>(true|false)))(?![_a-zA-Z0-9]))/' min '1' max '1'
                        $regexp = "/(?<number>([0-9]+(?:\\.[0-9]+)?))|(?<string>('[^'\\\\]*(?:\\\\.[^'\\\\]*)*'))|(((?<null>null)|(?<bool>(true|false)))(?![_a-zA-Z0-9]))/";
                        $pos = $this->parser->pos;
                        if (isset($this->parser->regexpCache['AnyLiteral2'][$pos])) {
                            $subres = $this->parser->regexpCache['AnyLiteral2'][$pos];
                        } else {
                            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                                if (strlen($match[0][0]) != 0) {
                                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                                    foreach ($match as $n => $v) {
                                        if (is_string($n) && !empty($v[0])) {
                                            $subres['_matchres'][$n] = $v[0];
                                        }
                                    }
                                    if ($subres['_startpos'] != $pos) {
                                        $this->parser->regexpCache['AnyLiteral2'][$subres['_startpos']] = $subres;
                                        $this->parser->regexpCache['AnyLiteral2'][$pos] = false;
                                        $subres = false;
                                    }
                                } else {
                                    $this->parser->regexpCache['AnyLiteral2'][$pos] = false;
                                    $subres = false;
                                }
                            } else {
                                $this->parser->regexpCache['AnyLiteral2'][$pos] = false;
                                $subres = false;
                            }
                        }
                        if ($subres) {
                            $subres['_lineno'] = $this->parser->line;
                            $this->parser->pos = $subres['_endpos'];
                            $this->parser->line += substr_count($subres['_text'], "\n");
                            $subres['_tag'] = false;
                            $subres['_name'] = 'AnyLiteral';
                            if (isset($subres['_matchres']['number'])) {
                                $this->AnyLiteral_number($result, $subres);
                                unset($subres['_matchres']['number']);
                            }
                            if (isset($subres['_matchres']['string'])) {
                                $this->AnyLiteral_string($result, $subres);
                                unset($subres['_matchres']['string']);
                            }
                            if (isset($subres['_matchres']['null'])) {
                                $this->AnyLiteral_null($result, $subres);
                                unset($subres['_matchres']['null']);
                            }
                            if (isset($subres['_matchres']['bool'])) {
                                $this->AnyLiteral_bool($result, $subres);
                                unset($subres['_matchres']['bool']);
                            }
                            $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
                            $valid = true;
                        } else {
                            $valid = false;
                        }
                        if ($valid) {
                            $result['_text'] .= $subres['_text'];
                            } else {
                                $this->parser->matchError($error, 'rx', "/(?<number>([0-9]+(?:\\.[0-9]+)?))|(?<string>('[^'\\\\]*(?:\\\\.[^'\\\\]*)*'))|(((?<null>null)|(?<bool>(true|false)))(?![_a-zA-Z0-9]))/");
                            }
                            // End '/(?<number>([0-9]+(?:\.[0-9]+)?))|(?<string>('[^'\\]*(?:\\.[^'\\]*)*'))|(((?<null>null)|(?<bool>(true|false)))(?![_a-zA-Z0-9]))/'
                            if ($valid) {
                                $result['_endpos'] = $this->parser->pos;
                                $result['_endline'] = $this->parser->line;
                            }
                            if (!$valid) {
                                $result = false;
                                $this->parser->matchError($errorResult, 'token', $error, 'AnyLiteral');
                            }
                            $this->parser->packCache[$pos0]['AnyLiteral'] = $result;
                            $this->parser->errorCache[$pos0]['AnyLiteral'] = $error;
                            return $result;
                        }

                        public function AnyLiteral___START (&$result, $previous) {
                            $i = 1;
                        }


                        public function AnyLiteral_number (&$result, $subres) {
                            $result['node'] = new Number($this->parser);
                            $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
                        }


                        public function AnyLiteral_string (&$result, $subres) {
                            $result['node'] = new String($this->parser);
                            $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
                        }


                        public function AnyLiteral_bool (&$result, $subres) {
                            $result['node'] = new Boolean($this->parser);
                            $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
                        }


                        public function AnyLiteral_null (&$result, $subres) {
                            $result['node'] = new Null($this->parser);
                            $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
                        }


                        /**
                         *
                         * Parser rules and action for node 'Array'
                         *
                         *  Rule:
                        <token Array>
            <rule> ( 'array' _? '(' item:Arrayitem (',' item:Arrayitem)* ','? ')' ) | ('[' item:Arrayitem (',' item:Arrayitem)* ','? ']')</rule>
        </token>

                         *
                        */
                        public function matchNodeArray($previous, &$errorResult){
                            $result = $this->parser->resultDefault;
                            $error = array();
                            $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                            $result['_lineno'] = $this->parser->line;
                            // Start 'Array' min '1' max '1'
                            // start option
                            $error1 = $error;
                            $errorOption1 =array();
                            $this->parser->addBacktrace(array('_o1_', ''));
                            do {
                                $error = array();
                                array_pop($this->parser->backtrace);
                                $this->parser->addBacktrace(array('_o1:1_', ''));
                                // Start '( 'array' _? '(' item:Arrayitem ( ',' item:Arrayitem)* ','? ')')' min '1' max '1'
                                // start sequence
                                $backup3 = $result;
                                $pos3 = $this->parser->pos;
                                $line3 = $this->parser->line;
                                $error3 = $error;
                                $this->parser->addBacktrace(array('_s3_', ''));
                                do {
                                    $error = array();
                                    // Start ''array'' min '1' max '1'
                                    if ('array' == substr($this->parser->source, $this->parser->pos, 5)) {
                                        $this->parser->pos += 5;
                                        $result['_text'] .= 'array';
                                        $this->parser->successNode(array('\'array\'', 'array'));
                                        $valid = true;
                                    } else {
                                        $this->parser->matchError($error, 'literal', 'array');
                                        $this->parser->failNode(array('\'array\'',  ''));
                                        $valid = false;
                                    }
                                    // End ''array''
                                    if (!$valid) {
                                        $this->parser->matchError($error3, 'SequenceElement', $error);
                                        $error = $error3;
                                        break;
                                    }
                                    $error = array();
                                    // Start '_?' min '1' max '1'
                                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                                        if (!empty($match[0])) {
                                            $this->parser->pos += strlen($match[0]);
                                            $this->parser->line += substr_count($match[0], "\n");
                                            $result['_text'] .= ' ';
                                        }
                                    }
                                    $this->parser->successNode(array("' '",  $match[0]));
                                    $valid = true;
                                    // End '_?'
                                    if (!$valid) {
                                        $this->parser->matchError($error3, 'SequenceElement', $error);
                                        $error = $error3;
                                        break;
                                    }
                                    $error = array();
                                    // Start ''('' min '1' max '1'
                                    if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                                        $this->parser->pos += 1;
                                        $result['_text'] .= '(';
                                        $this->parser->successNode(array('\'(\'', '('));
                                        $valid = true;
                                    } else {
                                        $this->parser->matchError($error, 'literal', '(');
                                        $this->parser->failNode(array('\'(\'',  ''));
                                        $valid = false;
                                    }
                                    // End ''(''
                                    if (!$valid) {
                                        $this->parser->matchError($error3, 'SequenceElement', $error);
                                        $error = $error3;
                                        break;
                                    }
                                    $error = array();
                                    // Start 'item:Arrayitem' tag 'item' min '1' max '1'
                                    $this->parser->addBacktrace(array('Arrayitem', ''));
                                    $subres = $this->parser->matchRule($result, 'Arrayitem', $error);
                                    $remove = array_pop($this->parser->backtrace);
                                    if ($subres) {
                                        $this->parser->successNode(array('Arrayitem',  $subres['_text']));
                                        $result['_text'] .= $subres['_text'];
                                        if(!isset($result['item'])) {
                                            $result['item'] = $subres;
                                        } else {
                                            if (!is_array($result['item'])) {
                                                $result['item'] = array($result['item']);
                                            }
                                            $result['item'][] = $subres;
                                        }
                                        $valid = true;
                                    } else {
                                        $valid = false;
                                        $this->parser->failNode($remove);
                                    }
                                    // End 'item:Arrayitem'
                                    if (!$valid) {
                                        $this->parser->matchError($error3, 'SequenceElement', $error);
                                        $error = $error3;
                                        break;
                                    }
                                    $error = array();
                                    // Start '( ',' item:Arrayitem)*' min '0' max 'null'
                                    $iteration8 = 0;
                                    do {
                                        // start sequence
                                        $backup9 = $result;
                                        $pos9 = $this->parser->pos;
                                        $line9 = $this->parser->line;
                                        $error9 = $error;
                                        $this->parser->addBacktrace(array('_s9_', ''));
                                        do {
                                            $error = array();
                                            // Start '','' min '1' max '1'
                                            if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                $this->parser->pos += 1;
                                                $result['_text'] .= ',';
                                                $this->parser->successNode(array('\',\'', ','));
                                                $valid = true;
                                            } else {
                                                $this->parser->matchError($error, 'literal', ',');
                                                $this->parser->failNode(array('\',\'',  ''));
                                                $valid = false;
                                            }
                                            // End '',''
                                            if (!$valid) {
                                                $this->parser->matchError($error9, 'SequenceElement', $error);
                                                $error = $error9;
                                                break;
                                            }
                                            $error = array();
                                            // Start 'item:Arrayitem' tag 'item' min '1' max '1'
                                            $this->parser->addBacktrace(array('Arrayitem', ''));
                                            $subres = $this->parser->matchRule($result, 'Arrayitem', $error);
                                            $remove = array_pop($this->parser->backtrace);
                                            if ($subres) {
                                                $this->parser->successNode(array('Arrayitem',  $subres['_text']));
                                                $result['_text'] .= $subres['_text'];
                                                if(!isset($result['item'])) {
                                                    $result['item'] = $subres;
                                                } else {
                                                    if (!is_array($result['item'])) {
                                                        $result['item'] = array($result['item']);
                                                    }
                                                    $result['item'][] = $subres;
                                                }
                                                $valid = true;
                                            } else {
                                                $valid = false;
                                                $this->parser->failNode($remove);
                                            }
                                            // End 'item:Arrayitem'
                                            if (!$valid) {
                                                $this->parser->matchError($error9, 'SequenceElement', $error);
                                                $error = $error9;
                                                break;
                                            }
                                            break;
                                        } while (true);
                                        $remove = array_pop($this->parser->backtrace);
                                        if (!$valid) {
                                            $this->parser->failNode($remove);
                                            $this->parser->pos = $pos9;
                                            $this->parser->line = $line9;
                                            $result = $backup9;
                                        } else {
                                            $this->parser->successNode($remove);
                                            }
                                            $error = $error9;
                                            unset($backup9);
                                            // end sequence
                                            $iteration8 = $valid ? ($iteration8 + 1) : $iteration8;
                                            if (!$valid && $iteration8 >= 0) {
                                                $valid = true;
                                                break;
                                            }
                                            if (!$valid) break;
                                        } while (true);
                                        // End '( ',' item:Arrayitem)*'
                                        if (!$valid) {
                                            $this->parser->matchError($error3, 'SequenceElement', $error);
                                            $error = $error3;
                                            break;
                                        }
                                        $error = array();
                                        // Start '','?' min '0' max '1'
                                        $error = array();
                                        if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                                            $this->parser->pos += 1;
                                            $result['_text'] .= ',';
                                            $this->parser->successNode(array('\',\'', ','));
                                            $valid = true;
                                        } else {
                                            $this->parser->matchError($error, 'literal', ',');
                                            $this->parser->failNode(array('\',\'',  ''));
                                            $valid = false;
                                        }
                                        if (!$valid) {
                                            $this->parser->logOption($errorResult, 'Array', $error);
                                        }
                                        $valid = true;
                                        // End '','?'
                                        if (!$valid) {
                                            $this->parser->matchError($error3, 'SequenceElement', $error);
                                            $error = $error3;
                                            break;
                                        }
                                        $error = array();
                                        // Start '')'' min '1' max '1'
                                        if (')' == substr($this->parser->source, $this->parser->pos, 1)) {
                                            $this->parser->pos += 1;
                                            $result['_text'] .= ')';
                                            $this->parser->successNode(array('\')\'', ')'));
                                            $valid = true;
                                        } else {
                                            $this->parser->matchError($error, 'literal', ')');
                                            $this->parser->failNode(array('\')\'',  ''));
                                            $valid = false;
                                        }
                                        // End '')''
                                        if (!$valid) {
                                            $this->parser->matchError($error3, 'SequenceElement', $error);
                                            $error = $error3;
                                            break;
                                        }
                                        break;
                                    } while (true);
                                    $remove = array_pop($this->parser->backtrace);
                                    if (!$valid) {
                                        $this->parser->failNode($remove);
                                        $this->parser->pos = $pos3;
                                        $this->parser->line = $line3;
                                        $result = $backup3;
                                    } else {
                                        $this->parser->successNode($remove);
                                        }
                                        $error = $error3;
                                        unset($backup3);
                                        // end sequence
                                        // End '( 'array' _? '(' item:Arrayitem ( ',' item:Arrayitem)* ','? ')')'
                                        if ($valid) {
                                            $this->parser->successNode(array_pop($this->parser->backtrace));
                                            $error = $error1;
                                            break;
                                        } else {
                                            $this->parser->logOption($errorOption1, 'Array', $error);
                                        }
                                        $error = array();
                                        array_pop($this->parser->backtrace);
                                        $this->parser->addBacktrace(array('_o1:2_', ''));
                                        // Start '( '[' item:Arrayitem ( ',' item:Arrayitem)* ','? ']')' min '1' max '1'
                                        // start sequence
                                        $backup15 = $result;
                                        $pos15 = $this->parser->pos;
                                        $line15 = $this->parser->line;
                                        $error15 = $error;
                                        $this->parser->addBacktrace(array('_s15_', ''));
                                        do {
                                            $error = array();
                                            // Start ''['' min '1' max '1'
                                            if ('[' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                $this->parser->pos += 1;
                                                $result['_text'] .= '[';
                                                $this->parser->successNode(array('\'[\'', '['));
                                                $valid = true;
                                            } else {
                                                $this->parser->matchError($error, 'literal', '[');
                                                $this->parser->failNode(array('\'[\'',  ''));
                                                $valid = false;
                                            }
                                            // End ''[''
                                            if (!$valid) {
                                                $this->parser->matchError($error15, 'SequenceElement', $error);
                                                $error = $error15;
                                                break;
                                            }
                                            $error = array();
                                            // Start 'item:Arrayitem' tag 'item' min '1' max '1'
                                            $this->parser->addBacktrace(array('Arrayitem', ''));
                                            $subres = $this->parser->matchRule($result, 'Arrayitem', $error);
                                            $remove = array_pop($this->parser->backtrace);
                                            if ($subres) {
                                                $this->parser->successNode(array('Arrayitem',  $subres['_text']));
                                                $result['_text'] .= $subres['_text'];
                                                if(!isset($result['item'])) {
                                                    $result['item'] = $subres;
                                                } else {
                                                    if (!is_array($result['item'])) {
                                                        $result['item'] = array($result['item']);
                                                    }
                                                    $result['item'][] = $subres;
                                                }
                                                $valid = true;
                                            } else {
                                                $valid = false;
                                                $this->parser->failNode($remove);
                                            }
                                            // End 'item:Arrayitem'
                                            if (!$valid) {
                                                $this->parser->matchError($error15, 'SequenceElement', $error);
                                                $error = $error15;
                                                break;
                                            }
                                            $error = array();
                                            // Start '( ',' item:Arrayitem)*' min '0' max 'null'
                                            $iteration18 = 0;
                                            do {
                                                // start sequence
                                                $backup19 = $result;
                                                $pos19 = $this->parser->pos;
                                                $line19 = $this->parser->line;
                                                $error19 = $error;
                                                $this->parser->addBacktrace(array('_s19_', ''));
                                                do {
                                                    $error = array();
                                                    // Start '','' min '1' max '1'
                                                    if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                        $this->parser->pos += 1;
                                                        $result['_text'] .= ',';
                                                        $this->parser->successNode(array('\',\'', ','));
                                                        $valid = true;
                                                    } else {
                                                        $this->parser->matchError($error, 'literal', ',');
                                                        $this->parser->failNode(array('\',\'',  ''));
                                                        $valid = false;
                                                    }
                                                    // End '',''
                                                    if (!$valid) {
                                                        $this->parser->matchError($error19, 'SequenceElement', $error);
                                                        $error = $error19;
                                                        break;
                                                    }
                                                    $error = array();
                                                    // Start 'item:Arrayitem' tag 'item' min '1' max '1'
                                                    $this->parser->addBacktrace(array('Arrayitem', ''));
                                                    $subres = $this->parser->matchRule($result, 'Arrayitem', $error);
                                                    $remove = array_pop($this->parser->backtrace);
                                                    if ($subres) {
                                                        $this->parser->successNode(array('Arrayitem',  $subres['_text']));
                                                        $result['_text'] .= $subres['_text'];
                                                        if(!isset($result['item'])) {
                                                            $result['item'] = $subres;
                                                        } else {
                                                            if (!is_array($result['item'])) {
                                                                $result['item'] = array($result['item']);
                                                            }
                                                            $result['item'][] = $subres;
                                                        }
                                                        $valid = true;
                                                    } else {
                                                        $valid = false;
                                                        $this->parser->failNode($remove);
                                                    }
                                                    // End 'item:Arrayitem'
                                                    if (!$valid) {
                                                        $this->parser->matchError($error19, 'SequenceElement', $error);
                                                        $error = $error19;
                                                        break;
                                                    }
                                                    break;
                                                } while (true);
                                                $remove = array_pop($this->parser->backtrace);
                                                if (!$valid) {
                                                    $this->parser->failNode($remove);
                                                    $this->parser->pos = $pos19;
                                                    $this->parser->line = $line19;
                                                    $result = $backup19;
                                                } else {
                                                    $this->parser->successNode($remove);
                                                    }
                                                    $error = $error19;
                                                    unset($backup19);
                                                    // end sequence
                                                    $iteration18 = $valid ? ($iteration18 + 1) : $iteration18;
                                                    if (!$valid && $iteration18 >= 0) {
                                                        $valid = true;
                                                        break;
                                                    }
                                                    if (!$valid) break;
                                                } while (true);
                                                // End '( ',' item:Arrayitem)*'
                                                if (!$valid) {
                                                    $this->parser->matchError($error15, 'SequenceElement', $error);
                                                    $error = $error15;
                                                    break;
                                                }
                                                $error = array();
                                                // Start '','?' min '0' max '1'
                                                $error = array();
                                                if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                    $this->parser->pos += 1;
                                                    $result['_text'] .= ',';
                                                    $this->parser->successNode(array('\',\'', ','));
                                                    $valid = true;
                                                } else {
                                                    $this->parser->matchError($error, 'literal', ',');
                                                    $this->parser->failNode(array('\',\'',  ''));
                                                    $valid = false;
                                                }
                                                if (!$valid) {
                                                    $this->parser->logOption($errorResult, 'Array', $error);
                                                }
                                                $valid = true;
                                                // End '','?'
                                                if (!$valid) {
                                                    $this->parser->matchError($error15, 'SequenceElement', $error);
                                                    $error = $error15;
                                                    break;
                                                }
                                                $error = array();
                                                // Start '']'' min '1' max '1'
                                                if (']' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                    $this->parser->pos += 1;
                                                    $result['_text'] .= ']';
                                                    $this->parser->successNode(array('\']\'', ']'));
                                                    $valid = true;
                                                } else {
                                                    $this->parser->matchError($error, 'literal', ']');
                                                    $this->parser->failNode(array('\']\'',  ''));
                                                    $valid = false;
                                                }
                                                // End '']''
                                                if (!$valid) {
                                                    $this->parser->matchError($error15, 'SequenceElement', $error);
                                                    $error = $error15;
                                                    break;
                                                }
                                                break;
                                            } while (true);
                                            $remove = array_pop($this->parser->backtrace);
                                            if (!$valid) {
                                                $this->parser->failNode($remove);
                                                $this->parser->pos = $pos15;
                                                $this->parser->line = $line15;
                                                $result = $backup15;
                                            } else {
                                                $this->parser->successNode($remove);
                                                }
                                                $error = $error15;
                                                unset($backup15);
                                                // end sequence
                                                // End '( '[' item:Arrayitem ( ',' item:Arrayitem)* ','? ']')'
                                                if ($valid) {
                                                    $this->parser->successNode(array_pop($this->parser->backtrace));
                                                    $error = $error1;
                                                    break;
                                                } else {
                                                    $this->parser->logOption($errorOption1, 'Array', $error);
                                                }
                                                $error = $error1;
                                                array_pop($this->parser->backtrace);
                                                break;
                                            } while (true);
                                            // end option
                                            // End 'Array'
                                            if ($valid) {
                                                $result['_endpos'] = $this->parser->pos;
                                                $result['_endline'] = $this->parser->line;
                                            }
                                            if (!$valid) {
                                                $result = false;
                                                $this->parser->matchError($errorResult, 'token', $error, 'Array');
                                            }
                                            return $result;
                                        }

                                        /**
                                         *
                                         * Parser rules and action for node 'Arrayitem'
                                         *
                                         *  Rule:
                                        <token  Arrayitem>
           <rule> ( index:Value _? '=>' _?)? value:Value  </rule>
        </token>

                                         *
                                        */
                                        public function matchNodeArrayitem($previous, &$errorResult){
                                            $result = $this->parser->resultDefault;
                                            $error = array();
                                            $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                            $result['_lineno'] = $this->parser->line;
                                            // Start '( index:Value _? '=>' _?)?' min '0' max '1'
                                            $error = array();
                                            // start sequence
                                            $backup1 = $result;
                                            $pos1 = $this->parser->pos;
                                            $line1 = $this->parser->line;
                                            $error1 = $error;
                                            $this->parser->addBacktrace(array('_s1_', ''));
                                            do {
                                                $error = array();
                                                // Start 'index:Value' tag 'index' min '1' max '1'
                                                $this->parser->addBacktrace(array('Value', ''));
                                                $subres = $this->parser->matchRule($result, 'Value', $error);
                                                $remove = array_pop($this->parser->backtrace);
                                                if ($subres) {
                                                    $this->parser->successNode(array('Value',  $subres['_text']));
                                                    $result['_text'] .= $subres['_text'];
                                                    if(!isset($result['index'])) {
                                                        $result['index'] = $subres;
                                                    } else {
                                                        if (!is_array($result['index'])) {
                                                            $result['index'] = array($result['index']);
                                                        }
                                                        $result['index'][] = $subres;
                                                    }
                                                    $valid = true;
                                                } else {
                                                    $valid = false;
                                                    $this->parser->failNode($remove);
                                                }
                                                // End 'index:Value'
                                                if (!$valid) {
                                                    $this->parser->matchError($error1, 'SequenceElement', $error);
                                                    $error = $error1;
                                                    break;
                                                }
                                                $error = array();
                                                // Start '_?' min '1' max '1'
                                                if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                                                    if (!empty($match[0])) {
                                                        $this->parser->pos += strlen($match[0]);
                                                        $this->parser->line += substr_count($match[0], "\n");
                                                        $result['_text'] .= ' ';
                                                    }
                                                }
                                                $this->parser->successNode(array("' '",  $match[0]));
                                                $valid = true;
                                                // End '_?'
                                                if (!$valid) {
                                                    $this->parser->matchError($error1, 'SequenceElement', $error);
                                                    $error = $error1;
                                                    break;
                                                }
                                                $error = array();
                                                // Start ''=>'' min '1' max '1'
                                                if ('=>' == substr($this->parser->source, $this->parser->pos, 2)) {
                                                    $this->parser->pos += 2;
                                                    $result['_text'] .= '=>';
                                                    $this->parser->successNode(array('\'=>\'', '=>'));
                                                    $valid = true;
                                                } else {
                                                    $this->parser->matchError($error, 'literal', '=>');
                                                    $this->parser->failNode(array('\'=>\'',  ''));
                                                    $valid = false;
                                                }
                                                // End ''=>''
                                                if (!$valid) {
                                                    $this->parser->matchError($error1, 'SequenceElement', $error);
                                                    $error = $error1;
                                                    break;
                                                }
                                                $error = array();
                                                // Start '_?' min '1' max '1'
                                                if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                                                    if (!empty($match[0])) {
                                                        $this->parser->pos += strlen($match[0]);
                                                        $this->parser->line += substr_count($match[0], "\n");
                                                        $result['_text'] .= ' ';
                                                    }
                                                }
                                                $this->parser->successNode(array("' '",  $match[0]));
                                                $valid = true;
                                                // End '_?'
                                                if (!$valid) {
                                                    $this->parser->matchError($error1, 'SequenceElement', $error);
                                                    $error = $error1;
                                                    break;
                                                }
                                                $error = array();
                                                // Start 'value:Value' tag 'value' min '1' max '1'
                                                $this->parser->addBacktrace(array('Value', ''));
                                                $subres = $this->parser->matchRule($result, 'Value', $error);
                                                $remove = array_pop($this->parser->backtrace);
                                                if ($subres) {
                                                    $this->parser->successNode(array('Value',  $subres['_text']));
                                                    $result['_text'] .= $subres['_text'];
                                                    if(!isset($result['value'])) {
                                                        $result['value'] = $subres;
                                                    } else {
                                                        if (!is_array($result['value'])) {
                                                            $result['value'] = array($result['value']);
                                                        }
                                                        $result['value'][] = $subres;
                                                    }
                                                    $valid = true;
                                                } else {
                                                    $valid = false;
                                                    $this->parser->failNode($remove);
                                                }
                                                // End 'value:Value'
                                                if (!$valid) {
                                                    $this->parser->matchError($error1, 'SequenceElement', $error);
                                                    $error = $error1;
                                                    break;
                                                }
                                                break;
                                            } while (true);
                                            $remove = array_pop($this->parser->backtrace);
                                            if (!$valid) {
                                                $this->parser->failNode($remove);
                                                $this->parser->pos = $pos1;
                                                $this->parser->line = $line1;
                                                $result = $backup1;
                                            } else {
                                                $this->parser->successNode($remove);
                                                }
                                                $error = $error1;
                                                unset($backup1);
                                                // end sequence
                                                if (!$valid) {
                                                    $this->parser->logOption($errorResult, 'Arrayitem', $error);
                                                }
                                                $valid = true;
                                                // End '( index:Value _? '=>' _?)?'
                                                if ($valid) {
                                                    $result['_endpos'] = $this->parser->pos;
                                                    $result['_endline'] = $this->parser->line;
                                                }
                                                if (!$valid) {
                                                    $result = false;
                                                    $this->parser->matchError($errorResult, 'token', $error, 'Arrayitem');
                                                }
                                                return $result;
                                            }

                                            /**
                                             *
                                             * Parser rules and action for node 'Functioncall'
                                             *
                                             *  Rule:
                                            <node Functioncall>
            <rule>(name:Id | namevar:Variable) param:Parameter</rule>
            <action name>
            {
                $result['name'] = $subres['_text'];
            }
            </action>
            <action namevar>
            {
                $result['namevar'] = $subres['node'];
            }
            </action>
            <action param>
            {
                $result['node'] = new Node($this->parser, 'Functioncall');
                if (isset($result['name'])) {
                    $string = new String($this->parser);
                    $string->setValue($result['name'], true);
                    $result['node']->addSubTree($string, 'name');
                } else {
                    $result['node']->addSubTree($result['namevar'], 'name');
                }
                $result['node']->addSubTree(isset($subres['funcpar']) ? $subres['funcpar'] : false, 'param');
            }
            </action>
        </node>

                                             *
                                            */
                                            public function matchNodeFunctioncall($previous, &$errorResult){
                                                $result = $this->parser->resultDefault;
                                                $error = array();
                                                $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                $result['_lineno'] = $this->parser->line;
                                                // Start 'Functioncall' min '1' max '1'
                                                // start sequence
                                                $backup1 = $result;
                                                $pos1 = $this->parser->pos;
                                                $line1 = $this->parser->line;
                                                $error1 = $error;
                                                $this->parser->addBacktrace(array('_s1_', ''));
                                                do {
                                                    $error = array();
                                                    // Start '( name:Id | namevar:Variable)' min '1' max '1'
                                                    // start option
                                                    $error3 = $error;
                                                    $errorOption3 =array();
                                                    $this->parser->addBacktrace(array('_o3_', ''));
                                                    do {
                                                        $error = array();
                                                        array_pop($this->parser->backtrace);
                                                        $this->parser->addBacktrace(array('_o3:1_', ''));
                                                        // Start 'name:Id' tag 'name' min '1' max '1'
                                                        $this->parser->addBacktrace(array('Id', ''));
                                                        $subres = $this->parser->matchRule($result, 'Id', $error);
                                                        $remove = array_pop($this->parser->backtrace);
                                                        if ($subres) {
                                                            $this->parser->successNode(array('Id',  $subres['_text']));
                                                            $result['_text'] .= $subres['_text'];
                                                            $this->Functioncall_name($result, $subres);
                                                            $valid = true;
                                                        } else {
                                                            $valid = false;
                                                            $this->parser->failNode($remove);
                                                        }
                                                        // End 'name:Id'
                                                        if ($valid) {
                                                            $this->parser->successNode(array_pop($this->parser->backtrace));
                                                            $error = $error3;
                                                            break;
                                                        } else {
                                                            $this->parser->logOption($errorOption3, 'Functioncall', $error);
                                                        }
                                                        $error = array();
                                                        array_pop($this->parser->backtrace);
                                                        $this->parser->addBacktrace(array('_o3:2_', ''));
                                                        // Start 'namevar:Variable' tag 'namevar' min '1' max '1'
                                                        $this->parser->addBacktrace(array('Variable', ''));
                                                        $subres = $this->parser->matchRule($result, 'Variable', $error);
                                                        $remove = array_pop($this->parser->backtrace);
                                                        if ($subres) {
                                                            $this->parser->successNode(array('Variable',  $subres['_text']));
                                                            $result['_text'] .= $subres['_text'];
                                                            $this->Functioncall_namevar($result, $subres);
                                                            $valid = true;
                                                        } else {
                                                            $valid = false;
                                                            $this->parser->failNode($remove);
                                                        }
                                                        // End 'namevar:Variable'
                                                        if ($valid) {
                                                            $this->parser->successNode(array_pop($this->parser->backtrace));
                                                            $error = $error3;
                                                            break;
                                                        } else {
                                                            $this->parser->logOption($errorOption3, 'Functioncall', $error);
                                                        }
                                                        $error = $error3;
                                                        array_pop($this->parser->backtrace);
                                                        break;
                                                    } while (true);
                                                    // end option
                                                    // End '( name:Id | namevar:Variable)'
                                                    if (!$valid) {
                                                        $this->parser->matchError($error1, 'SequenceElement', $error);
                                                        $error = $error1;
                                                        break;
                                                    }
                                                    $error = array();
                                                    // Start 'param:Parameter' tag 'param' min '1' max '1'
                                                    $this->parser->addBacktrace(array('Parameter', ''));
                                                    $subres = $this->parser->matchRule($result, 'Parameter', $error);
                                                    $remove = array_pop($this->parser->backtrace);
                                                    if ($subres) {
                                                        $this->parser->successNode(array('Parameter',  $subres['_text']));
                                                        $result['_text'] .= $subres['_text'];
                                                        $this->Functioncall_param($result, $subres);
                                                        $valid = true;
                                                    } else {
                                                        $valid = false;
                                                        $this->parser->failNode($remove);
                                                    }
                                                    // End 'param:Parameter'
                                                    if (!$valid) {
                                                        $this->parser->matchError($error1, 'SequenceElement', $error);
                                                        $error = $error1;
                                                        break;
                                                    }
                                                    break;
                                                } while (true);
                                                $remove = array_pop($this->parser->backtrace);
                                                if (!$valid) {
                                                    $this->parser->failNode($remove);
                                                    $this->parser->pos = $pos1;
                                                    $this->parser->line = $line1;
                                                    $result = $backup1;
                                                } else {
                                                    $this->parser->successNode($remove);
                                                    }
                                                    $error = $error1;
                                                    unset($backup1);
                                                    // end sequence
                                                    // End 'Functioncall'
                                                    if ($valid) {
                                                        $result['_endpos'] = $this->parser->pos;
                                                        $result['_endline'] = $this->parser->line;
                                                    }
                                                    if (!$valid) {
                                                        $result = false;
                                                        $this->parser->matchError($errorResult, 'token', $error, 'Functioncall');
                                                    }
                                                    return $result;
                                                }

                                                public function Functioncall_name (&$result, $subres) {
                                                    $result['name'] = $subres['_text'];
                                                }


                                                public function Functioncall_namevar (&$result, $subres) {
                                                    $result['namevar'] = $subres['node'];
                                                }


                                                public function Functioncall_param (&$result, $subres) {
                                                    $result['node'] = new Node($this->parser, 'Functioncall');
                                                    if (isset($result['name'])) {
                                                        $string = new String($this->parser);
                                                        $string->setValue($result['name'], true);
                                                        $result['node']->addSubTree($string, 'name');
                                                    }
                                                    else {
                                                        $result['node']->addSubTree($result['namevar'], 'name');
                                                    }
                                                    $result['node']->addSubTree(isset($subres['funcpar']) ? $subres['funcpar'] : false, 'param');
                                                }


                                                /**
                                                 *
                                                 * Parser rules and action for node 'Parameter'
                                                 *
                                                 *  Rule:
                                                <token Parameter>
            <rule> '(' ( param:Expr ( ',' param:Expr)*)? ')' </rule>
            <action param>
            {
                $result['funcpar'][] = $subres['node'];
            }
            </action>
        </token>

                                                 *
                                                */
                                                public function matchNodeParameter($previous, &$errorResult){
                                                    $result = $this->parser->resultDefault;
                                                    $error = array();
                                                    $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                    $result['_lineno'] = $this->parser->line;
                                                    // Start 'Parameter' min '1' max '1'
                                                    // start sequence
                                                    $backup1 = $result;
                                                    $pos1 = $this->parser->pos;
                                                    $line1 = $this->parser->line;
                                                    $error1 = $error;
                                                    $this->parser->addBacktrace(array('_s1_', ''));
                                                    do {
                                                        $error = array();
                                                        // Start ''('' min '1' max '1'
                                                        if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                            $this->parser->pos += 1;
                                                            $result['_text'] .= '(';
                                                            $this->parser->successNode(array('\'(\'', '('));
                                                            $valid = true;
                                                        } else {
                                                            $this->parser->matchError($error, 'literal', '(');
                                                            $this->parser->failNode(array('\'(\'',  ''));
                                                            $valid = false;
                                                        }
                                                        // End ''(''
                                                        if (!$valid) {
                                                            $this->parser->matchError($error1, 'SequenceElement', $error);
                                                            $error = $error1;
                                                            break;
                                                        }
                                                        $error = array();
                                                        // Start '( param:Expr ( ',' param:Expr)*)?' min '0' max '1'
                                                        $error = array();
                                                        // start sequence
                                                        $backup4 = $result;
                                                        $pos4 = $this->parser->pos;
                                                        $line4 = $this->parser->line;
                                                        $error4 = $error;
                                                        $this->parser->addBacktrace(array('_s4_', ''));
                                                        do {
                                                            $error = array();
                                                            // Start 'param:Expr' tag 'param' min '1' max '1'
                                                            $this->parser->addBacktrace(array('Expr', ''));
                                                            $subres = $this->parser->matchRule($result, 'Expr', $error);
                                                            $remove = array_pop($this->parser->backtrace);
                                                            if ($subres) {
                                                                $this->parser->successNode(array('Expr',  $subres['_text']));
                                                                $result['_text'] .= $subres['_text'];
                                                                $this->Parameter_param($result, $subres);
                                                                $valid = true;
                                                            } else {
                                                                $valid = false;
                                                                $this->parser->failNode($remove);
                                                            }
                                                            // End 'param:Expr'
                                                            if (!$valid) {
                                                                $this->parser->matchError($error4, 'SequenceElement', $error);
                                                                $error = $error4;
                                                                break;
                                                            }
                                                            $error = array();
                                                            // Start '( ',' param:Expr)*' min '0' max 'null'
                                                            $iteration6 = 0;
                                                            do {
                                                                // start sequence
                                                                $backup7 = $result;
                                                                $pos7 = $this->parser->pos;
                                                                $line7 = $this->parser->line;
                                                                $error7 = $error;
                                                                $this->parser->addBacktrace(array('_s7_', ''));
                                                                do {
                                                                    $error = array();
                                                                    // Start '','' min '1' max '1'
                                                                    if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                                        $this->parser->pos += 1;
                                                                        $result['_text'] .= ',';
                                                                        $this->parser->successNode(array('\',\'', ','));
                                                                        $valid = true;
                                                                    } else {
                                                                        $this->parser->matchError($error, 'literal', ',');
                                                                        $this->parser->failNode(array('\',\'',  ''));
                                                                        $valid = false;
                                                                    }
                                                                    // End '',''
                                                                    if (!$valid) {
                                                                        $this->parser->matchError($error7, 'SequenceElement', $error);
                                                                        $error = $error7;
                                                                        break;
                                                                    }
                                                                    $error = array();
                                                                    // Start 'param:Expr' tag 'param' min '1' max '1'
                                                                    $this->parser->addBacktrace(array('Expr', ''));
                                                                    $subres = $this->parser->matchRule($result, 'Expr', $error);
                                                                    $remove = array_pop($this->parser->backtrace);
                                                                    if ($subres) {
                                                                        $this->parser->successNode(array('Expr',  $subres['_text']));
                                                                        $result['_text'] .= $subres['_text'];
                                                                        $this->Parameter_param($result, $subres);
                                                                        $valid = true;
                                                                    } else {
                                                                        $valid = false;
                                                                        $this->parser->failNode($remove);
                                                                    }
                                                                    // End 'param:Expr'
                                                                    if (!$valid) {
                                                                        $this->parser->matchError($error7, 'SequenceElement', $error);
                                                                        $error = $error7;
                                                                        break;
                                                                    }
                                                                    break;
                                                                } while (true);
                                                                $remove = array_pop($this->parser->backtrace);
                                                                if (!$valid) {
                                                                    $this->parser->failNode($remove);
                                                                    $this->parser->pos = $pos7;
                                                                    $this->parser->line = $line7;
                                                                    $result = $backup7;
                                                                } else {
                                                                    $this->parser->successNode($remove);
                                                                    }
                                                                    $error = $error7;
                                                                    unset($backup7);
                                                                    // end sequence
                                                                    $iteration6 = $valid ? ($iteration6 + 1) : $iteration6;
                                                                    if (!$valid && $iteration6 >= 0) {
                                                                        $valid = true;
                                                                        break;
                                                                    }
                                                                    if (!$valid) break;
                                                                } while (true);
                                                                // End '( ',' param:Expr)*'
                                                                if (!$valid) {
                                                                    $this->parser->matchError($error4, 'SequenceElement', $error);
                                                                    $error = $error4;
                                                                    break;
                                                                }
                                                                break;
                                                            } while (true);
                                                            $remove = array_pop($this->parser->backtrace);
                                                            if (!$valid) {
                                                                $this->parser->failNode($remove);
                                                                $this->parser->pos = $pos4;
                                                                $this->parser->line = $line4;
                                                                $result = $backup4;
                                                            } else {
                                                                $this->parser->successNode($remove);
                                                                }
                                                                $error = $error4;
                                                                unset($backup4);
                                                                // end sequence
                                                                if (!$valid) {
                                                                    $this->parser->logOption($errorResult, 'Parameter', $error);
                                                                }
                                                                $valid = true;
                                                                // End '( param:Expr ( ',' param:Expr)*)?'
                                                                if (!$valid) {
                                                                    $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                    $error = $error1;
                                                                    break;
                                                                }
                                                                $error = array();
                                                                // Start '')'' min '1' max '1'
                                                                if (')' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                                    $this->parser->pos += 1;
                                                                    $result['_text'] .= ')';
                                                                    $this->parser->successNode(array('\')\'', ')'));
                                                                    $valid = true;
                                                                } else {
                                                                    $this->parser->matchError($error, 'literal', ')');
                                                                    $this->parser->failNode(array('\')\'',  ''));
                                                                    $valid = false;
                                                                }
                                                                // End '')''
                                                                if (!$valid) {
                                                                    $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                    $error = $error1;
                                                                    break;
                                                                }
                                                                break;
                                                            } while (true);
                                                            $remove = array_pop($this->parser->backtrace);
                                                            if (!$valid) {
                                                                $this->parser->failNode($remove);
                                                                $this->parser->pos = $pos1;
                                                                $this->parser->line = $line1;
                                                                $result = $backup1;
                                                            } else {
                                                                $this->parser->successNode($remove);
                                                                }
                                                                $error = $error1;
                                                                unset($backup1);
                                                                // end sequence
                                                                // End 'Parameter'
                                                                if ($valid) {
                                                                    $result['_endpos'] = $this->parser->pos;
                                                                    $result['_endline'] = $this->parser->line;
                                                                }
                                                                if (!$valid) {
                                                                    $result = false;
                                                                    $this->parser->matchError($errorResult, 'token', $error, 'Parameter');
                                                                }
                                                                return $result;
                                                            }

                                                            public function Parameter_param (&$result, $subres) {
                                                                $result['funcpar'][] = $subres['node'];
                                                            }


                                                            /**
                                                             *
                                                             * Parser rules and action for node 'Value'
                                                             *
                                                             *  Rule:
                                                            <token Value>
            <attribute>hash</attribute>
            <rule>  (value:Variable !'(') | value:AnyLiteral | ( '(' subexpr:Expr ')' ) | value:Functioncall  | value:Array </rule>
            <action value>
            {
                $result['node'] = $subres['node'];
            }
            </action>
            <action subexpr>
            {
                $result['node'] = new Subexpression($this->parser, $subres['node']);
            }
            </action>
        </token>

                                                             *
                                                            */
                                                            public function matchNodeValue($previous, &$errorResult){
                                                                $result = $this->parser->resultDefault;
                                                                $error = array();
                                                                $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                $result['_lineno'] = $this->parser->line;
                                                                if (isset($this->parser->packCache[$this->parser->pos]['Value'])) {
                                                                    $result = $this->parser->packCache[$this->parser->pos]['Value'];
                                                                    $error = $this->parser->errorCache[$this->parser->pos]['Value'];
                                                                    if ($result) {
                                                                        $this->parser->pos = $result['_endpos'];
                                                                        $this->parser->line = $result['_endline'];
                                                                    } else {
                                                                        $this->parser->matchError($errorResult, 'token', $error, 'Value');
                                                                    }
                                                                    return $result;
                                                                }
                                                                // Start 'Value' min '1' max '1'
                                                                // start option
                                                                $error1 = $error;
                                                                $errorOption1 =array();
                                                                $this->parser->addBacktrace(array('_o1_', ''));
                                                                do {
                                                                    $error = array();
                                                                    array_pop($this->parser->backtrace);
                                                                    $this->parser->addBacktrace(array('_o1:1_', ''));
                                                                    // Start '( value:Variable !'(')' min '1' max '1'
                                                                    // start sequence
                                                                    $backup3 = $result;
                                                                    $pos3 = $this->parser->pos;
                                                                    $line3 = $this->parser->line;
                                                                    $error3 = $error;
                                                                    $this->parser->addBacktrace(array('_s3_', ''));
                                                                    do {
                                                                        $error = array();
                                                                        // Start 'value:Variable' tag 'value' min '1' max '1'
                                                                        $this->parser->addBacktrace(array('Variable', ''));
                                                                        $subres = $this->parser->matchRule($result, 'Variable', $error);
                                                                        $remove = array_pop($this->parser->backtrace);
                                                                        if ($subres) {
                                                                            $this->parser->successNode(array('Variable',  $subres['_text']));
                                                                            $result['_text'] .= $subres['_text'];
                                                                            $this->Value_value($result, $subres);
                                                                            $valid = true;
                                                                        } else {
                                                                            $valid = false;
                                                                            $this->parser->failNode($remove);
                                                                        }
                                                                        // End 'value:Variable'
                                                                        if (!$valid) {
                                                                            $this->parser->matchError($error3, 'SequenceElement', $error);
                                                                            $error = $error3;
                                                                            break;
                                                                        }
                                                                        $error = array();
                                                                        // Start '!'('' min '1' max '1' negative lookahead
                                                                        $backup5 = $result;
                                                                        $pos5 = $this->parser->pos;
                                                                        $line5 = $this->parser->line;
                                                                        if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                                            $this->parser->pos += 1;
                                                                            $result['_text'] .= '(';
                                                                            $this->parser->successNode(array('\'(\'', '('));
                                                                            $this->parser->shouldNotMatchError($error, 'literal', '(');
                                                                            $valid = false;
                                                                        } else {
                                                                            $this->parser->failNode(array('\'(\'',  ''));
                                                                            $valid = true;
                                                                        }
                                                                        $this->parser->pos = $pos5;
                                                                        $this->parser->line = $line5;
                                                                        $result = $backup5;
                                                                        unset($backup5);
                                                                        // End '!'(''
                                                                        if (!$valid) {
                                                                            $this->parser->matchError($error3, 'SequenceElement', $error);
                                                                            $error = $error3;
                                                                            break;
                                                                        }
                                                                        break;
                                                                    } while (true);
                                                                    $remove = array_pop($this->parser->backtrace);
                                                                    if (!$valid) {
                                                                        $this->parser->failNode($remove);
                                                                        $this->parser->pos = $pos3;
                                                                        $this->parser->line = $line3;
                                                                        $result = $backup3;
                                                                    } else {
                                                                        $this->parser->successNode($remove);
                                                                        }
                                                                        $error = $error3;
                                                                        unset($backup3);
                                                                        // end sequence
                                                                        // End '( value:Variable !'(')'
                                                                        if ($valid) {
                                                                            $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                            $error = $error1;
                                                                            break;
                                                                        } else {
                                                                            $this->parser->logOption($errorOption1, 'Value', $error);
                                                                        }
                                                                        $error = array();
                                                                        array_pop($this->parser->backtrace);
                                                                        $this->parser->addBacktrace(array('_o1:2_', ''));
                                                                        // Start 'value:AnyLiteral' tag 'value' min '1' max '1'
                                                                        $this->parser->addBacktrace(array('AnyLiteral', ''));
                                                                        $subres = $this->parser->matchRule($result, 'AnyLiteral', $error);
                                                                        $remove = array_pop($this->parser->backtrace);
                                                                        if ($subres) {
                                                                            $this->parser->successNode(array('AnyLiteral',  $subres['_text']));
                                                                            $result['_text'] .= $subres['_text'];
                                                                            $this->Value_value($result, $subres);
                                                                            $valid = true;
                                                                        } else {
                                                                            $valid = false;
                                                                            $this->parser->failNode($remove);
                                                                        }
                                                                        // End 'value:AnyLiteral'
                                                                        if ($valid) {
                                                                            $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                            $error = $error1;
                                                                            break;
                                                                        } else {
                                                                            $this->parser->logOption($errorOption1, 'Value', $error);
                                                                        }
                                                                        $error = array();
                                                                        array_pop($this->parser->backtrace);
                                                                        $this->parser->addBacktrace(array('_o1:3_', ''));
                                                                        // Start '( '(' subexpr:Expr ')')' min '1' max '1'
                                                                        // start sequence
                                                                        $backup8 = $result;
                                                                        $pos8 = $this->parser->pos;
                                                                        $line8 = $this->parser->line;
                                                                        $error8 = $error;
                                                                        $this->parser->addBacktrace(array('_s8_', ''));
                                                                        do {
                                                                            $error = array();
                                                                            // Start ''('' min '1' max '1'
                                                                            if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                                                $this->parser->pos += 1;
                                                                                $result['_text'] .= '(';
                                                                                $this->parser->successNode(array('\'(\'', '('));
                                                                                $valid = true;
                                                                            } else {
                                                                                $this->parser->matchError($error, 'literal', '(');
                                                                                $this->parser->failNode(array('\'(\'',  ''));
                                                                                $valid = false;
                                                                            }
                                                                            // End ''(''
                                                                            if (!$valid) {
                                                                                $this->parser->matchError($error8, 'SequenceElement', $error);
                                                                                $error = $error8;
                                                                                break;
                                                                            }
                                                                            $error = array();
                                                                            // Start 'subexpr:Expr' tag 'subexpr' min '1' max '1'
                                                                            $this->parser->addBacktrace(array('Expr', ''));
                                                                            $subres = $this->parser->matchRule($result, 'Expr', $error);
                                                                            $remove = array_pop($this->parser->backtrace);
                                                                            if ($subres) {
                                                                                $this->parser->successNode(array('Expr',  $subres['_text']));
                                                                                $result['_text'] .= $subres['_text'];
                                                                                $this->Value_subexpr($result, $subres);
                                                                                $valid = true;
                                                                            } else {
                                                                                $valid = false;
                                                                                $this->parser->failNode($remove);
                                                                            }
                                                                            // End 'subexpr:Expr'
                                                                            if (!$valid) {
                                                                                $this->parser->matchError($error8, 'SequenceElement', $error);
                                                                                $error = $error8;
                                                                                break;
                                                                            }
                                                                            $error = array();
                                                                            // Start '')'' min '1' max '1'
                                                                            if (')' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                                                $this->parser->pos += 1;
                                                                                $result['_text'] .= ')';
                                                                                $this->parser->successNode(array('\')\'', ')'));
                                                                                $valid = true;
                                                                            } else {
                                                                                $this->parser->matchError($error, 'literal', ')');
                                                                                $this->parser->failNode(array('\')\'',  ''));
                                                                                $valid = false;
                                                                            }
                                                                            // End '')''
                                                                            if (!$valid) {
                                                                                $this->parser->matchError($error8, 'SequenceElement', $error);
                                                                                $error = $error8;
                                                                                break;
                                                                            }
                                                                            break;
                                                                        } while (true);
                                                                        $remove = array_pop($this->parser->backtrace);
                                                                        if (!$valid) {
                                                                            $this->parser->failNode($remove);
                                                                            $this->parser->pos = $pos8;
                                                                            $this->parser->line = $line8;
                                                                            $result = $backup8;
                                                                        } else {
                                                                            $this->parser->successNode($remove);
                                                                            }
                                                                            $error = $error8;
                                                                            unset($backup8);
                                                                            // end sequence
                                                                            // End '( '(' subexpr:Expr ')')'
                                                                            if ($valid) {
                                                                                $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                $error = $error1;
                                                                                break;
                                                                            } else {
                                                                                $this->parser->logOption($errorOption1, 'Value', $error);
                                                                            }
                                                                            $error = array();
                                                                            array_pop($this->parser->backtrace);
                                                                            $this->parser->addBacktrace(array('_o1:4_', ''));
                                                                            // Start 'value:Functioncall' tag 'value' min '1' max '1'
                                                                            $this->parser->addBacktrace(array('Functioncall', ''));
                                                                            $subres = $this->parser->matchRule($result, 'Functioncall', $error);
                                                                            $remove = array_pop($this->parser->backtrace);
                                                                            if ($subres) {
                                                                                $this->parser->successNode(array('Functioncall',  $subres['_text']));
                                                                                $result['_text'] .= $subres['_text'];
                                                                                $this->Value_value($result, $subres);
                                                                                $valid = true;
                                                                            } else {
                                                                                $valid = false;
                                                                                $this->parser->failNode($remove);
                                                                            }
                                                                            // End 'value:Functioncall'
                                                                            if ($valid) {
                                                                                $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                $error = $error1;
                                                                                break;
                                                                            } else {
                                                                                $this->parser->logOption($errorOption1, 'Value', $error);
                                                                            }
                                                                            $error = array();
                                                                            array_pop($this->parser->backtrace);
                                                                            $this->parser->addBacktrace(array('_o1:5_', ''));
                                                                            // Start 'value:Array' tag 'value' min '1' max '1'
                                                                            $this->parser->addBacktrace(array('Array', ''));
                                                                            $subres = $this->parser->matchRule($result, 'Array', $error);
                                                                            $remove = array_pop($this->parser->backtrace);
                                                                            if ($subres) {
                                                                                $this->parser->successNode(array('Array',  $subres['_text']));
                                                                                $result['_text'] .= $subres['_text'];
                                                                                $this->Value_value($result, $subres);
                                                                                $valid = true;
                                                                            } else {
                                                                                $valid = false;
                                                                                $this->parser->failNode($remove);
                                                                            }
                                                                            // End 'value:Array'
                                                                            if ($valid) {
                                                                                $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                $error = $error1;
                                                                                break;
                                                                            } else {
                                                                                $this->parser->logOption($errorOption1, 'Value', $error);
                                                                            }
                                                                            $error = $error1;
                                                                            array_pop($this->parser->backtrace);
                                                                            break;
                                                                        } while (true);
                                                                        // end option
                                                                        // End 'Value'
                                                                        if ($valid) {
                                                                            $result['_endpos'] = $this->parser->pos;
                                                                            $result['_endline'] = $this->parser->line;
                                                                        }
                                                                        if (!$valid) {
                                                                            $result = false;
                                                                            $this->parser->matchError($errorResult, 'token', $error, 'Value');
                                                                        }
                                                                        $this->parser->packCache[$pos0]['Value'] = $result;
                                                                        $this->parser->errorCache[$pos0]['Value'] = $error;
                                                                        return $result;
                                                                    }

                                                                    public function Value_value (&$result, $subres) {
                                                                        $result['node'] = $subres['node'];
                                                                    }


                                                                    public function Value_subexpr (&$result, $subres) {
                                                                        $result['node'] = new Subexpression($this->parser, $subres['node']);
                                                                    }


                                                                    /**
                                                                     *
                                                                     * Parser rules and action for node 'Statement'
                                                                     *
                                                                     *  Rule:
                                                                    <token Statement>
            <rule> var:Variable arr:'[]'? _? append:'.'? '=' _? value:Expr _? </rule>
            <action var>
            {
                $result['node'] = new TagStatement($this->parser);
                $result['var'] = $subres['node'];
            }
            </action>
            <action arr>
            {
                $result['var']->addSubTree(array('type' => 'arrayelement', 'node' => null) , 'suffix', true);
            }
            </action>
            <action value>
            {
                $result['node']->setTagAttribute(array('value', $subres['node']));
            }
            </action>
            <action append>
            {
                $result['node']->setTagAttribute(array('append', true));
            }
            </action>
            <action _finish>
            {
                $result['node']->setTagAttribute(array('variable', $result['var']));
            }
            </action>
        </token>

                                                                     *
                                                                    */
                                                                    public function matchNodeStatement($previous, &$errorResult){
                                                                        $result = $this->parser->resultDefault;
                                                                        $error = array();
                                                                        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                        $result['_lineno'] = $this->parser->line;
                                                                        // Start 'Statement' min '1' max '1'
                                                                        // start sequence
                                                                        $backup1 = $result;
                                                                        $pos1 = $this->parser->pos;
                                                                        $line1 = $this->parser->line;
                                                                        $error1 = $error;
                                                                        $this->parser->addBacktrace(array('_s1_', ''));
                                                                        do {
                                                                            $error = array();
                                                                            // Start 'var:Variable' tag 'var' min '1' max '1'
                                                                            $this->parser->addBacktrace(array('Variable', ''));
                                                                            $subres = $this->parser->matchRule($result, 'Variable', $error);
                                                                            $remove = array_pop($this->parser->backtrace);
                                                                            if ($subres) {
                                                                                $this->parser->successNode(array('Variable',  $subres['_text']));
                                                                                $result['_text'] .= $subres['_text'];
                                                                                $this->Statement_var($result, $subres);
                                                                                $valid = true;
                                                                            } else {
                                                                                $valid = false;
                                                                                $this->parser->failNode($remove);
                                                                            }
                                                                            // End 'var:Variable'
                                                                            if (!$valid) {
                                                                                $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                $error = $error1;
                                                                                break;
                                                                            }
                                                                            $error = array();
                                                                            // Start 'arr:'[]'?' tag 'arr' min '0' max '1'
                                                                            $error = array();
                                                                            if ('[]' == substr($this->parser->source, $this->parser->pos, 2)) {
                                                                                $this->parser->pos += 2;
                                                                                $result['_text'] .= '[]';
                                                                                $this->Statement_arr($result, null);
                                                                                $this->parser->successNode(array('\'[]\'', '[]'));
                                                                                $valid = true;
                                                                            } else {
                                                                                $this->parser->matchError($error, 'literal', '[]');
                                                                                $this->parser->failNode(array('\'[]\'',  ''));
                                                                                $valid = false;
                                                                            }
                                                                            if (!$valid) {
                                                                                $this->parser->logOption($errorResult, 'Statement', $error);
                                                                            }
                                                                            $valid = true;
                                                                            // End 'arr:'[]'?'
                                                                            if (!$valid) {
                                                                                $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                $error = $error1;
                                                                                break;
                                                                            }
                                                                            $error = array();
                                                                            // Start '_?' min '1' max '1'
                                                                            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                                                                                if (!empty($match[0])) {
                                                                                    $this->parser->pos += strlen($match[0]);
                                                                                    $this->parser->line += substr_count($match[0], "\n");
                                                                                    $result['_text'] .= ' ';
                                                                                }
                                                                            }
                                                                            $this->parser->successNode(array("' '",  $match[0]));
                                                                            $valid = true;
                                                                            // End '_?'
                                                                            if (!$valid) {
                                                                                $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                $error = $error1;
                                                                                break;
                                                                            }
                                                                            $error = array();
                                                                            // Start 'append:'.'?' tag 'append' min '0' max '1'
                                                                            $error = array();
                                                                            if ('.' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                                                $this->parser->pos += 1;
                                                                                $result['_text'] .= '.';
                                                                                $this->Statement_append($result, null);
                                                                                $this->parser->successNode(array('\'.\'', '.'));
                                                                                $valid = true;
                                                                            } else {
                                                                                $this->parser->matchError($error, 'literal', '.');
                                                                                $this->parser->failNode(array('\'.\'',  ''));
                                                                                $valid = false;
                                                                            }
                                                                            if (!$valid) {
                                                                                $this->parser->logOption($errorResult, 'Statement', $error);
                                                                            }
                                                                            $valid = true;
                                                                            // End 'append:'.'?'
                                                                            if (!$valid) {
                                                                                $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                $error = $error1;
                                                                                break;
                                                                            }
                                                                            $error = array();
                                                                            // Start ''='' min '1' max '1'
                                                                            if ('=' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                                                $this->parser->pos += 1;
                                                                                $result['_text'] .= '=';
                                                                                $this->parser->successNode(array('\'=\'', '='));
                                                                                $valid = true;
                                                                            } else {
                                                                                $this->parser->matchError($error, 'literal', '=');
                                                                                $this->parser->failNode(array('\'=\'',  ''));
                                                                                $valid = false;
                                                                            }
                                                                            // End ''=''
                                                                            if (!$valid) {
                                                                                $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                $error = $error1;
                                                                                break;
                                                                            }
                                                                            $error = array();
                                                                            // Start '_?' min '1' max '1'
                                                                            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                                                                                if (!empty($match[0])) {
                                                                                    $this->parser->pos += strlen($match[0]);
                                                                                    $this->parser->line += substr_count($match[0], "\n");
                                                                                    $result['_text'] .= ' ';
                                                                                }
                                                                            }
                                                                            $this->parser->successNode(array("' '",  $match[0]));
                                                                            $valid = true;
                                                                            // End '_?'
                                                                            if (!$valid) {
                                                                                $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                $error = $error1;
                                                                                break;
                                                                            }
                                                                            $error = array();
                                                                            // Start 'value:Expr' tag 'value' min '1' max '1'
                                                                            $this->parser->addBacktrace(array('Expr', ''));
                                                                            $subres = $this->parser->matchRule($result, 'Expr', $error);
                                                                            $remove = array_pop($this->parser->backtrace);
                                                                            if ($subres) {
                                                                                $this->parser->successNode(array('Expr',  $subres['_text']));
                                                                                $result['_text'] .= $subres['_text'];
                                                                                $this->Statement_value($result, $subres);
                                                                                $valid = true;
                                                                            } else {
                                                                                $valid = false;
                                                                                $this->parser->failNode($remove);
                                                                            }
                                                                            // End 'value:Expr'
                                                                            if (!$valid) {
                                                                                $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                $error = $error1;
                                                                                break;
                                                                            }
                                                                            $error = array();
                                                                            // Start '_?' min '1' max '1'
                                                                            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                                                                                if (!empty($match[0])) {
                                                                                    $this->parser->pos += strlen($match[0]);
                                                                                    $this->parser->line += substr_count($match[0], "\n");
                                                                                    $result['_text'] .= ' ';
                                                                                }
                                                                            }
                                                                            $this->parser->successNode(array("' '",  $match[0]));
                                                                            $valid = true;
                                                                            // End '_?'
                                                                            if (!$valid) {
                                                                                $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                $error = $error1;
                                                                                break;
                                                                            }
                                                                            break;
                                                                        } while (true);
                                                                        $remove = array_pop($this->parser->backtrace);
                                                                        if (!$valid) {
                                                                            $this->parser->failNode($remove);
                                                                            $this->parser->pos = $pos1;
                                                                            $this->parser->line = $line1;
                                                                            $result = $backup1;
                                                                        } else {
                                                                            $this->parser->successNode($remove);
                                                                            }
                                                                            $error = $error1;
                                                                            unset($backup1);
                                                                            // end sequence
                                                                            // End 'Statement'
                                                                            if ($valid) {
                                                                                $result['_endpos'] = $this->parser->pos;
                                                                                $result['_endline'] = $this->parser->line;
                                                                                $this->Statement___FINISH($result);
                                                                            }
                                                                            if (!$valid) {
                                                                                $result = false;
                                                                                $this->parser->matchError($errorResult, 'token', $error, 'Statement');
                                                                            }
                                                                            return $result;
                                                                        }

                                                                        public function Statement_var (&$result, $subres) {
                                                                            $result['node'] = new TagStatement($this->parser);
                                                                            $result['var'] = $subres['node'];
                                                                        }


                                                                        public function Statement_arr (&$result, $subres) {
                                                                            $result['var']->addSubTree(array('type'=> 'arrayelement', 'node'=> null) , 'suffix', true);
                                                                        }


                                                                        public function Statement_value (&$result, $subres) {
                                                                            $result['node']->setTagAttribute(array('value', $subres['node']));
                                                                        }


                                                                        public function Statement_append (&$result, $subres) {
                                                                            $result['node']->setTagAttribute(array('append', true));
                                                                        }


                                                                        public function Statement___FINISH (&$result) {
                                                                            $result['node']->setTagAttribute(array('variable', $result['var']));
                                                                        }


                                                                        /**
                                                                         *
                                                                         * Parser rules and action for node 'ModifierValue'
                                                                         *
                                                                         *  Rule:
                                                                        <token ModifierValue>
            <attribute>hash</attribute>
             <rule> value:Value addmodifier:('|' name:Id (':' param:Value)*)* </rule>
             <action value>
            {
               $result['node'] = $subres['node'];
            }
            </action>
            <action addmodifier>
            {
                if (isset($subres['name'])) {
                        $value = $result['node'];
                        $result['node'] = new Node($this->parser, 'Modifier');
                        $result['node']->addSubTree($value, 'value');
                        $result['node']->addSubTree($subres['name'], 'name');
                        $result['node']->addSubTree(isset($subres['param']) ? $subres['param'] : false, 'param');
                }
            }
            </action>
            <action param>
            {
               $result['param'][] = $subres['node'];
            }
            </action>
            <action name>
            {
               $string = new String($this->parser);
               $string->setValue($subres['_text'], true);
               $result['name'] = $string;
            }
            </action>
        </node>

                                                                         *
                                                                        */
                                                                        public function matchNodeModifierValue($previous, &$errorResult){
                                                                            $result = $this->parser->resultDefault;
                                                                            $error = array();
                                                                            $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                            $result['_lineno'] = $this->parser->line;
                                                                            if (isset($this->parser->packCache[$this->parser->pos]['ModifierValue'])) {
                                                                                $result = $this->parser->packCache[$this->parser->pos]['ModifierValue'];
                                                                                $error = $this->parser->errorCache[$this->parser->pos]['ModifierValue'];
                                                                                if ($result) {
                                                                                    $this->parser->pos = $result['_endpos'];
                                                                                    $this->parser->line = $result['_endline'];
                                                                                } else {
                                                                                    $this->parser->matchError($errorResult, 'token', $error, 'ModifierValue');
                                                                                }
                                                                                return $result;
                                                                            }
                                                                            // Start 'ModifierValue' min '1' max '1'
                                                                            // start sequence
                                                                            $backup1 = $result;
                                                                            $pos1 = $this->parser->pos;
                                                                            $line1 = $this->parser->line;
                                                                            $error1 = $error;
                                                                            $this->parser->addBacktrace(array('_s1_', ''));
                                                                            do {
                                                                                $error = array();
                                                                                // Start 'value:Value' tag 'value' min '1' max '1'
                                                                                $this->parser->addBacktrace(array('Value', ''));
                                                                                $subres = $this->parser->matchRule($result, 'Value', $error);
                                                                                $remove = array_pop($this->parser->backtrace);
                                                                                if ($subres) {
                                                                                    $this->parser->successNode(array('Value',  $subres['_text']));
                                                                                    $result['_text'] .= $subres['_text'];
                                                                                    $this->ModifierValue_value($result, $subres);
                                                                                    $valid = true;
                                                                                } else {
                                                                                    $valid = false;
                                                                                    $this->parser->failNode($remove);
                                                                                }
                                                                                // End 'value:Value'
                                                                                if (!$valid) {
                                                                                    $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                    $error = $error1;
                                                                                    break;
                                                                                }
                                                                                $error = array();
                                                                                // Start 'addmodifier:( '|' name:Id ( ':' param:Value)*)*' tag 'addmodifier' min '0' max 'null'
                                                                                $iteration3 = 0;
                                                                                do {
                                                                                    // start sequence
                                                                                    $backup4 = $result;
                                                                                    $pos4 = $this->parser->pos;
                                                                                    $line4 = $this->parser->line;
                                                                                    $error4 = $error;
                                                                                    $this->parser->addBacktrace(array('_s4_', ''));
                                                                                    do {
                                                                                        $error = array();
                                                                                        // Start ''|'' min '1' max '1'
                                                                                        if ('|' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                                                            $this->parser->pos += 1;
                                                                                            $result['_text'] .= '|';
                                                                                            $this->parser->successNode(array('\'|\'', '|'));
                                                                                            $valid = true;
                                                                                        } else {
                                                                                            $this->parser->matchError($error, 'literal', '|');
                                                                                            $this->parser->failNode(array('\'|\'',  ''));
                                                                                            $valid = false;
                                                                                        }
                                                                                        // End ''|''
                                                                                        if (!$valid) {
                                                                                            $this->parser->matchError($error4, 'SequenceElement', $error);
                                                                                            $error = $error4;
                                                                                            break;
                                                                                        }
                                                                                        $error = array();
                                                                                        // Start 'name:Id' tag 'name' min '1' max '1'
                                                                                        $this->parser->addBacktrace(array('Id', ''));
                                                                                        $subres = $this->parser->matchRule($result, 'Id', $error);
                                                                                        $remove = array_pop($this->parser->backtrace);
                                                                                        if ($subres) {
                                                                                            $this->parser->successNode(array('Id',  $subres['_text']));
                                                                                            $result['_text'] .= $subres['_text'];
                                                                                            $this->ModifierValue_name($result, $subres);
                                                                                            $valid = true;
                                                                                        } else {
                                                                                            $valid = false;
                                                                                            $this->parser->failNode($remove);
                                                                                        }
                                                                                        // End 'name:Id'
                                                                                        if (!$valid) {
                                                                                            $this->parser->matchError($error4, 'SequenceElement', $error);
                                                                                            $error = $error4;
                                                                                            break;
                                                                                        }
                                                                                        $error = array();
                                                                                        // Start '( ':' param:Value)*' min '0' max 'null'
                                                                                        $iteration7 = 0;
                                                                                        do {
                                                                                            // start sequence
                                                                                            $backup8 = $result;
                                                                                            $pos8 = $this->parser->pos;
                                                                                            $line8 = $this->parser->line;
                                                                                            $error8 = $error;
                                                                                            $this->parser->addBacktrace(array('_s8_', ''));
                                                                                            do {
                                                                                                $error = array();
                                                                                                // Start '':'' min '1' max '1'
                                                                                                if (':' == substr($this->parser->source, $this->parser->pos, 1)) {
                                                                                                    $this->parser->pos += 1;
                                                                                                    $result['_text'] .= ':';
                                                                                                    $this->parser->successNode(array('\':\'', ':'));
                                                                                                    $valid = true;
                                                                                                } else {
                                                                                                    $this->parser->matchError($error, 'literal', ':');
                                                                                                    $this->parser->failNode(array('\':\'',  ''));
                                                                                                    $valid = false;
                                                                                                }
                                                                                                // End '':''
                                                                                                if (!$valid) {
                                                                                                    $this->parser->matchError($error8, 'SequenceElement', $error);
                                                                                                    $error = $error8;
                                                                                                    break;
                                                                                                }
                                                                                                $error = array();
                                                                                                // Start 'param:Value' tag 'param' min '1' max '1'
                                                                                                $this->parser->addBacktrace(array('Value', ''));
                                                                                                $subres = $this->parser->matchRule($result, 'Value', $error);
                                                                                                $remove = array_pop($this->parser->backtrace);
                                                                                                if ($subres) {
                                                                                                    $this->parser->successNode(array('Value',  $subres['_text']));
                                                                                                    $result['_text'] .= $subres['_text'];
                                                                                                    $this->ModifierValue_param($result, $subres);
                                                                                                    $valid = true;
                                                                                                } else {
                                                                                                    $valid = false;
                                                                                                    $this->parser->failNode($remove);
                                                                                                }
                                                                                                // End 'param:Value'
                                                                                                if (!$valid) {
                                                                                                    $this->parser->matchError($error8, 'SequenceElement', $error);
                                                                                                    $error = $error8;
                                                                                                    break;
                                                                                                }
                                                                                                break;
                                                                                            } while (true);
                                                                                            $remove = array_pop($this->parser->backtrace);
                                                                                            if (!$valid) {
                                                                                                $this->parser->failNode($remove);
                                                                                                $this->parser->pos = $pos8;
                                                                                                $this->parser->line = $line8;
                                                                                                $result = $backup8;
                                                                                            } else {
                                                                                                $this->parser->successNode($remove);
                                                                                                }
                                                                                                $error = $error8;
                                                                                                unset($backup8);
                                                                                                // end sequence
                                                                                                $iteration7 = $valid ? ($iteration7 + 1) : $iteration7;
                                                                                                if (!$valid && $iteration7 >= 0) {
                                                                                                    $valid = true;
                                                                                                    break;
                                                                                                }
                                                                                                if (!$valid) break;
                                                                                            } while (true);
                                                                                            // End '( ':' param:Value)*'
                                                                                            if (!$valid) {
                                                                                                $this->parser->matchError($error4, 'SequenceElement', $error);
                                                                                                $error = $error4;
                                                                                                break;
                                                                                            }
                                                                                            break;
                                                                                        } while (true);
                                                                                        $remove = array_pop($this->parser->backtrace);
                                                                                        if (!$valid) {
                                                                                            $this->parser->failNode($remove);
                                                                                            $this->parser->pos = $pos4;
                                                                                            $this->parser->line = $line4;
                                                                                            $result = $backup4;
                                                                                        } else {
                                                                                            $this->parser->successNode($remove);
                                                                                            }
                                                                                            $error = $error4;
                                                                                            if ($valid) {
                                                                                                $backup4['_text'] .= $result['_text'];
                                                                                                $this->ModifierValue_addmodifier($backup4, $result);
                                                                                            }
                                                                                            $result = $backup4;
                                                                                            unset($backup4);
                                                                                            // end sequence
                                                                                            $iteration3 = $valid ? ($iteration3 + 1) : $iteration3;
                                                                                            if (!$valid && $iteration3 >= 0) {
                                                                                                $valid = true;
                                                                                                break;
                                                                                            }
                                                                                            if (!$valid) break;
                                                                                        } while (true);
                                                                                        // End 'addmodifier:( '|' name:Id ( ':' param:Value)*)*'
                                                                                        if (!$valid) {
                                                                                            $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                            $error = $error1;
                                                                                            break;
                                                                                        }
                                                                                        break;
                                                                                    } while (true);
                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                    if (!$valid) {
                                                                                        $this->parser->failNode($remove);
                                                                                        $this->parser->pos = $pos1;
                                                                                        $this->parser->line = $line1;
                                                                                        $result = $backup1;
                                                                                    } else {
                                                                                        $this->parser->successNode($remove);
                                                                                        }
                                                                                        $error = $error1;
                                                                                        unset($backup1);
                                                                                        // end sequence
                                                                                        // End 'ModifierValue'
                                                                                        if ($valid) {
                                                                                            $result['_endpos'] = $this->parser->pos;
                                                                                            $result['_endline'] = $this->parser->line;
                                                                                        }
                                                                                        if (!$valid) {
                                                                                            $result = false;
                                                                                            $this->parser->matchError($errorResult, 'token', $error, 'ModifierValue');
                                                                                        }
                                                                                        $this->parser->packCache[$pos0]['ModifierValue'] = $result;
                                                                                        $this->parser->errorCache[$pos0]['ModifierValue'] = $error;
                                                                                        return $result;
                                                                                    }

                                                                                    public function ModifierValue_value (&$result, $subres) {
                                                                                        $result['node'] = $subres['node'];
                                                                                    }


                                                                                    public function ModifierValue_addmodifier (&$result, $subres) {
                                                                                        if (isset($subres['name'])) {
                                                                                            $value = $result['node'];
                                                                                            $result['node'] = new Node($this->parser, 'Modifier');
                                                                                            $result['node']->addSubTree($value, 'value');
                                                                                            $result['node']->addSubTree($subres['name'], 'name');
                                                                                            $result['node']->addSubTree(isset($subres['param']) ? $subres['param'] : false, 'param');
                                                                                        }
                                                                                    }


                                                                                    public function ModifierValue_param (&$result, $subres) {
                                                                                        $result['param'][] = $subres['node'];
                                                                                    }


                                                                                    public function ModifierValue_name (&$result, $subres) {
                                                                                        $string = new String($this->parser);
                                                                                        $string->setValue($subres['_text'], true);
                                                                                        $result['name'] = $string;
                                                                                    }


                                                                                    /**
                                                                                     *
                                                                                     * Parser rules and action for node 'Expr'
                                                                                     *
                                                                                     *  Rule:
                                                                                    <token Expr>
            <rule> value:Mathexpr | value:Logexpr  </rule>
             <action _all>
            {
               $result['node'] = $subres['node'];
            }
            </action>
       </token>

                                                                                     *
                                                                                    */
                                                                                    public function matchNodeExpr($previous, &$errorResult){
                                                                                        $result = $this->parser->resultDefault;
                                                                                        $error = array();
                                                                                        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                                        $result['_lineno'] = $this->parser->line;
                                                                                        // Start 'Expr' min '1' max '1'
                                                                                        // start option
                                                                                        $error1 = $error;
                                                                                        $errorOption1 =array();
                                                                                        $this->parser->addBacktrace(array('_o1_', ''));
                                                                                        do {
                                                                                            $error = array();
                                                                                            array_pop($this->parser->backtrace);
                                                                                            $this->parser->addBacktrace(array('_o1:1_', ''));
                                                                                            // Start 'value:Mathexpr' tag 'value' min '1' max '1'
                                                                                            $this->parser->addBacktrace(array('Mathexpr', ''));
                                                                                            $subres = $this->parser->matchRule($result, 'Mathexpr', $error);
                                                                                            $remove = array_pop($this->parser->backtrace);
                                                                                            if ($subres) {
                                                                                                $this->parser->successNode(array('Mathexpr',  $subres['_text']));
                                                                                                $result['_text'] .= $subres['_text'];
                                                                                                $this->Expr___ALL($result, $subres);
                                                                                                $valid = true;
                                                                                            } else {
                                                                                                $valid = false;
                                                                                                $this->parser->failNode($remove);
                                                                                            }
                                                                                            // End 'value:Mathexpr'
                                                                                            if ($valid) {
                                                                                                $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                $error = $error1;
                                                                                                break;
                                                                                            } else {
                                                                                                $this->parser->logOption($errorOption1, 'Expr', $error);
                                                                                            }
                                                                                            $error = array();
                                                                                            array_pop($this->parser->backtrace);
                                                                                            $this->parser->addBacktrace(array('_o1:2_', ''));
                                                                                            // Start 'value:Logexpr' tag 'value' min '1' max '1'
                                                                                            $this->parser->addBacktrace(array('Logexpr', ''));
                                                                                            $subres = $this->parser->matchRule($result, 'Logexpr', $error);
                                                                                            $remove = array_pop($this->parser->backtrace);
                                                                                            if ($subres) {
                                                                                                $this->parser->successNode(array('Logexpr',  $subres['_text']));
                                                                                                $result['_text'] .= $subres['_text'];
                                                                                                $this->Expr___ALL($result, $subres);
                                                                                                $valid = true;
                                                                                            } else {
                                                                                                $valid = false;
                                                                                                $this->parser->failNode($remove);
                                                                                            }
                                                                                            // End 'value:Logexpr'
                                                                                            if ($valid) {
                                                                                                $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                $error = $error1;
                                                                                                break;
                                                                                            } else {
                                                                                                $this->parser->logOption($errorOption1, 'Expr', $error);
                                                                                            }
                                                                                            $error = $error1;
                                                                                            array_pop($this->parser->backtrace);
                                                                                            break;
                                                                                        } while (true);
                                                                                        // end option
                                                                                        // End 'Expr'
                                                                                        if ($valid) {
                                                                                            $result['_endpos'] = $this->parser->pos;
                                                                                            $result['_endline'] = $this->parser->line;
                                                                                        }
                                                                                        if (!$valid) {
                                                                                            $result = false;
                                                                                            $this->parser->matchError($errorResult, 'token', $error, 'Expr');
                                                                                        }
                                                                                        return $result;
                                                                                    }

                                                                                    public function Expr___ALL (&$result, $subres) {
                                                                                        $result['node'] = $subres['node'];
                                                                                    }


                                                                                    /**
                                                                                     *
                                                                                     * Parser rules and action for node 'Mathexpr'
                                                                                     *
                                                                                     *  Rule:
                                                                                    <token Mathexpr>
            <rule> (operator:Unimath left:ModifierValue) | (left:ModifierValue)  (operator:Unimath | (operator:Math operator:Unimath?) right:ModifierValue )* </rule>
            <action _all>
            {
                if (!isset($result['node'])) {
                    $result['node'] = array();
                }
                $result['node'][] = $subres['node'];
            }
            </action>
        </token>

                                                                                     *
                                                                                    */
                                                                                    public function matchNodeMathexpr($previous, &$errorResult){
                                                                                        $result = $this->parser->resultDefault;
                                                                                        $error = array();
                                                                                        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                                        $result['_lineno'] = $this->parser->line;
                                                                                        // Start 'Mathexpr' min '1' max '1'
                                                                                        // start sequence
                                                                                        $backup1 = $result;
                                                                                        $pos1 = $this->parser->pos;
                                                                                        $line1 = $this->parser->line;
                                                                                        $error1 = $error;
                                                                                        $this->parser->addBacktrace(array('_s1_', ''));
                                                                                        do {
                                                                                            $error = array();
                                                                                            // Start 'Mathexpr' min '1' max '1'
                                                                                            // start option
                                                                                            $error3 = $error;
                                                                                            $errorOption3 =array();
                                                                                            $this->parser->addBacktrace(array('_o3_', ''));
                                                                                            do {
                                                                                                $error = array();
                                                                                                array_pop($this->parser->backtrace);
                                                                                                $this->parser->addBacktrace(array('_o3:1_', ''));
                                                                                                // Start '( operator:Unimath left:ModifierValue)' min '1' max '1'
                                                                                                // start sequence
                                                                                                $backup5 = $result;
                                                                                                $pos5 = $this->parser->pos;
                                                                                                $line5 = $this->parser->line;
                                                                                                $error5 = $error;
                                                                                                $this->parser->addBacktrace(array('_s5_', ''));
                                                                                                do {
                                                                                                    $error = array();
                                                                                                    // Start 'operator:Unimath' tag 'operator' min '1' max '1'
                                                                                                    $this->parser->addBacktrace(array('Unimath', ''));
                                                                                                    $subres = $this->parser->matchRule($result, 'Unimath', $error);
                                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                                    if ($subres) {
                                                                                                        $this->parser->successNode(array('Unimath',  $subres['_text']));
                                                                                                        $result['_text'] .= $subres['_text'];
                                                                                                        $this->Mathexpr___ALL($result, $subres);
                                                                                                        $valid = true;
                                                                                                    } else {
                                                                                                        $valid = false;
                                                                                                        $this->parser->failNode($remove);
                                                                                                    }
                                                                                                    // End 'operator:Unimath'
                                                                                                    if (!$valid) {
                                                                                                        $this->parser->matchError($error5, 'SequenceElement', $error);
                                                                                                        $error = $error5;
                                                                                                        break;
                                                                                                    }
                                                                                                    $error = array();
                                                                                                    // Start 'left:ModifierValue' tag 'left' min '1' max '1'
                                                                                                    $this->parser->addBacktrace(array('ModifierValue', ''));
                                                                                                    $subres = $this->parser->matchRule($result, 'ModifierValue', $error);
                                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                                    if ($subres) {
                                                                                                        $this->parser->successNode(array('ModifierValue',  $subres['_text']));
                                                                                                        $result['_text'] .= $subres['_text'];
                                                                                                        $this->Mathexpr___ALL($result, $subres);
                                                                                                        $valid = true;
                                                                                                    } else {
                                                                                                        $valid = false;
                                                                                                        $this->parser->failNode($remove);
                                                                                                    }
                                                                                                    // End 'left:ModifierValue'
                                                                                                    if (!$valid) {
                                                                                                        $this->parser->matchError($error5, 'SequenceElement', $error);
                                                                                                        $error = $error5;
                                                                                                        break;
                                                                                                    }
                                                                                                    break;
                                                                                                } while (true);
                                                                                                $remove = array_pop($this->parser->backtrace);
                                                                                                if (!$valid) {
                                                                                                    $this->parser->failNode($remove);
                                                                                                    $this->parser->pos = $pos5;
                                                                                                    $this->parser->line = $line5;
                                                                                                    $result = $backup5;
                                                                                                } else {
                                                                                                    $this->parser->successNode($remove);
                                                                                                    }
                                                                                                    $error = $error5;
                                                                                                    unset($backup5);
                                                                                                    // end sequence
                                                                                                    // End '( operator:Unimath left:ModifierValue)'
                                                                                                    if ($valid) {
                                                                                                        $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                        $error = $error3;
                                                                                                        break;
                                                                                                    } else {
                                                                                                        $this->parser->logOption($errorOption3, 'Mathexpr', $error);
                                                                                                    }
                                                                                                    $error = array();
                                                                                                    array_pop($this->parser->backtrace);
                                                                                                    $this->parser->addBacktrace(array('_o3:2_', ''));
                                                                                                    // Start '( left:ModifierValue)' tag 'left' min '1' max '1'
                                                                                                    $this->parser->addBacktrace(array('ModifierValue', ''));
                                                                                                    $subres = $this->parser->matchRule($result, 'ModifierValue', $error);
                                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                                    if ($subres) {
                                                                                                        $this->parser->successNode(array('ModifierValue',  $subres['_text']));
                                                                                                        $result['_text'] .= $subres['_text'];
                                                                                                        $this->Mathexpr___ALL($result, $subres);
                                                                                                        $valid = true;
                                                                                                    } else {
                                                                                                        $valid = false;
                                                                                                        $this->parser->failNode($remove);
                                                                                                    }
                                                                                                    // End '( left:ModifierValue)'
                                                                                                    if ($valid) {
                                                                                                        $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                        $error = $error3;
                                                                                                        break;
                                                                                                    } else {
                                                                                                        $this->parser->logOption($errorOption3, 'Mathexpr', $error);
                                                                                                    }
                                                                                                    $error = $error3;
                                                                                                    array_pop($this->parser->backtrace);
                                                                                                    break;
                                                                                                } while (true);
                                                                                                // end option
                                                                                                // End 'Mathexpr'
                                                                                                if (!$valid) {
                                                                                                    $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                                    $error = $error1;
                                                                                                    break;
                                                                                                }
                                                                                                $error = array();
                                                                                                // Start '( operator:Unimath | ( operator:Math operator:Unimath?) right:ModifierValue)*' min '0' max 'null'
                                                                                                $iteration9 = 0;
                                                                                                do {
                                                                                                    // start sequence
                                                                                                    $backup10 = $result;
                                                                                                    $pos10 = $this->parser->pos;
                                                                                                    $line10 = $this->parser->line;
                                                                                                    $error10 = $error;
                                                                                                    $this->parser->addBacktrace(array('_s10_', ''));
                                                                                                    do {
                                                                                                        $error = array();
                                                                                                        // Start 'Mathexpr' min '1' max '1'
                                                                                                        // start option
                                                                                                        $error12 = $error;
                                                                                                        $errorOption12 =array();
                                                                                                        $this->parser->addBacktrace(array('_o12_', ''));
                                                                                                        do {
                                                                                                            $error = array();
                                                                                                            array_pop($this->parser->backtrace);
                                                                                                            $this->parser->addBacktrace(array('_o12:1_', ''));
                                                                                                            // Start 'operator:Unimath' tag 'operator' min '1' max '1'
                                                                                                            $this->parser->addBacktrace(array('Unimath', ''));
                                                                                                            $subres = $this->parser->matchRule($result, 'Unimath', $error);
                                                                                                            $remove = array_pop($this->parser->backtrace);
                                                                                                            if ($subres) {
                                                                                                                $this->parser->successNode(array('Unimath',  $subres['_text']));
                                                                                                                $result['_text'] .= $subres['_text'];
                                                                                                                $this->Mathexpr___ALL($result, $subres);
                                                                                                                $valid = true;
                                                                                                            } else {
                                                                                                                $valid = false;
                                                                                                                $this->parser->failNode($remove);
                                                                                                            }
                                                                                                            // End 'operator:Unimath'
                                                                                                            if ($valid) {
                                                                                                                $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                                $error = $error12;
                                                                                                                break;
                                                                                                            } else {
                                                                                                                $this->parser->logOption($errorOption12, 'Mathexpr', $error);
                                                                                                            }
                                                                                                            $error = array();
                                                                                                            array_pop($this->parser->backtrace);
                                                                                                            $this->parser->addBacktrace(array('_o12:2_', ''));
                                                                                                            // Start '( operator:Math operator:Unimath?)' min '1' max '1'
                                                                                                            // start sequence
                                                                                                            $backup15 = $result;
                                                                                                            $pos15 = $this->parser->pos;
                                                                                                            $line15 = $this->parser->line;
                                                                                                            $error15 = $error;
                                                                                                            $this->parser->addBacktrace(array('_s15_', ''));
                                                                                                            do {
                                                                                                                $error = array();
                                                                                                                // Start 'operator:Math' tag 'operator' min '1' max '1'
                                                                                                                $this->parser->addBacktrace(array('Math', ''));
                                                                                                                $subres = $this->parser->matchRule($result, 'Math', $error);
                                                                                                                $remove = array_pop($this->parser->backtrace);
                                                                                                                if ($subres) {
                                                                                                                    $this->parser->successNode(array('Math',  $subres['_text']));
                                                                                                                    $result['_text'] .= $subres['_text'];
                                                                                                                    $this->Mathexpr___ALL($result, $subres);
                                                                                                                    $valid = true;
                                                                                                                } else {
                                                                                                                    $valid = false;
                                                                                                                    $this->parser->failNode($remove);
                                                                                                                }
                                                                                                                // End 'operator:Math'
                                                                                                                if (!$valid) {
                                                                                                                    $this->parser->matchError($error15, 'SequenceElement', $error);
                                                                                                                    $error = $error15;
                                                                                                                    break;
                                                                                                                }
                                                                                                                $error = array();
                                                                                                                // Start 'operator:Unimath?' tag 'operator' min '0' max '1'
                                                                                                                $error = array();
                                                                                                                $this->parser->addBacktrace(array('Unimath', ''));
                                                                                                                $subres = $this->parser->matchRule($result, 'Unimath', $error);
                                                                                                                $remove = array_pop($this->parser->backtrace);
                                                                                                                if ($subres) {
                                                                                                                    $this->parser->successNode(array('Unimath',  $subres['_text']));
                                                                                                                    $result['_text'] .= $subres['_text'];
                                                                                                                    $this->Mathexpr___ALL($result, $subres);
                                                                                                                    $valid = true;
                                                                                                                } else {
                                                                                                                    $valid = false;
                                                                                                                    $this->parser->failNode($remove);
                                                                                                                }
                                                                                                                if (!$valid) {
                                                                                                                    $this->parser->logOption($errorResult, 'Mathexpr', $error);
                                                                                                                }
                                                                                                                $valid = true;
                                                                                                                // End 'operator:Unimath?'
                                                                                                                if (!$valid) {
                                                                                                                    $this->parser->matchError($error15, 'SequenceElement', $error);
                                                                                                                    $error = $error15;
                                                                                                                    break;
                                                                                                                }
                                                                                                                break;
                                                                                                            } while (true);
                                                                                                            $remove = array_pop($this->parser->backtrace);
                                                                                                            if (!$valid) {
                                                                                                                $this->parser->failNode($remove);
                                                                                                                $this->parser->pos = $pos15;
                                                                                                                $this->parser->line = $line15;
                                                                                                                $result = $backup15;
                                                                                                            } else {
                                                                                                                $this->parser->successNode($remove);
                                                                                                                }
                                                                                                                $error = $error15;
                                                                                                                unset($backup15);
                                                                                                                // end sequence
                                                                                                                // End '( operator:Math operator:Unimath?)'
                                                                                                                if ($valid) {
                                                                                                                    $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                                    $error = $error12;
                                                                                                                    break;
                                                                                                                } else {
                                                                                                                    $this->parser->logOption($errorOption12, 'Mathexpr', $error);
                                                                                                                }
                                                                                                                $error = $error12;
                                                                                                                array_pop($this->parser->backtrace);
                                                                                                                break;
                                                                                                            } while (true);
                                                                                                            // end option
                                                                                                            // End 'Mathexpr'
                                                                                                            if (!$valid) {
                                                                                                                $this->parser->matchError($error10, 'SequenceElement', $error);
                                                                                                                $error = $error10;
                                                                                                                break;
                                                                                                            }
                                                                                                            $error = array();
                                                                                                            // Start 'right:ModifierValue' tag 'right' min '1' max '1'
                                                                                                            $this->parser->addBacktrace(array('ModifierValue', ''));
                                                                                                            $subres = $this->parser->matchRule($result, 'ModifierValue', $error);
                                                                                                            $remove = array_pop($this->parser->backtrace);
                                                                                                            if ($subres) {
                                                                                                                $this->parser->successNode(array('ModifierValue',  $subres['_text']));
                                                                                                                $result['_text'] .= $subres['_text'];
                                                                                                                $this->Mathexpr___ALL($result, $subres);
                                                                                                                $valid = true;
                                                                                                            } else {
                                                                                                                $valid = false;
                                                                                                                $this->parser->failNode($remove);
                                                                                                            }
                                                                                                            // End 'right:ModifierValue'
                                                                                                            if (!$valid) {
                                                                                                                $this->parser->matchError($error10, 'SequenceElement', $error);
                                                                                                                $error = $error10;
                                                                                                                break;
                                                                                                            }
                                                                                                            break;
                                                                                                        } while (true);
                                                                                                        $remove = array_pop($this->parser->backtrace);
                                                                                                        if (!$valid) {
                                                                                                            $this->parser->failNode($remove);
                                                                                                            $this->parser->pos = $pos10;
                                                                                                            $this->parser->line = $line10;
                                                                                                            $result = $backup10;
                                                                                                        } else {
                                                                                                            $this->parser->successNode($remove);
                                                                                                            }
                                                                                                            $error = $error10;
                                                                                                            unset($backup10);
                                                                                                            // end sequence
                                                                                                            $iteration9 = $valid ? ($iteration9 + 1) : $iteration9;
                                                                                                            if (!$valid && $iteration9 >= 0) {
                                                                                                                $valid = true;
                                                                                                                break;
                                                                                                            }
                                                                                                            if (!$valid) break;
                                                                                                        } while (true);
                                                                                                        // End '( operator:Unimath | ( operator:Math operator:Unimath?) right:ModifierValue)*'
                                                                                                        if (!$valid) {
                                                                                                            $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                                            $error = $error1;
                                                                                                            break;
                                                                                                        }
                                                                                                        break;
                                                                                                    } while (true);
                                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                                    if (!$valid) {
                                                                                                        $this->parser->failNode($remove);
                                                                                                        $this->parser->pos = $pos1;
                                                                                                        $this->parser->line = $line1;
                                                                                                        $result = $backup1;
                                                                                                    } else {
                                                                                                        $this->parser->successNode($remove);
                                                                                                        }
                                                                                                        $error = $error1;
                                                                                                        unset($backup1);
                                                                                                        // end sequence
                                                                                                        // End 'Mathexpr'
                                                                                                        if ($valid) {
                                                                                                            $result['_endpos'] = $this->parser->pos;
                                                                                                            $result['_endline'] = $this->parser->line;
                                                                                                        }
                                                                                                        if (!$valid) {
                                                                                                            $result = false;
                                                                                                            $this->parser->matchError($errorResult, 'token', $error, 'Mathexpr');
                                                                                                        }
                                                                                                        return $result;
                                                                                                    }

                                                                                                    public function Mathexpr___ALL (&$result, $subres) {
                                                                                                        if (!isset($result['node'])) {
                                                                                                            $result['node'] = array();
                                                                                                        }
                                                                                                        $result['node'][] = $subres['node'];
                                                                                                    }


                                                                                                    /**
                                                                                                     *
                                                                                                     * Parser rules and action for node 'Logexpr'
                                                                                                     *
                                                                                                     *  Rule:
                                                                                                    <token Logexpr>
            <rule> (operator:Unilog left:ModifierValue)|(left:ModifierValue operator:NamedCondition?) ( operator:Logical | (operator:Condition|operator:NamedCondition2) (operator:Unilog right:ModifierValue)|(right:ModifierValue operator:NamedCondition?) )* </rule>
            <action _all>
            {
                if (!isset($result['node'])) {
                    $result['node'] = array();
                }
                $result['node'][] = $subres['node'];
            }
            </action>
        </token>

                                                                                                     *
                                                                                                    */
                                                                                                    public function matchNodeLogexpr($previous, &$errorResult){
                                                                                                        $result = $this->parser->resultDefault;
                                                                                                        $error = array();
                                                                                                        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                                                        $result['_lineno'] = $this->parser->line;
                                                                                                        // Start 'Logexpr' min '1' max '1'
                                                                                                        // start sequence
                                                                                                        $backup1 = $result;
                                                                                                        $pos1 = $this->parser->pos;
                                                                                                        $line1 = $this->parser->line;
                                                                                                        $error1 = $error;
                                                                                                        $this->parser->addBacktrace(array('_s1_', ''));
                                                                                                        do {
                                                                                                            $error = array();
                                                                                                            // Start 'Logexpr' min '1' max '1'
                                                                                                            // start option
                                                                                                            $error3 = $error;
                                                                                                            $errorOption3 =array();
                                                                                                            $this->parser->addBacktrace(array('_o3_', ''));
                                                                                                            do {
                                                                                                                $error = array();
                                                                                                                array_pop($this->parser->backtrace);
                                                                                                                $this->parser->addBacktrace(array('_o3:1_', ''));
                                                                                                                // Start '( operator:Unilog left:ModifierValue)' min '1' max '1'
                                                                                                                // start sequence
                                                                                                                $backup5 = $result;
                                                                                                                $pos5 = $this->parser->pos;
                                                                                                                $line5 = $this->parser->line;
                                                                                                                $error5 = $error;
                                                                                                                $this->parser->addBacktrace(array('_s5_', ''));
                                                                                                                do {
                                                                                                                    $error = array();
                                                                                                                    // Start 'operator:Unilog' tag 'operator' min '1' max '1'
                                                                                                                    $this->parser->addBacktrace(array('Unilog', ''));
                                                                                                                    $subres = $this->parser->matchRule($result, 'Unilog', $error);
                                                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                                                    if ($subres) {
                                                                                                                        $this->parser->successNode(array('Unilog',  $subres['_text']));
                                                                                                                        $result['_text'] .= $subres['_text'];
                                                                                                                        $this->Logexpr___ALL($result, $subres);
                                                                                                                        $valid = true;
                                                                                                                    } else {
                                                                                                                        $valid = false;
                                                                                                                        $this->parser->failNode($remove);
                                                                                                                    }
                                                                                                                    // End 'operator:Unilog'
                                                                                                                    if (!$valid) {
                                                                                                                        $this->parser->matchError($error5, 'SequenceElement', $error);
                                                                                                                        $error = $error5;
                                                                                                                        break;
                                                                                                                    }
                                                                                                                    $error = array();
                                                                                                                    // Start 'left:ModifierValue' tag 'left' min '1' max '1'
                                                                                                                    $this->parser->addBacktrace(array('ModifierValue', ''));
                                                                                                                    $subres = $this->parser->matchRule($result, 'ModifierValue', $error);
                                                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                                                    if ($subres) {
                                                                                                                        $this->parser->successNode(array('ModifierValue',  $subres['_text']));
                                                                                                                        $result['_text'] .= $subres['_text'];
                                                                                                                        $this->Logexpr___ALL($result, $subres);
                                                                                                                        $valid = true;
                                                                                                                    } else {
                                                                                                                        $valid = false;
                                                                                                                        $this->parser->failNode($remove);
                                                                                                                    }
                                                                                                                    // End 'left:ModifierValue'
                                                                                                                    if (!$valid) {
                                                                                                                        $this->parser->matchError($error5, 'SequenceElement', $error);
                                                                                                                        $error = $error5;
                                                                                                                        break;
                                                                                                                    }
                                                                                                                    break;
                                                                                                                } while (true);
                                                                                                                $remove = array_pop($this->parser->backtrace);
                                                                                                                if (!$valid) {
                                                                                                                    $this->parser->failNode($remove);
                                                                                                                    $this->parser->pos = $pos5;
                                                                                                                    $this->parser->line = $line5;
                                                                                                                    $result = $backup5;
                                                                                                                } else {
                                                                                                                    $this->parser->successNode($remove);
                                                                                                                    }
                                                                                                                    $error = $error5;
                                                                                                                    unset($backup5);
                                                                                                                    // end sequence
                                                                                                                    // End '( operator:Unilog left:ModifierValue)'
                                                                                                                    if ($valid) {
                                                                                                                        $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                                        $error = $error3;
                                                                                                                        break;
                                                                                                                    } else {
                                                                                                                        $this->parser->logOption($errorOption3, 'Logexpr', $error);
                                                                                                                    }
                                                                                                                    $error = array();
                                                                                                                    array_pop($this->parser->backtrace);
                                                                                                                    $this->parser->addBacktrace(array('_o3:2_', ''));
                                                                                                                    // Start '( left:ModifierValue operator:NamedCondition?)' min '1' max '1'
                                                                                                                    // start sequence
                                                                                                                    $backup9 = $result;
                                                                                                                    $pos9 = $this->parser->pos;
                                                                                                                    $line9 = $this->parser->line;
                                                                                                                    $error9 = $error;
                                                                                                                    $this->parser->addBacktrace(array('_s9_', ''));
                                                                                                                    do {
                                                                                                                        $error = array();
                                                                                                                        // Start 'left:ModifierValue' tag 'left' min '1' max '1'
                                                                                                                        $this->parser->addBacktrace(array('ModifierValue', ''));
                                                                                                                        $subres = $this->parser->matchRule($result, 'ModifierValue', $error);
                                                                                                                        $remove = array_pop($this->parser->backtrace);
                                                                                                                        if ($subres) {
                                                                                                                            $this->parser->successNode(array('ModifierValue',  $subres['_text']));
                                                                                                                            $result['_text'] .= $subres['_text'];
                                                                                                                            $this->Logexpr___ALL($result, $subres);
                                                                                                                            $valid = true;
                                                                                                                        } else {
                                                                                                                            $valid = false;
                                                                                                                            $this->parser->failNode($remove);
                                                                                                                        }
                                                                                                                        // End 'left:ModifierValue'
                                                                                                                        if (!$valid) {
                                                                                                                            $this->parser->matchError($error9, 'SequenceElement', $error);
                                                                                                                            $error = $error9;
                                                                                                                            break;
                                                                                                                        }
                                                                                                                        $error = array();
                                                                                                                        // Start 'operator:NamedCondition?' tag 'operator' min '0' max '1'
                                                                                                                        $error = array();
                                                                                                                        $this->parser->addBacktrace(array('NamedCondition', ''));
                                                                                                                        $subres = $this->parser->matchRule($result, 'NamedCondition', $error);
                                                                                                                        $remove = array_pop($this->parser->backtrace);
                                                                                                                        if ($subres) {
                                                                                                                            $this->parser->successNode(array('NamedCondition',  $subres['_text']));
                                                                                                                            $result['_text'] .= $subres['_text'];
                                                                                                                            $this->Logexpr___ALL($result, $subres);
                                                                                                                            $valid = true;
                                                                                                                        } else {
                                                                                                                            $valid = false;
                                                                                                                            $this->parser->failNode($remove);
                                                                                                                        }
                                                                                                                        if (!$valid) {
                                                                                                                            $this->parser->logOption($errorResult, 'Logexpr', $error);
                                                                                                                        }
                                                                                                                        $valid = true;
                                                                                                                        // End 'operator:NamedCondition?'
                                                                                                                        if (!$valid) {
                                                                                                                            $this->parser->matchError($error9, 'SequenceElement', $error);
                                                                                                                            $error = $error9;
                                                                                                                            break;
                                                                                                                        }
                                                                                                                        break;
                                                                                                                    } while (true);
                                                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                                                    if (!$valid) {
                                                                                                                        $this->parser->failNode($remove);
                                                                                                                        $this->parser->pos = $pos9;
                                                                                                                        $this->parser->line = $line9;
                                                                                                                        $result = $backup9;
                                                                                                                    } else {
                                                                                                                        $this->parser->successNode($remove);
                                                                                                                        }
                                                                                                                        $error = $error9;
                                                                                                                        unset($backup9);
                                                                                                                        // end sequence
                                                                                                                        // End '( left:ModifierValue operator:NamedCondition?)'
                                                                                                                        if ($valid) {
                                                                                                                            $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                                            $error = $error3;
                                                                                                                            break;
                                                                                                                        } else {
                                                                                                                            $this->parser->logOption($errorOption3, 'Logexpr', $error);
                                                                                                                        }
                                                                                                                        $error = $error3;
                                                                                                                        array_pop($this->parser->backtrace);
                                                                                                                        break;
                                                                                                                    } while (true);
                                                                                                                    // end option
                                                                                                                    // End 'Logexpr'
                                                                                                                    if (!$valid) {
                                                                                                                        $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                                                        $error = $error1;
                                                                                                                        break;
                                                                                                                    }
                                                                                                                    $error = array();
                                                                                                                    // Start '( operator:Logical | ( operator:Condition | operator:NamedCondition2) ( operator:Unilog right:ModifierValue) | ( right:ModifierValue operator:NamedCondition?))*' min '0' max 'null'
                                                                                                                    $iteration12 = 0;
                                                                                                                    do {
                                                                                                                        // start sequence
                                                                                                                        $backup13 = $result;
                                                                                                                        $pos13 = $this->parser->pos;
                                                                                                                        $line13 = $this->parser->line;
                                                                                                                        $error13 = $error;
                                                                                                                        $this->parser->addBacktrace(array('_s13_', ''));
                                                                                                                        do {
                                                                                                                            $error = array();
                                                                                                                            // Start 'Logexpr' min '1' max '1'
                                                                                                                            // start option
                                                                                                                            $error15 = $error;
                                                                                                                            $errorOption15 =array();
                                                                                                                            $this->parser->addBacktrace(array('_o15_', ''));
                                                                                                                            do {
                                                                                                                                $error = array();
                                                                                                                                array_pop($this->parser->backtrace);
                                                                                                                                $this->parser->addBacktrace(array('_o15:1_', ''));
                                                                                                                                // Start 'operator:Logical' tag 'operator' min '1' max '1'
                                                                                                                                $this->parser->addBacktrace(array('Logical', ''));
                                                                                                                                $subres = $this->parser->matchRule($result, 'Logical', $error);
                                                                                                                                $remove = array_pop($this->parser->backtrace);
                                                                                                                                if ($subres) {
                                                                                                                                    $this->parser->successNode(array('Logical',  $subres['_text']));
                                                                                                                                    $result['_text'] .= $subres['_text'];
                                                                                                                                    $this->Logexpr___ALL($result, $subres);
                                                                                                                                    $valid = true;
                                                                                                                                } else {
                                                                                                                                    $valid = false;
                                                                                                                                    $this->parser->failNode($remove);
                                                                                                                                }
                                                                                                                                // End 'operator:Logical'
                                                                                                                                if ($valid) {
                                                                                                                                    $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                                                    $error = $error15;
                                                                                                                                    break;
                                                                                                                                } else {
                                                                                                                                    $this->parser->logOption($errorOption15, 'Logexpr', $error);
                                                                                                                                }
                                                                                                                                $error = array();
                                                                                                                                array_pop($this->parser->backtrace);
                                                                                                                                $this->parser->addBacktrace(array('_o15:2_', ''));
                                                                                                                                // Start '( operator:Condition | operator:NamedCondition2)' min '1' max '1'
                                                                                                                                // start option
                                                                                                                                $error18 = $error;
                                                                                                                                $errorOption18 =array();
                                                                                                                                $this->parser->addBacktrace(array('_o18_', ''));
                                                                                                                                do {
                                                                                                                                    $error = array();
                                                                                                                                    array_pop($this->parser->backtrace);
                                                                                                                                    $this->parser->addBacktrace(array('_o18:1_', ''));
                                                                                                                                    // Start 'operator:Condition' tag 'operator' min '1' max '1'
                                                                                                                                    $this->parser->addBacktrace(array('Condition', ''));
                                                                                                                                    $subres = $this->parser->matchRule($result, 'Condition', $error);
                                                                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                                                                    if ($subres) {
                                                                                                                                        $this->parser->successNode(array('Condition',  $subres['_text']));
                                                                                                                                        $result['_text'] .= $subres['_text'];
                                                                                                                                        $this->Logexpr___ALL($result, $subres);
                                                                                                                                        $valid = true;
                                                                                                                                    } else {
                                                                                                                                        $valid = false;
                                                                                                                                        $this->parser->failNode($remove);
                                                                                                                                    }
                                                                                                                                    // End 'operator:Condition'
                                                                                                                                    if ($valid) {
                                                                                                                                        $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                                                        $error = $error18;
                                                                                                                                        break;
                                                                                                                                    } else {
                                                                                                                                        $this->parser->logOption($errorOption18, 'Logexpr', $error);
                                                                                                                                    }
                                                                                                                                    $error = array();
                                                                                                                                    array_pop($this->parser->backtrace);
                                                                                                                                    $this->parser->addBacktrace(array('_o18:2_', ''));
                                                                                                                                    // Start 'operator:NamedCondition2' tag 'operator' min '1' max '1'
                                                                                                                                    $this->parser->addBacktrace(array('NamedCondition2', ''));
                                                                                                                                    $subres = $this->parser->matchRule($result, 'NamedCondition2', $error);
                                                                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                                                                    if ($subres) {
                                                                                                                                        $this->parser->successNode(array('NamedCondition2',  $subres['_text']));
                                                                                                                                        $result['_text'] .= $subres['_text'];
                                                                                                                                        $this->Logexpr___ALL($result, $subres);
                                                                                                                                        $valid = true;
                                                                                                                                    } else {
                                                                                                                                        $valid = false;
                                                                                                                                        $this->parser->failNode($remove);
                                                                                                                                    }
                                                                                                                                    // End 'operator:NamedCondition2'
                                                                                                                                    if ($valid) {
                                                                                                                                        $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                                                        $error = $error18;
                                                                                                                                        break;
                                                                                                                                    } else {
                                                                                                                                        $this->parser->logOption($errorOption18, 'Logexpr', $error);
                                                                                                                                    }
                                                                                                                                    $error = $error18;
                                                                                                                                    array_pop($this->parser->backtrace);
                                                                                                                                    break;
                                                                                                                                } while (true);
                                                                                                                                // end option
                                                                                                                                // End '( operator:Condition | operator:NamedCondition2)'
                                                                                                                                if ($valid) {
                                                                                                                                    $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                                                    $error = $error15;
                                                                                                                                    break;
                                                                                                                                } else {
                                                                                                                                    $this->parser->logOption($errorOption15, 'Logexpr', $error);
                                                                                                                                }
                                                                                                                                $error = $error15;
                                                                                                                                array_pop($this->parser->backtrace);
                                                                                                                                break;
                                                                                                                            } while (true);
                                                                                                                            // end option
                                                                                                                            // End 'Logexpr'
                                                                                                                            if (!$valid) {
                                                                                                                                $this->parser->matchError($error13, 'SequenceElement', $error);
                                                                                                                                $error = $error13;
                                                                                                                                break;
                                                                                                                            }
                                                                                                                            $error = array();
                                                                                                                            // Start 'Logexpr' min '1' max '1'
                                                                                                                            // start option
                                                                                                                            $error22 = $error;
                                                                                                                            $errorOption22 =array();
                                                                                                                            $this->parser->addBacktrace(array('_o22_', ''));
                                                                                                                            do {
                                                                                                                                $error = array();
                                                                                                                                array_pop($this->parser->backtrace);
                                                                                                                                $this->parser->addBacktrace(array('_o22:1_', ''));
                                                                                                                                // Start '( operator:Unilog right:ModifierValue)' min '1' max '1'
                                                                                                                                // start sequence
                                                                                                                                $backup24 = $result;
                                                                                                                                $pos24 = $this->parser->pos;
                                                                                                                                $line24 = $this->parser->line;
                                                                                                                                $error24 = $error;
                                                                                                                                $this->parser->addBacktrace(array('_s24_', ''));
                                                                                                                                do {
                                                                                                                                    $error = array();
                                                                                                                                    // Start 'operator:Unilog' tag 'operator' min '1' max '1'
                                                                                                                                    $this->parser->addBacktrace(array('Unilog', ''));
                                                                                                                                    $subres = $this->parser->matchRule($result, 'Unilog', $error);
                                                                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                                                                    if ($subres) {
                                                                                                                                        $this->parser->successNode(array('Unilog',  $subres['_text']));
                                                                                                                                        $result['_text'] .= $subres['_text'];
                                                                                                                                        $this->Logexpr___ALL($result, $subres);
                                                                                                                                        $valid = true;
                                                                                                                                    } else {
                                                                                                                                        $valid = false;
                                                                                                                                        $this->parser->failNode($remove);
                                                                                                                                    }
                                                                                                                                    // End 'operator:Unilog'
                                                                                                                                    if (!$valid) {
                                                                                                                                        $this->parser->matchError($error24, 'SequenceElement', $error);
                                                                                                                                        $error = $error24;
                                                                                                                                        break;
                                                                                                                                    }
                                                                                                                                    $error = array();
                                                                                                                                    // Start 'right:ModifierValue' tag 'right' min '1' max '1'
                                                                                                                                    $this->parser->addBacktrace(array('ModifierValue', ''));
                                                                                                                                    $subres = $this->parser->matchRule($result, 'ModifierValue', $error);
                                                                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                                                                    if ($subres) {
                                                                                                                                        $this->parser->successNode(array('ModifierValue',  $subres['_text']));
                                                                                                                                        $result['_text'] .= $subres['_text'];
                                                                                                                                        $this->Logexpr___ALL($result, $subres);
                                                                                                                                        $valid = true;
                                                                                                                                    } else {
                                                                                                                                        $valid = false;
                                                                                                                                        $this->parser->failNode($remove);
                                                                                                                                    }
                                                                                                                                    // End 'right:ModifierValue'
                                                                                                                                    if (!$valid) {
                                                                                                                                        $this->parser->matchError($error24, 'SequenceElement', $error);
                                                                                                                                        $error = $error24;
                                                                                                                                        break;
                                                                                                                                    }
                                                                                                                                    break;
                                                                                                                                } while (true);
                                                                                                                                $remove = array_pop($this->parser->backtrace);
                                                                                                                                if (!$valid) {
                                                                                                                                    $this->parser->failNode($remove);
                                                                                                                                    $this->parser->pos = $pos24;
                                                                                                                                    $this->parser->line = $line24;
                                                                                                                                    $result = $backup24;
                                                                                                                                } else {
                                                                                                                                    $this->parser->successNode($remove);
                                                                                                                                    }
                                                                                                                                    $error = $error24;
                                                                                                                                    unset($backup24);
                                                                                                                                    // end sequence
                                                                                                                                    // End '( operator:Unilog right:ModifierValue)'
                                                                                                                                    if ($valid) {
                                                                                                                                        $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                                                        $error = $error22;
                                                                                                                                        break;
                                                                                                                                    } else {
                                                                                                                                        $this->parser->logOption($errorOption22, 'Logexpr', $error);
                                                                                                                                    }
                                                                                                                                    $error = array();
                                                                                                                                    array_pop($this->parser->backtrace);
                                                                                                                                    $this->parser->addBacktrace(array('_o22:2_', ''));
                                                                                                                                    // Start '( right:ModifierValue operator:NamedCondition?)' min '1' max '1'
                                                                                                                                    // start sequence
                                                                                                                                    $backup28 = $result;
                                                                                                                                    $pos28 = $this->parser->pos;
                                                                                                                                    $line28 = $this->parser->line;
                                                                                                                                    $error28 = $error;
                                                                                                                                    $this->parser->addBacktrace(array('_s28_', ''));
                                                                                                                                    do {
                                                                                                                                        $error = array();
                                                                                                                                        // Start 'right:ModifierValue' tag 'right' min '1' max '1'
                                                                                                                                        $this->parser->addBacktrace(array('ModifierValue', ''));
                                                                                                                                        $subres = $this->parser->matchRule($result, 'ModifierValue', $error);
                                                                                                                                        $remove = array_pop($this->parser->backtrace);
                                                                                                                                        if ($subres) {
                                                                                                                                            $this->parser->successNode(array('ModifierValue',  $subres['_text']));
                                                                                                                                            $result['_text'] .= $subres['_text'];
                                                                                                                                            $this->Logexpr___ALL($result, $subres);
                                                                                                                                            $valid = true;
                                                                                                                                        } else {
                                                                                                                                            $valid = false;
                                                                                                                                            $this->parser->failNode($remove);
                                                                                                                                        }
                                                                                                                                        // End 'right:ModifierValue'
                                                                                                                                        if (!$valid) {
                                                                                                                                            $this->parser->matchError($error28, 'SequenceElement', $error);
                                                                                                                                            $error = $error28;
                                                                                                                                            break;
                                                                                                                                        }
                                                                                                                                        $error = array();
                                                                                                                                        // Start 'operator:NamedCondition?' tag 'operator' min '0' max '1'
                                                                                                                                        $error = array();
                                                                                                                                        $this->parser->addBacktrace(array('NamedCondition', ''));
                                                                                                                                        $subres = $this->parser->matchRule($result, 'NamedCondition', $error);
                                                                                                                                        $remove = array_pop($this->parser->backtrace);
                                                                                                                                        if ($subres) {
                                                                                                                                            $this->parser->successNode(array('NamedCondition',  $subres['_text']));
                                                                                                                                            $result['_text'] .= $subres['_text'];
                                                                                                                                            $this->Logexpr___ALL($result, $subres);
                                                                                                                                            $valid = true;
                                                                                                                                        } else {
                                                                                                                                            $valid = false;
                                                                                                                                            $this->parser->failNode($remove);
                                                                                                                                        }
                                                                                                                                        if (!$valid) {
                                                                                                                                            $this->parser->logOption($errorResult, 'Logexpr', $error);
                                                                                                                                        }
                                                                                                                                        $valid = true;
                                                                                                                                        // End 'operator:NamedCondition?'
                                                                                                                                        if (!$valid) {
                                                                                                                                            $this->parser->matchError($error28, 'SequenceElement', $error);
                                                                                                                                            $error = $error28;
                                                                                                                                            break;
                                                                                                                                        }
                                                                                                                                        break;
                                                                                                                                    } while (true);
                                                                                                                                    $remove = array_pop($this->parser->backtrace);
                                                                                                                                    if (!$valid) {
                                                                                                                                        $this->parser->failNode($remove);
                                                                                                                                        $this->parser->pos = $pos28;
                                                                                                                                        $this->parser->line = $line28;
                                                                                                                                        $result = $backup28;
                                                                                                                                    } else {
                                                                                                                                        $this->parser->successNode($remove);
                                                                                                                                        }
                                                                                                                                        $error = $error28;
                                                                                                                                        unset($backup28);
                                                                                                                                        // end sequence
                                                                                                                                        // End '( right:ModifierValue operator:NamedCondition?)'
                                                                                                                                        if ($valid) {
                                                                                                                                            $this->parser->successNode(array_pop($this->parser->backtrace));
                                                                                                                                            $error = $error22;
                                                                                                                                            break;
                                                                                                                                        } else {
                                                                                                                                            $this->parser->logOption($errorOption22, 'Logexpr', $error);
                                                                                                                                        }
                                                                                                                                        $error = $error22;
                                                                                                                                        array_pop($this->parser->backtrace);
                                                                                                                                        break;
                                                                                                                                    } while (true);
                                                                                                                                    // end option
                                                                                                                                    // End 'Logexpr'
                                                                                                                                    if (!$valid) {
                                                                                                                                        $this->parser->matchError($error13, 'SequenceElement', $error);
                                                                                                                                        $error = $error13;
                                                                                                                                        break;
                                                                                                                                    }
                                                                                                                                    break;
                                                                                                                                } while (true);
                                                                                                                                $remove = array_pop($this->parser->backtrace);
                                                                                                                                if (!$valid) {
                                                                                                                                    $this->parser->failNode($remove);
                                                                                                                                    $this->parser->pos = $pos13;
                                                                                                                                    $this->parser->line = $line13;
                                                                                                                                    $result = $backup13;
                                                                                                                                } else {
                                                                                                                                    $this->parser->successNode($remove);
                                                                                                                                    }
                                                                                                                                    $error = $error13;
                                                                                                                                    unset($backup13);
                                                                                                                                    // end sequence
                                                                                                                                    $iteration12 = $valid ? ($iteration12 + 1) : $iteration12;
                                                                                                                                    if (!$valid && $iteration12 >= 0) {
                                                                                                                                        $valid = true;
                                                                                                                                        break;
                                                                                                                                    }
                                                                                                                                    if (!$valid) break;
                                                                                                                                } while (true);
                                                                                                                                // End '( operator:Logical | ( operator:Condition | operator:NamedCondition2) ( operator:Unilog right:ModifierValue) | ( right:ModifierValue operator:NamedCondition?))*'
                                                                                                                                if (!$valid) {
                                                                                                                                    $this->parser->matchError($error1, 'SequenceElement', $error);
                                                                                                                                    $error = $error1;
                                                                                                                                    break;
                                                                                                                                }
                                                                                                                                break;
                                                                                                                            } while (true);
                                                                                                                            $remove = array_pop($this->parser->backtrace);
                                                                                                                            if (!$valid) {
                                                                                                                                $this->parser->failNode($remove);
                                                                                                                                $this->parser->pos = $pos1;
                                                                                                                                $this->parser->line = $line1;
                                                                                                                                $result = $backup1;
                                                                                                                            } else {
                                                                                                                                $this->parser->successNode($remove);
                                                                                                                                }
                                                                                                                                $error = $error1;
                                                                                                                                unset($backup1);
                                                                                                                                // end sequence
                                                                                                                                // End 'Logexpr'
                                                                                                                                if ($valid) {
                                                                                                                                    $result['_endpos'] = $this->parser->pos;
                                                                                                                                    $result['_endline'] = $this->parser->line;
                                                                                                                                }
                                                                                                                                if (!$valid) {
                                                                                                                                    $result = false;
                                                                                                                                    $this->parser->matchError($errorResult, 'token', $error, 'Logexpr');
                                                                                                                                }
                                                                                                                                return $result;
                                                                                                                            }

                                                                                                                            public function Logexpr___ALL (&$result, $subres) {
                                                                                                                                if (!isset($result['node'])) {
                                                                                                                                    $result['node'] = array();
                                                                                                                                }
                                                                                                                                $result['node'][] = $subres['node'];
                                                                                                                            }


                                                                                                                            /**
                                                                                                                             *
                                                                                                                             * Parser rules and action for node 'Condition'
                                                                                                                             *
                                                                                                                             *  Rule:
                                                                                                                            <token Condition>
            <attribute>matchall</attribute>
            <rule>/(\s*(===|!==|==|!=|<>|<=|<|>=|>)\s*)|(\s+(eq|ne|ge|gte|gt|le|lte|lt|instanceof)\s+)/ </rule>
            <action _finish>
            {
                $result['node'] = new Condition($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </token>

                                                                                                                             *
                                                                                                                            */
                                                                                                                            public function matchNodeCondition($previous, &$errorResult){
                                                                                                                                $result = $this->parser->resultDefault;
                                                                                                                                $error = array();
                                                                                                                                $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                                                                                $result['_lineno'] = $this->parser->line;
                                                                                                                                // Start '/(\s*(===|!==|==|!=|<>|<=|<|>=|>)\s*)|(\s+(eq|ne|ge|gte|gt|le|lte|lt|instanceof)\s+)/' min '1' max '1'
                                                                                                                                $regexp = "/(\\s*(===|!==|==|!=|<>|<=|<|>=|>)\\s*)|(\\s+(eq|ne|ge|gte|gt|le|lte|lt|instanceof)\\s+)/";
                                                                                                                                $pos = $this->parser->pos;
                                                                                                                                if (isset($this->parser->regexpCache['Condition2'][$pos])) {
                                                                                                                                    $subres = $this->parser->regexpCache['Condition2'][$pos];
                                                                                                                                } else {
                                                                                                                                    if (empty($this->parser->regexpCache['Condition2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE+PREG_SET_ORDER, $pos)) {
                                                                                                                                        $this->parser->regexpCache['Condition2'][- 1] = true;
                                                                                                                                        foreach ($matches as  $match) {
                                                                                                                                            $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                                                                                                                                            $this->parser->regexpCache['Condition2'][$match[0][1]] = $subres;
                                                                                                                                        }
                                                                                                                                    } else {
                                                                                                                                        $this->parser->regexpCache['Condition2'][- 1] = false;
                                                                                                                                        $subres = false;
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                if (isset($this->parser->regexpCache['Condition2'][$pos])) {
                                                                                                                                    $subres = $this->parser->regexpCache['Condition2'][$pos];
                                                                                                                                } else {
                                                                                                                                    $this->parser->regexpCache['Condition2'][$pos] = false;
                                                                                                                                    $subres = false;
                                                                                                                                }
                                                                                                                                if ($subres) {
                                                                                                                                    $subres['_lineno'] = $this->parser->line;
                                                                                                                                    $this->parser->pos = $subres['_endpos'];
                                                                                                                                    $this->parser->line += substr_count($subres['_text'], "\n");
                                                                                                                                    $subres['_tag'] = false;
                                                                                                                                    $subres['_name'] = 'Condition';
                                                                                                                                    $valid = true;
                                                                                                                                } else {
                                                                                                                                    $valid = false;
                                                                                                                                }
                                                                                                                                if ($valid) {
                                                                                                                                    $result['_text'] .= $subres['_text'];
                                                                                                                                    } else {
                                                                                                                                        $this->parser->matchError($error, 'rx', "/(\\s*(===|!==|==|!=|<>|<=|<|>=|>)\\s*)|(\\s+(eq|ne|ge|gte|gt|le|lte|lt|instanceof)\\s+)/");
                                                                                                                                    }
                                                                                                                                    // End '/(\s*(===|!==|==|!=|<>|<=|<|>=|>)\s*)|(\s+(eq|ne|ge|gte|gt|le|lte|lt|instanceof)\s+)/'
                                                                                                                                    if ($valid) {
                                                                                                                                        $result['_endpos'] = $this->parser->pos;
                                                                                                                                        $result['_endline'] = $this->parser->line;
                                                                                                                                        $this->Condition___FINISH($result);
                                                                                                                                    }
                                                                                                                                    if (!$valid) {
                                                                                                                                        $result = false;
                                                                                                                                        $this->parser->matchError($errorResult, 'token', $error, 'Condition');
                                                                                                                                    }
                                                                                                                                    return $result;
                                                                                                                                }

                                                                                                                                public function Condition___FINISH (&$result) {
                                                                                                                                    $result['node'] = new Condition($this->parser);
                                                                                                                                    $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
                                                                                                                                }


                                                                                                                                /**
                                                                                                                                 *
                                                                                                                                 * Parser rules and action for node 'NamedCondition'
                                                                                                                                 *
                                                                                                                                 *  Rule:
                                                                                                                                <token NamedCondition>
            <attribute>matchall</attribute>
            <rule>/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/ </rule>
        </token>

                                                                                                                                 *
                                                                                                                                */
                                                                                                                                public function matchNodeNamedCondition($previous, &$errorResult){
                                                                                                                                    $result = $this->parser->resultDefault;
                                                                                                                                    $error = array();
                                                                                                                                    $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                                                                                    $result['_lineno'] = $this->parser->line;
                                                                                                                                    // Start '/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/' min '1' max '1'
                                                                                                                                    $regexp = "/\\s+is\\s+(not\\s+)?(((odd|even|div)\\s+by)|in)\\s+/";
                                                                                                                                    $pos = $this->parser->pos;
                                                                                                                                    if (isset($this->parser->regexpCache['NamedCondition2'][$pos])) {
                                                                                                                                        $subres = $this->parser->regexpCache['NamedCondition2'][$pos];
                                                                                                                                    } else {
                                                                                                                                        if (empty($this->parser->regexpCache['NamedCondition2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE+PREG_SET_ORDER, $pos)) {
                                                                                                                                            $this->parser->regexpCache['NamedCondition2'][- 1] = true;
                                                                                                                                            foreach ($matches as  $match) {
                                                                                                                                                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                                                                                                                                                $this->parser->regexpCache['NamedCondition2'][$match[0][1]] = $subres;
                                                                                                                                            }
                                                                                                                                        } else {
                                                                                                                                            $this->parser->regexpCache['NamedCondition2'][- 1] = false;
                                                                                                                                            $subres = false;
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                    if (isset($this->parser->regexpCache['NamedCondition2'][$pos])) {
                                                                                                                                        $subres = $this->parser->regexpCache['NamedCondition2'][$pos];
                                                                                                                                    } else {
                                                                                                                                        $this->parser->regexpCache['NamedCondition2'][$pos] = false;
                                                                                                                                        $subres = false;
                                                                                                                                    }
                                                                                                                                    if ($subres) {
                                                                                                                                        $subres['_lineno'] = $this->parser->line;
                                                                                                                                        $this->parser->pos = $subres['_endpos'];
                                                                                                                                        $this->parser->line += substr_count($subres['_text'], "\n");
                                                                                                                                        $subres['_tag'] = false;
                                                                                                                                        $subres['_name'] = 'NamedCondition';
                                                                                                                                        $valid = true;
                                                                                                                                    } else {
                                                                                                                                        $valid = false;
                                                                                                                                    }
                                                                                                                                    if ($valid) {
                                                                                                                                        $result['_text'] .= $subres['_text'];
                                                                                                                                        } else {
                                                                                                                                            $this->parser->matchError($error, 'rx', "/\\s+is\\s+(not\\s+)?(((odd|even|div)\\s+by)|in)\\s+/");
                                                                                                                                        }
                                                                                                                                        // End '/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/'
                                                                                                                                        if ($valid) {
                                                                                                                                            $result['_endpos'] = $this->parser->pos;
                                                                                                                                            $result['_endline'] = $this->parser->line;
                                                                                                                                        }
                                                                                                                                        if (!$valid) {
                                                                                                                                            $result = false;
                                                                                                                                            $this->parser->matchError($errorResult, 'token', $error, 'NamedCondition');
                                                                                                                                        }
                                                                                                                                        return $result;
                                                                                                                                    }

                                                                                                                                    /**
                                                                                                                                     *
                                                                                                                                     * Parser rules and action for node 'NamedCondition2'
                                                                                                                                     *
                                                                                                                                     *  Rule:
                                                                                                                                    

        <token Logical>
            <attribute>matchall</attribute>
            <rule>/\s*((\|\||&&)\s*)|((and|or|xor)\s+)/</rule>
            <action _finish>
            {
                $result['node'] = new Logical($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </token>

                                                                                                                                     *
                                                                                                                                    */
                                                                                                                                    public function matchNodeNamedCondition2($previous, &$errorResult){
                                                                                                                                        $result = $this->parser->resultDefault;
                                                                                                                                        $error = array();
                                                                                                                                        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                                                                                        $result['_lineno'] = $this->parser->line;
                                                                                                                                        // Start '/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/' min '1' max '1'
                                                                                                                                        $regexp = "/\\s+is\\s+(not\\s+)?(((odd|even|div)\\s+by)|in)\\s+/";
                                                                                                                                        $pos = $this->parser->pos;
                                                                                                                                        if (isset($this->parser->regexpCache['NamedCondition22'][$pos])) {
                                                                                                                                            $subres = $this->parser->regexpCache['NamedCondition22'][$pos];
                                                                                                                                        } else {
                                                                                                                                            if (empty($this->parser->regexpCache['NamedCondition22']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE+PREG_SET_ORDER, $pos)) {
                                                                                                                                                $this->parser->regexpCache['NamedCondition22'][- 1] = true;
                                                                                                                                                foreach ($matches as  $match) {
                                                                                                                                                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                                                                                                                                                    $this->parser->regexpCache['NamedCondition22'][$match[0][1]] = $subres;
                                                                                                                                                }
                                                                                                                                            } else {
                                                                                                                                                $this->parser->regexpCache['NamedCondition22'][- 1] = false;
                                                                                                                                                $subres = false;
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                                        if (isset($this->parser->regexpCache['NamedCondition22'][$pos])) {
                                                                                                                                            $subres = $this->parser->regexpCache['NamedCondition22'][$pos];
                                                                                                                                        } else {
                                                                                                                                            $this->parser->regexpCache['NamedCondition22'][$pos] = false;
                                                                                                                                            $subres = false;
                                                                                                                                        }
                                                                                                                                        if ($subres) {
                                                                                                                                            $subres['_lineno'] = $this->parser->line;
                                                                                                                                            $this->parser->pos = $subres['_endpos'];
                                                                                                                                            $this->parser->line += substr_count($subres['_text'], "\n");
                                                                                                                                            $subres['_tag'] = false;
                                                                                                                                            $subres['_name'] = 'NamedCondition2';
                                                                                                                                            $valid = true;
                                                                                                                                        } else {
                                                                                                                                            $valid = false;
                                                                                                                                        }
                                                                                                                                        if ($valid) {
                                                                                                                                            $result['_text'] .= $subres['_text'];
                                                                                                                                            } else {
                                                                                                                                                $this->parser->matchError($error, 'rx', "/\\s+is\\s+(not\\s+)?(((odd|even|div)\\s+by)|in)\\s+/");
                                                                                                                                            }
                                                                                                                                            // End '/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/'
                                                                                                                                            if ($valid) {
                                                                                                                                                $result['_endpos'] = $this->parser->pos;
                                                                                                                                                $result['_endline'] = $this->parser->line;
                                                                                                                                            }
                                                                                                                                            if (!$valid) {
                                                                                                                                                $result = false;
                                                                                                                                                $this->parser->matchError($errorResult, 'token', $error, 'NamedCondition2');
                                                                                                                                            }
                                                                                                                                            return $result;
                                                                                                                                        }

                                                                                                                                        /**
                                                                                                                                         *
                                                                                                                                         * Parser rules and action for node 'Logical'
                                                                                                                                         *
                                                                                                                                         *  Rule:
                                                                                                                                        <token Logical>
            <attribute>matchall</attribute>
            <rule>/\s*((\|\||&&)\s*)|((and|or|xor)\s+)/</rule>
            <action _finish>
            {
                $result['node'] = new Logical($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </token>

                                                                                                                                         *
                                                                                                                                        */
                                                                                                                                        public function matchNodeLogical($previous, &$errorResult){
                                                                                                                                            $result = $this->parser->resultDefault;
                                                                                                                                            $error = array();
                                                                                                                                            $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                                                                                            $result['_lineno'] = $this->parser->line;
                                                                                                                                            // Start '/\s*((\|\||&&)\s*)|((and|or|xor)\s+)/' min '1' max '1'
                                                                                                                                            $regexp = "/\\s*((\\|\\||&&)\\s*)|((and|or|xor)\\s+)/";
                                                                                                                                            $pos = $this->parser->pos;
                                                                                                                                            if (isset($this->parser->regexpCache['Logical2'][$pos])) {
                                                                                                                                                $subres = $this->parser->regexpCache['Logical2'][$pos];
                                                                                                                                            } else {
                                                                                                                                                if (empty($this->parser->regexpCache['Logical2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE+PREG_SET_ORDER, $pos)) {
                                                                                                                                                    $this->parser->regexpCache['Logical2'][- 1] = true;
                                                                                                                                                    foreach ($matches as  $match) {
                                                                                                                                                        $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                                                                                                                                                        $this->parser->regexpCache['Logical2'][$match[0][1]] = $subres;
                                                                                                                                                    }
                                                                                                                                                } else {
                                                                                                                                                    $this->parser->regexpCache['Logical2'][- 1] = false;
                                                                                                                                                    $subres = false;
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            if (isset($this->parser->regexpCache['Logical2'][$pos])) {
                                                                                                                                                $subres = $this->parser->regexpCache['Logical2'][$pos];
                                                                                                                                            } else {
                                                                                                                                                $this->parser->regexpCache['Logical2'][$pos] = false;
                                                                                                                                                $subres = false;
                                                                                                                                            }
                                                                                                                                            if ($subres) {
                                                                                                                                                $subres['_lineno'] = $this->parser->line;
                                                                                                                                                $this->parser->pos = $subres['_endpos'];
                                                                                                                                                $this->parser->line += substr_count($subres['_text'], "\n");
                                                                                                                                                $subres['_tag'] = false;
                                                                                                                                                $subres['_name'] = 'Logical';
                                                                                                                                                $valid = true;
                                                                                                                                            } else {
                                                                                                                                                $valid = false;
                                                                                                                                            }
                                                                                                                                            if ($valid) {
                                                                                                                                                $result['_text'] .= $subres['_text'];
                                                                                                                                                } else {
                                                                                                                                                    $this->parser->matchError($error, 'rx', "/\\s*((\\|\\||&&)\\s*)|((and|or|xor)\\s+)/");
                                                                                                                                                }
                                                                                                                                                // End '/\s*((\|\||&&)\s*)|((and|or|xor)\s+)/'
                                                                                                                                                if ($valid) {
                                                                                                                                                    $result['_endpos'] = $this->parser->pos;
                                                                                                                                                    $result['_endline'] = $this->parser->line;
                                                                                                                                                    $this->Logical___FINISH($result);
                                                                                                                                                }
                                                                                                                                                if (!$valid) {
                                                                                                                                                    $result = false;
                                                                                                                                                    $this->parser->matchError($errorResult, 'token', $error, 'Logical');
                                                                                                                                                }
                                                                                                                                                return $result;
                                                                                                                                            }

                                                                                                                                            public function Logical___FINISH (&$result) {
                                                                                                                                                $result['node'] = new Logical($this->parser);
                                                                                                                                                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
                                                                                                                                            }


                                                                                                                                            /**
                                                                                                                                             *
                                                                                                                                             * Parser rules and action for node 'Math'
                                                                                                                                             *
                                                                                                                                             *  Rule:
                                                                                                                                            <node Math>
            <attribute>matchall</attribute>
            <rule>/(\s*(\*|\/|%|&|\|^|>>|<<)\s*)|(\s+mod\s+)/</rule>
            <action _finish>
            {
                $result['node'] = new Math($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

                                                                                                                                             *
                                                                                                                                            */
                                                                                                                                            public function matchNodeMath($previous, &$errorResult){
                                                                                                                                                $result = $this->parser->resultDefault;
                                                                                                                                                $error = array();
                                                                                                                                                $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                                                                                                $result['_lineno'] = $this->parser->line;
                                                                                                                                                // Start '/(\s*(\*|\/|%|&|\|^|>>|<<)\s*)|(\s+mod\s+)/' min '1' max '1'
                                                                                                                                                $regexp = "/(\\s*(\\*|\\/|%|&|\\|^|>>|<<)\\s*)|(\\s+mod\\s+)/";
                                                                                                                                                $pos = $this->parser->pos;
                                                                                                                                                if (isset($this->parser->regexpCache['Math2'][$pos])) {
                                                                                                                                                    $subres = $this->parser->regexpCache['Math2'][$pos];
                                                                                                                                                } else {
                                                                                                                                                    if (empty($this->parser->regexpCache['Math2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE+PREG_SET_ORDER, $pos)) {
                                                                                                                                                        $this->parser->regexpCache['Math2'][- 1] = true;
                                                                                                                                                        foreach ($matches as  $match) {
                                                                                                                                                            $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                                                                                                                                                            $this->parser->regexpCache['Math2'][$match[0][1]] = $subres;
                                                                                                                                                        }
                                                                                                                                                    } else {
                                                                                                                                                        $this->parser->regexpCache['Math2'][- 1] = false;
                                                                                                                                                        $subres = false;
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                                if (isset($this->parser->regexpCache['Math2'][$pos])) {
                                                                                                                                                    $subres = $this->parser->regexpCache['Math2'][$pos];
                                                                                                                                                } else {
                                                                                                                                                    $this->parser->regexpCache['Math2'][$pos] = false;
                                                                                                                                                    $subres = false;
                                                                                                                                                }
                                                                                                                                                if ($subres) {
                                                                                                                                                    $subres['_lineno'] = $this->parser->line;
                                                                                                                                                    $this->parser->pos = $subres['_endpos'];
                                                                                                                                                    $this->parser->line += substr_count($subres['_text'], "\n");
                                                                                                                                                    $subres['_tag'] = false;
                                                                                                                                                    $subres['_name'] = 'Math';
                                                                                                                                                    $valid = true;
                                                                                                                                                } else {
                                                                                                                                                    $valid = false;
                                                                                                                                                }
                                                                                                                                                if ($valid) {
                                                                                                                                                    $result['_text'] .= $subres['_text'];
                                                                                                                                                    } else {
                                                                                                                                                        $this->parser->matchError($error, 'rx', "/(\\s*(\\*|\\/|%|&|\\|^|>>|<<)\\s*)|(\\s+mod\\s+)/");
                                                                                                                                                    }
                                                                                                                                                    // End '/(\s*(\*|\/|%|&|\|^|>>|<<)\s*)|(\s+mod\s+)/'
                                                                                                                                                    if ($valid) {
                                                                                                                                                        $result['_endpos'] = $this->parser->pos;
                                                                                                                                                        $result['_endline'] = $this->parser->line;
                                                                                                                                                        $this->Math___FINISH($result);
                                                                                                                                                    }
                                                                                                                                                    if (!$valid) {
                                                                                                                                                        $result = false;
                                                                                                                                                        $this->parser->matchError($errorResult, 'token', $error, 'Math');
                                                                                                                                                    }
                                                                                                                                                    return $result;
                                                                                                                                                }

                                                                                                                                                public function Math___FINISH (&$result) {
                                                                                                                                                    $result['node'] = new Math($this->parser);
                                                                                                                                                    $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
                                                                                                                                                }


                                                                                                                                                /**
                                                                                                                                                 *
                                                                                                                                                 * Parser rules and action for node 'Unimath'
                                                                                                                                                 *
                                                                                                                                                 *  Rule:
                                                                                                                                                <node Unimath>
            <attribute>matchall</attribute>
            <rule>/\s*(\+|-|~)\s* /</rule>
            <action _finish>
            {
                $result['node'] = new Unimath($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
         </node>

                                                                                                                                                 *
                                                                                                                                                */
                                                                                                                                                public function matchNodeUnimath($previous, &$errorResult){
                                                                                                                                                    $result = $this->parser->resultDefault;
                                                                                                                                                    $error = array();
                                                                                                                                                    $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                                                                                                    $result['_lineno'] = $this->parser->line;
                                                                                                                                                    // Start '/\s*(\+|-|~)\s* /' min '1' max '1'
                                                                                                                                                    $regexp = "/\\s*(\\+|-|~)\\s* /";
                                                                                                                                                    $pos = $this->parser->pos;
                                                                                                                                                    if (isset($this->parser->regexpCache['Unimath2'][$pos])) {
                                                                                                                                                        $subres = $this->parser->regexpCache['Unimath2'][$pos];
                                                                                                                                                    } else {
                                                                                                                                                        if (empty($this->parser->regexpCache['Unimath2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE+PREG_SET_ORDER, $pos)) {
                                                                                                                                                            $this->parser->regexpCache['Unimath2'][- 1] = true;
                                                                                                                                                            foreach ($matches as  $match) {
                                                                                                                                                                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                                                                                                                                                                $this->parser->regexpCache['Unimath2'][$match[0][1]] = $subres;
                                                                                                                                                            }
                                                                                                                                                        } else {
                                                                                                                                                            $this->parser->regexpCache['Unimath2'][- 1] = false;
                                                                                                                                                            $subres = false;
                                                                                                                                                        }
                                                                                                                                                    }
                                                                                                                                                    if (isset($this->parser->regexpCache['Unimath2'][$pos])) {
                                                                                                                                                        $subres = $this->parser->regexpCache['Unimath2'][$pos];
                                                                                                                                                    } else {
                                                                                                                                                        $this->parser->regexpCache['Unimath2'][$pos] = false;
                                                                                                                                                        $subres = false;
                                                                                                                                                    }
                                                                                                                                                    if ($subres) {
                                                                                                                                                        $subres['_lineno'] = $this->parser->line;
                                                                                                                                                        $this->parser->pos = $subres['_endpos'];
                                                                                                                                                        $this->parser->line += substr_count($subres['_text'], "\n");
                                                                                                                                                        $subres['_tag'] = false;
                                                                                                                                                        $subres['_name'] = 'Unimath';
                                                                                                                                                        $valid = true;
                                                                                                                                                    } else {
                                                                                                                                                        $valid = false;
                                                                                                                                                    }
                                                                                                                                                    if ($valid) {
                                                                                                                                                        $result['_text'] .= $subres['_text'];
                                                                                                                                                        } else {
                                                                                                                                                            $this->parser->matchError($error, 'rx', "/\\s*(\\+|-|~)\\s* /");
                                                                                                                                                        }
                                                                                                                                                        // End '/\s*(\+|-|~)\s* /'
                                                                                                                                                        if ($valid) {
                                                                                                                                                            $result['_endpos'] = $this->parser->pos;
                                                                                                                                                            $result['_endline'] = $this->parser->line;
                                                                                                                                                            $this->Unimath___FINISH($result);
                                                                                                                                                        }
                                                                                                                                                        if (!$valid) {
                                                                                                                                                            $result = false;
                                                                                                                                                            $this->parser->matchError($errorResult, 'token', $error, 'Unimath');
                                                                                                                                                        }
                                                                                                                                                        return $result;
                                                                                                                                                    }

                                                                                                                                                    public function Unimath___FINISH (&$result) {
                                                                                                                                                        $result['node'] = new Unimath($this->parser);
                                                                                                                                                        $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
                                                                                                                                                    }


                                                                                                                                                    /**
                                                                                                                                                     *
                                                                                                                                                     * Parser rules and action for node 'Unilog'
                                                                                                                                                     *
                                                                                                                                                     *  Rule:
                                                                                                                                                    <node Unilog>
            <attribute>matchall</attribute>
            <rule>/((!|~)\s*)|(not\s+)/</rule>
            <action _finish>
            {
                $result['node'] = new Unilog($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

                                                                                                                                                     *
                                                                                                                                                    */
                                                                                                                                                    public function matchNodeUnilog($previous, &$errorResult){
                                                                                                                                                        $result = $this->parser->resultDefault;
                                                                                                                                                        $error = array();
                                                                                                                                                        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
                                                                                                                                                        $result['_lineno'] = $this->parser->line;
                                                                                                                                                        // Start '/((!|~)\s*)|(not\s+)/' min '1' max '1'
                                                                                                                                                        $regexp = "/((!|~)\\s*)|(not\\s+)/";
                                                                                                                                                        $pos = $this->parser->pos;
                                                                                                                                                        if (isset($this->parser->regexpCache['Unilog2'][$pos])) {
                                                                                                                                                            $subres = $this->parser->regexpCache['Unilog2'][$pos];
                                                                                                                                                        } else {
                                                                                                                                                            if (empty($this->parser->regexpCache['Unilog2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE+PREG_SET_ORDER, $pos)) {
                                                                                                                                                                $this->parser->regexpCache['Unilog2'][- 1] = true;
                                                                                                                                                                foreach ($matches as  $match) {
                                                                                                                                                                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                                                                                                                                                                    $this->parser->regexpCache['Unilog2'][$match[0][1]] = $subres;
                                                                                                                                                                }
                                                                                                                                                            } else {
                                                                                                                                                                $this->parser->regexpCache['Unilog2'][- 1] = false;
                                                                                                                                                                $subres = false;
                                                                                                                                                            }
                                                                                                                                                        }
                                                                                                                                                        if (isset($this->parser->regexpCache['Unilog2'][$pos])) {
                                                                                                                                                            $subres = $this->parser->regexpCache['Unilog2'][$pos];
                                                                                                                                                        } else {
                                                                                                                                                            $this->parser->regexpCache['Unilog2'][$pos] = false;
                                                                                                                                                            $subres = false;
                                                                                                                                                        }
                                                                                                                                                        if ($subres) {
                                                                                                                                                            $subres['_lineno'] = $this->parser->line;
                                                                                                                                                            $this->parser->pos = $subres['_endpos'];
                                                                                                                                                            $this->parser->line += substr_count($subres['_text'], "\n");
                                                                                                                                                            $subres['_tag'] = false;
                                                                                                                                                            $subres['_name'] = 'Unilog';
                                                                                                                                                            $valid = true;
                                                                                                                                                        } else {
                                                                                                                                                            $valid = false;
                                                                                                                                                        }
                                                                                                                                                        if ($valid) {
                                                                                                                                                            $result['_text'] .= $subres['_text'];
                                                                                                                                                            } else {
                                                                                                                                                                $this->parser->matchError($error, 'rx', "/((!|~)\\s*)|(not\\s+)/");
                                                                                                                                                            }
                                                                                                                                                            // End '/((!|~)\s*)|(not\s+)/'
                                                                                                                                                            if ($valid) {
                                                                                                                                                                $result['_endpos'] = $this->parser->pos;
                                                                                                                                                                $result['_endline'] = $this->parser->line;
                                                                                                                                                                $this->Unilog___FINISH($result);
                                                                                                                                                            }
                                                                                                                                                            if (!$valid) {
                                                                                                                                                                $result = false;
                                                                                                                                                                $this->parser->matchError($errorResult, 'token', $error, 'Unilog');
                                                                                                                                                            }
                                                                                                                                                            return $result;
                                                                                                                                                        }

                                                                                                                                                        public function Unilog___FINISH (&$result) {
                                                                                                                                                            $result['node'] = new Unilog($this->parser);
                                                                                                                                                            $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
                                                                                                                                                        }




}

