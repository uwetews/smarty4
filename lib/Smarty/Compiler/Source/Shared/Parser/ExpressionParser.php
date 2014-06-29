<?php
namespace Smarty\Compiler\Source\Shared\Parser;

use Smarty\Node;
use Smarty\PegParser;

/**
 * Class ExpressionParser
 *
 * @package Smarty\Compiler\Source\Shared\Parser
 */
class ExpressionParser extends PegParser
{

   
    /**
     *
     * Parser generated on 2014-06-29 18:39:51
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Shared/Parser/Expression.peg.inc' dated 2014-06-29 18:19:25
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
            "Logop" => "matchNodeLogop",
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
            "Logop" => array(
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
                $result['node'] = new Node\Value\Number($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

     *
    */
    public function matchNodeNumber($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        if (isset($this->parser->packCache[$this->parser->pos]['Number'])) {
            $result = $this->parser->packCache[$this->parser->pos]['Number'];
            if ($result) {
                $this->parser->pos = $result['_endpos'];
                $this->parser->line = $result['_endline'];
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
        }
        // End '/\[0-9]+(?:\.[0-9]+)?/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Number___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        $this->parser->packCache[$pos0]['Number'] = $result;
        return $result;
    }

    public function Number___FINISH (&$result) {
        $result['node'] = new Node\Value\Number($this->parser);
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
                $result['node'] = new Node\Value\String($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

     *
    */
    public function matchNodeString($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        if (isset($this->parser->packCache[$this->parser->pos]['String'])) {
            $result = $this->parser->packCache[$this->parser->pos]['String'];
            if ($result) {
                $this->parser->pos = $result['_endpos'];
                $this->parser->line = $result['_endline'];
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
        }
        // End '/'[^'\\]*(?:\\.[^'\\]*)*'/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->String___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        $this->parser->packCache[$pos0]['String'] = $result;
        return $result;
    }

    public function String___FINISH (&$result) {
        $result['node'] = new Node\Value\String($this->parser);
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
                $result['node'] = new Node\Value\Boolean($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

     *
    */
    public function matchNodeBoolean($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        if (isset($this->parser->packCache[$this->parser->pos]['Boolean'])) {
            $result = $this->parser->packCache[$this->parser->pos]['Boolean'];
            if ($result) {
                $this->parser->pos = $result['_endpos'];
                $this->parser->line = $result['_endline'];
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
        }
        // End '/(true|false)(?![^a-zA-Z0-9])/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Boolean___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        $this->parser->packCache[$pos0]['Boolean'] = $result;
        return $result;
    }

    public function Boolean___FINISH (&$result) {
        $result['node'] = new Node\Value\Boolean($this->parser);
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
                $result['node'] = new Node\Value\Null($this->parser);
                $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

     *
    */
    public function matchNodeNull($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        if (isset($this->parser->packCache[$this->parser->pos]['Null'])) {
            $result = $this->parser->packCache[$this->parser->pos]['Null'];
            if ($result) {
                $this->parser->pos = $result['_endpos'];
                $this->parser->line = $result['_endline'];
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
        }
        // End '/null(?![^a-zA-Z0-9])/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Null___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        $this->parser->packCache[$pos0]['Null'] = $result;
        return $result;
    }

    public function Null___FINISH (&$result) {
        $result['node'] = new Node\Value\Null($this->parser);
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
                $result['node'] = new Node\Value\Number($this->parser);
                $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            }
            </action>
            <action string>
            {
                $result['node'] = new Node\Value\String($this->parser);
                $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            }
            </action>
            <action bool>
            {
                $result['node'] = new Node\Value\Boolean($this->parser);
                $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            }
            </action>
            <action null>
            {
                $result['node'] = new Node\Value\Null($this->parser);
                $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            }
            </action>
        </token>

     *
    */
    public function matchNodeAnyLiteral($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        if (isset($this->parser->packCache[$this->parser->pos]['AnyLiteral'])) {
            $result = $this->parser->packCache[$this->parser->pos]['AnyLiteral'];
            if ($result) {
                $this->parser->pos = $result['_endpos'];
                $this->parser->line = $result['_endline'];
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
        }
        // End '/(?<number>([0-9]+(?:\.[0-9]+)?))|(?<string>('[^'\\]*(?:\\.[^'\\]*)*'))|(((?<null>null)|(?<bool>(true|false)))(?![_a-zA-Z0-9]))/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        $this->parser->packCache[$pos0]['AnyLiteral'] = $result;
        return $result;
    }

    public function AnyLiteral___START (&$result, $previous) {
        $i = 1;
    }


    public function AnyLiteral_number (&$result, $subres) {
        $result['node'] = new Node\Value\Number($this->parser);
        $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
    }


    public function AnyLiteral_string (&$result, $subres) {
        $result['node'] = new Node\Value\String($this->parser);
        $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
    }


    public function AnyLiteral_bool (&$result, $subres) {
        $result['node'] = new Node\Value\Boolean($this->parser);
        $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
    }


    public function AnyLiteral_null (&$result, $subres) {
        $result['node'] = new Node\Value\Null($this->parser);
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
    public function matchNodeArray($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Array' min '1' max '1'
        // start option
        do {
            // Start '( 'array' _? '(' item:Arrayitem ( ',' item:Arrayitem)* ','? ')')' min '1' max '1'
            // start sequence
            $backup2 = $result;
            $pos2 = $this->parser->pos;
            $line2 = $this->parser->line;
            do {
                // Start ''array'' min '1' max '1'
                if ('array' == substr($this->parser->source, $this->parser->pos, 5)) {
                    $this->parser->pos += 5;
                    $result['_text'] .= 'array';
                    $this->parser->successLiteral('array');
                    $valid = true;
                } else {
                    $this->parser->failLiteral('array');
                    $valid = false;
                }
                // End ''array''
                if (!$valid) {
                    break;
                }
                // Start '_?' min '1' max '1'
                if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                    if ($match[0]) {
                        $this->parser->pos += strlen($match[0]);
                        $this->parser->line += substr_count($match[0], "\n");
                        $result['_text'] .= ' ';
                    }
                }
                $valid = true;
                // End '_?'
                if (!$valid) {
                    break;
                }
                // Start ''('' min '1' max '1'
                if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= '(';
                    $this->parser->successLiteral('(');
                    $valid = true;
                } else {
                    $this->parser->failLiteral('(');
                    $valid = false;
                }
                // End ''(''
                if (!$valid) {
                    break;
                }
                // Start 'item:Arrayitem' tag 'item' min '1' max '1'
                $this->parser->addBacktrace(array('Arrayitem', $result));
                $subres = $this->parser->matchRule($result, 'Arrayitem');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Arrayitem',  $subres));
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
                    break;
                }
                // Start '( ',' item:Arrayitem)*' min '0' max 'null'
                $iteration7 = 0;
                do {
                    // start sequence
                    $backup8 = $result;
                    $pos8 = $this->parser->pos;
                    $line8 = $this->parser->line;
                    do {
                        // Start '','' min '1' max '1'
                        if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                            $this->parser->pos += 1;
                            $result['_text'] .= ',';
                            $this->parser->successLiteral(',');
                            $valid = true;
                        } else {
                            $this->parser->failLiteral(',');
                            $valid = false;
                        }
                        // End '',''
                        if (!$valid) {
                            break;
                        }
                        // Start 'item:Arrayitem' tag 'item' min '1' max '1'
                        $this->parser->addBacktrace(array('Arrayitem', $result));
                        $subres = $this->parser->matchRule($result, 'Arrayitem');
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('Arrayitem',  $subres));
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
                            break;
                        }
                        break;
                    } while (true);
                    if (!$valid) {
                        $this->parser->pos = $pos8;
                        $this->parser->line = $line8;
                        $result = $backup8;
                    }
                    unset($backup8);
                    // end sequence
                    $iteration7 = $valid ? ($iteration7 + 1) : $iteration7;
                    if (!$valid && $iteration7 >= 0) {
                        $valid = true;
                        break;
                    }
                    if (!$valid) break;
                } while (true);
                // End '( ',' item:Arrayitem)*'
                if (!$valid) {
                    break;
                }
                // Start '','?' min '0' max '1'
                if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= ',';
                    $this->parser->successLiteral(',');
                    $valid = true;
                } else {
                    $this->parser->failLiteral(',');
                    $valid = false;
                }
                $valid = true;
                // End '','?'
                if (!$valid) {
                    break;
                }
                // Start '')'' min '1' max '1'
                if (')' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= ')';
                    $this->parser->successLiteral(')');
                    $valid = true;
                } else {
                    $this->parser->failLiteral(')');
                    $valid = false;
                }
                // End '')''
                if (!$valid) {
                    break;
                }
                break;
            } while (true);
            if (!$valid) {
                $this->parser->pos = $pos2;
                $this->parser->line = $line2;
                $result = $backup2;
            }
            unset($backup2);
            // end sequence
            // End '( 'array' _? '(' item:Arrayitem ( ',' item:Arrayitem)* ','? ')')'
            if ($valid) {
                break;
            }
            // Start '( '[' item:Arrayitem ( ',' item:Arrayitem)* ','? ']')' min '1' max '1'
            // start sequence
            $backup14 = $result;
            $pos14 = $this->parser->pos;
            $line14 = $this->parser->line;
            do {
                // Start ''['' min '1' max '1'
                if ('[' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= '[';
                    $this->parser->successLiteral('[');
                    $valid = true;
                } else {
                    $this->parser->failLiteral('[');
                    $valid = false;
                }
                // End ''[''
                if (!$valid) {
                    break;
                }
                // Start 'item:Arrayitem' tag 'item' min '1' max '1'
                $this->parser->addBacktrace(array('Arrayitem', $result));
                $subres = $this->parser->matchRule($result, 'Arrayitem');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Arrayitem',  $subres));
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
                    break;
                }
                // Start '( ',' item:Arrayitem)*' min '0' max 'null'
                $iteration17 = 0;
                do {
                    // start sequence
                    $backup18 = $result;
                    $pos18 = $this->parser->pos;
                    $line18 = $this->parser->line;
                    do {
                        // Start '','' min '1' max '1'
                        if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                            $this->parser->pos += 1;
                            $result['_text'] .= ',';
                            $this->parser->successLiteral(',');
                            $valid = true;
                        } else {
                            $this->parser->failLiteral(',');
                            $valid = false;
                        }
                        // End '',''
                        if (!$valid) {
                            break;
                        }
                        // Start 'item:Arrayitem' tag 'item' min '1' max '1'
                        $this->parser->addBacktrace(array('Arrayitem', $result));
                        $subres = $this->parser->matchRule($result, 'Arrayitem');
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('Arrayitem',  $subres));
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
                            break;
                        }
                        break;
                    } while (true);
                    if (!$valid) {
                        $this->parser->pos = $pos18;
                        $this->parser->line = $line18;
                        $result = $backup18;
                    }
                    unset($backup18);
                    // end sequence
                    $iteration17 = $valid ? ($iteration17 + 1) : $iteration17;
                    if (!$valid && $iteration17 >= 0) {
                        $valid = true;
                        break;
                    }
                    if (!$valid) break;
                } while (true);
                // End '( ',' item:Arrayitem)*'
                if (!$valid) {
                    break;
                }
                // Start '','?' min '0' max '1'
                if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= ',';
                    $this->parser->successLiteral(',');
                    $valid = true;
                } else {
                    $this->parser->failLiteral(',');
                    $valid = false;
                }
                $valid = true;
                // End '','?'
                if (!$valid) {
                    break;
                }
                // Start '']'' min '1' max '1'
                if (']' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= ']';
                    $this->parser->successLiteral(']');
                    $valid = true;
                } else {
                    $this->parser->failLiteral(']');
                    $valid = false;
                }
                // End '']''
                if (!$valid) {
                    break;
                }
                break;
            } while (true);
            if (!$valid) {
                $this->parser->pos = $pos14;
                $this->parser->line = $line14;
                $result = $backup14;
            }
            unset($backup14);
            // end sequence
            // End '( '[' item:Arrayitem ( ',' item:Arrayitem)* ','? ']')'
            if ($valid) {
                break;
            }
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
    public function matchNodeArrayitem($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '( index:Value _? '=>' _?)?' min '0' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'index:Value' tag 'index' min '1' max '1'
            $this->parser->addBacktrace(array('Value', $result));
            $subres = $this->parser->matchRule($result, 'Value');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Value',  $subres));
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
                break;
            }
            // Start '_?' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                if ($match[0]) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                    $result['_text'] .= ' ';
                }
            }
            $valid = true;
            // End '_?'
            if (!$valid) {
                break;
            }
            // Start ''=>'' min '1' max '1'
            if ('=>' == substr($this->parser->source, $this->parser->pos, 2)) {
                $this->parser->pos += 2;
                $result['_text'] .= '=>';
                $this->parser->successLiteral('=>');
                $valid = true;
            } else {
                $this->parser->failLiteral('=>');
                $valid = false;
            }
            // End ''=>''
            if (!$valid) {
                break;
            }
            // Start '_?' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                if ($match[0]) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                    $result['_text'] .= ' ';
                }
            }
            $valid = true;
            // End '_?'
            if (!$valid) {
                break;
            }
            // Start 'value:Value' tag 'value' min '1' max '1'
            $this->parser->addBacktrace(array('Value', $result));
            $subres = $this->parser->matchRule($result, 'Value');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Value',  $subres));
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
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        }
        unset($backup1);
        // end sequence
        $valid = true;
        // End '( index:Value _? '=>' _?)?'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
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
                    $string = new Node\Value\String($this->parser);
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
    public function matchNodeFunctioncall($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Functioncall' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start '( name:Id | namevar:Variable)' min '1' max '1'
            // start option
            do {
                // Start 'name:Id' tag 'name' min '1' max '1'
                $this->parser->addBacktrace(array('Id', $result));
                $subres = $this->parser->matchRule($result, 'Id');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Id',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Functioncall_name($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'name:Id'
                if ($valid) {
                    break;
                }
                // Start 'namevar:Variable' tag 'namevar' min '1' max '1'
                $this->parser->addBacktrace(array('Variable', $result));
                $subres = $this->parser->matchRule($result, 'Variable');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Variable',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Functioncall_namevar($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'namevar:Variable'
                if ($valid) {
                    break;
                }
                break;
            } while (true);
            // end option
            // End '( name:Id | namevar:Variable)'
            if (!$valid) {
                break;
            }
            // Start 'param:Parameter' tag 'param' min '1' max '1'
            $this->parser->addBacktrace(array('Parameter', $result));
            $subres = $this->parser->matchRule($result, 'Parameter');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Parameter',  $subres));
                $result['_text'] .= $subres['_text'];
                $this->Functioncall_param($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'param:Parameter'
            if (!$valid) {
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        }
        unset($backup1);
        // end sequence
        // End 'Functioncall'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
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
            $string = new Node\Value\String($this->parser);
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
    public function matchNodeParameter($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Parameter' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start ''('' min '1' max '1'
            if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                $this->parser->pos += 1;
                $result['_text'] .= '(';
                $this->parser->successLiteral('(');
                $valid = true;
            } else {
                $this->parser->failLiteral('(');
                $valid = false;
            }
            // End ''(''
            if (!$valid) {
                break;
            }
            // Start '( param:Expr ( ',' param:Expr)*)?' min '0' max '1'
            // start sequence
            $backup4 = $result;
            $pos4 = $this->parser->pos;
            $line4 = $this->parser->line;
            do {
                // Start 'param:Expr' tag 'param' min '1' max '1'
                $this->parser->addBacktrace(array('Expr', $result));
                $subres = $this->parser->matchRule($result, 'Expr');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Expr',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Parameter_param($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'param:Expr'
                if (!$valid) {
                    break;
                }
                // Start '( ',' param:Expr)*' min '0' max 'null'
                $iteration6 = 0;
                do {
                    // start sequence
                    $backup7 = $result;
                    $pos7 = $this->parser->pos;
                    $line7 = $this->parser->line;
                    do {
                        // Start '','' min '1' max '1'
                        if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                            $this->parser->pos += 1;
                            $result['_text'] .= ',';
                            $this->parser->successLiteral(',');
                            $valid = true;
                        } else {
                            $this->parser->failLiteral(',');
                            $valid = false;
                        }
                        // End '',''
                        if (!$valid) {
                            break;
                        }
                        // Start 'param:Expr' tag 'param' min '1' max '1'
                        $this->parser->addBacktrace(array('Expr', $result));
                        $subres = $this->parser->matchRule($result, 'Expr');
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('Expr',  $subres));
                            $result['_text'] .= $subres['_text'];
                            $this->Parameter_param($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'param:Expr'
                        if (!$valid) {
                            break;
                        }
                        break;
                    } while (true);
                    if (!$valid) {
                        $this->parser->pos = $pos7;
                        $this->parser->line = $line7;
                        $result = $backup7;
                    }
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
                    break;
                }
                break;
            } while (true);
            if (!$valid) {
                $this->parser->pos = $pos4;
                $this->parser->line = $line4;
                $result = $backup4;
            }
            unset($backup4);
            // end sequence
            $valid = true;
            // End '( param:Expr ( ',' param:Expr)*)?'
            if (!$valid) {
                break;
            }
            // Start '')'' min '1' max '1'
            if (')' == substr($this->parser->source, $this->parser->pos, 1)) {
                $this->parser->pos += 1;
                $result['_text'] .= ')';
                $this->parser->successLiteral(')');
                $valid = true;
            } else {
                $this->parser->failLiteral(')');
                $valid = false;
            }
            // End '')''
            if (!$valid) {
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        }
        unset($backup1);
        // end sequence
        // End 'Parameter'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
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
                $result['node'] = new Node\Value\Subexpression($this->parser, $subres['node']);
            }
            </action>
        </token>

     *
    */
    public function matchNodeValue($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        if (isset($this->parser->packCache[$this->parser->pos]['Value'])) {
            $result = $this->parser->packCache[$this->parser->pos]['Value'];
            if ($result) {
                $this->parser->pos = $result['_endpos'];
                $this->parser->line = $result['_endline'];
            }
            return $result;
        }
        // Start 'Value' min '1' max '1'
        // start option
        do {
            // Start '( value:Variable !'(')' min '1' max '1'
            // start sequence
            $backup2 = $result;
            $pos2 = $this->parser->pos;
            $line2 = $this->parser->line;
            do {
                // Start 'value:Variable' tag 'value' min '1' max '1'
                $this->parser->addBacktrace(array('Variable', $result));
                $subres = $this->parser->matchRule($result, 'Variable');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Variable',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Value_value($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'value:Variable'
                if (!$valid) {
                    break;
                }
                // Start '!'('' min '1' max '1' negative lookahead
                $backup4 = $result;
                $pos4 = $this->parser->pos;
                $line4 = $this->parser->line;
                if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= '(';
                    $this->parser->successLiteral('(');
                    $valid = false;
                } else {
                    $this->parser->failLiteral('(');
                    $valid = true;
                }
                $this->parser->pos = $pos4;
                $this->parser->line = $line4;
                $result = $backup4;
                unset($backup4);
                // End '!'(''
                if (!$valid) {
                    break;
                }
                break;
            } while (true);
            if (!$valid) {
                $this->parser->pos = $pos2;
                $this->parser->line = $line2;
                $result = $backup2;
            }
            unset($backup2);
            // end sequence
            // End '( value:Variable !'(')'
            if ($valid) {
                break;
            }
            // Start 'value:AnyLiteral' tag 'value' min '1' max '1'
            $this->parser->addBacktrace(array('AnyLiteral', $result));
            $subres = $this->parser->matchRule($result, 'AnyLiteral');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('AnyLiteral',  $subres));
                $result['_text'] .= $subres['_text'];
                $this->Value_value($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'value:AnyLiteral'
            if ($valid) {
                break;
            }
            // Start '( '(' subexpr:Expr ')')' min '1' max '1'
            // start sequence
            $backup7 = $result;
            $pos7 = $this->parser->pos;
            $line7 = $this->parser->line;
            do {
                // Start ''('' min '1' max '1'
                if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= '(';
                    $this->parser->successLiteral('(');
                    $valid = true;
                } else {
                    $this->parser->failLiteral('(');
                    $valid = false;
                }
                // End ''(''
                if (!$valid) {
                    break;
                }
                // Start 'subexpr:Expr' tag 'subexpr' min '1' max '1'
                $this->parser->addBacktrace(array('Expr', $result));
                $subres = $this->parser->matchRule($result, 'Expr');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Expr',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Value_subexpr($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'subexpr:Expr'
                if (!$valid) {
                    break;
                }
                // Start '')'' min '1' max '1'
                if (')' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= ')';
                    $this->parser->successLiteral(')');
                    $valid = true;
                } else {
                    $this->parser->failLiteral(')');
                    $valid = false;
                }
                // End '')''
                if (!$valid) {
                    break;
                }
                break;
            } while (true);
            if (!$valid) {
                $this->parser->pos = $pos7;
                $this->parser->line = $line7;
                $result = $backup7;
            }
            unset($backup7);
            // end sequence
            // End '( '(' subexpr:Expr ')')'
            if ($valid) {
                break;
            }
            // Start 'value:Functioncall' tag 'value' min '1' max '1'
            $this->parser->addBacktrace(array('Functioncall', $result));
            $subres = $this->parser->matchRule($result, 'Functioncall');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Functioncall',  $subres));
                $result['_text'] .= $subres['_text'];
                $this->Value_value($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'value:Functioncall'
            if ($valid) {
                break;
            }
            // Start 'value:Array' tag 'value' min '1' max '1'
            $this->parser->addBacktrace(array('Array', $result));
            $subres = $this->parser->matchRule($result, 'Array');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Array',  $subres));
                $result['_text'] .= $subres['_text'];
                $this->Value_value($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'value:Array'
            if ($valid) {
                break;
            }
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
        }
        $this->parser->packCache[$pos0]['Value'] = $result;
        return $result;
    }

    public function Value_value (&$result, $subres) {
        $result['node'] = $subres['node'];
    }


    public function Value_subexpr (&$result, $subres) {
        $result['node'] = new Node\Value\Subexpression($this->parser, $subres['node']);
    }


    /**
     *
     * Parser rules and action for node 'Statement'
     *
     *  Rule:
    <token Statement>
            <rule> var:Variable '[]'? '=' value:Expr _? </rule>
        </token>

     *
    */
    public function matchNodeStatement($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Statement' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'var:Variable' tag 'var' min '1' max '1'
            $this->parser->addBacktrace(array('Variable', $result));
            $subres = $this->parser->matchRule($result, 'Variable');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Variable',  $subres));
                $result['_text'] .= $subres['_text'];
                if(!isset($result['var'])) {
                    $result['var'] = $subres;
                } else {
                    if (!is_array($result['var'])) {
                        $result['var'] = array($result['var']);
                    }
                    $result['var'][] = $subres;
                }
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'var:Variable'
            if (!$valid) {
                break;
            }
            // Start ''[]'?' min '0' max '1'
            if ('[]' == substr($this->parser->source, $this->parser->pos, 2)) {
                $this->parser->pos += 2;
                $result['_text'] .= '[]';
                $this->parser->successLiteral('[]');
                $valid = true;
            } else {
                $this->parser->failLiteral('[]');
                $valid = false;
            }
            $valid = true;
            // End ''[]'?'
            if (!$valid) {
                break;
            }
            // Start ''='' min '1' max '1'
            if ('=' == substr($this->parser->source, $this->parser->pos, 1)) {
                $this->parser->pos += 1;
                $result['_text'] .= '=';
                $this->parser->successLiteral('=');
                $valid = true;
            } else {
                $this->parser->failLiteral('=');
                $valid = false;
            }
            // End ''=''
            if (!$valid) {
                break;
            }
            // Start 'value:Expr' tag 'value' min '1' max '1'
            $this->parser->addBacktrace(array('Expr', $result));
            $subres = $this->parser->matchRule($result, 'Expr');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Expr',  $subres));
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
            // End 'value:Expr'
            if (!$valid) {
                break;
            }
            // Start '_?' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                if ($match[0]) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                    $result['_text'] .= ' ';
                }
            }
            $valid = true;
            // End '_?'
            if (!$valid) {
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        }
        unset($backup1);
        // end sequence
        // End 'Statement'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
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
               $string = new Node\Value\String($this->parser);
               $string->setValue($subres['_text'], true);
               $result['name'] = $string;
            }
            </action>
        </node>

     *
    */
    public function matchNodeModifierValue($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        if (isset($this->parser->packCache[$this->parser->pos]['ModifierValue'])) {
            $result = $this->parser->packCache[$this->parser->pos]['ModifierValue'];
            if ($result) {
                $this->parser->pos = $result['_endpos'];
                $this->parser->line = $result['_endline'];
            }
            return $result;
        }
        // Start 'ModifierValue' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'value:Value' tag 'value' min '1' max '1'
            $this->parser->addBacktrace(array('Value', $result));
            $subres = $this->parser->matchRule($result, 'Value');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Value',  $subres));
                $result['_text'] .= $subres['_text'];
                $this->ModifierValue_value($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'value:Value'
            if (!$valid) {
                break;
            }
            // Start 'addmodifier:( '|' name:Id ( ':' param:Value)*)*' tag 'addmodifier' min '0' max 'null'
            $iteration3 = 0;
            do {
                // start sequence
                $backup4 = $result;
                $pos4 = $this->parser->pos;
                $line4 = $this->parser->line;
                do {
                    // Start ''|'' min '1' max '1'
                    if ('|' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= '|';
                        $this->parser->successLiteral('|');
                        $valid = true;
                    } else {
                        $this->parser->failLiteral('|');
                        $valid = false;
                    }
                    // End ''|''
                    if (!$valid) {
                        break;
                    }
                    // Start 'name:Id' tag 'name' min '1' max '1'
                    $this->parser->addBacktrace(array('Id', $result));
                    $subres = $this->parser->matchRule($result, 'Id');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Id',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->ModifierValue_name($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'name:Id'
                    if (!$valid) {
                        break;
                    }
                    // Start '( ':' param:Value)*' min '0' max 'null'
                    $iteration7 = 0;
                    do {
                        // start sequence
                        $backup8 = $result;
                        $pos8 = $this->parser->pos;
                        $line8 = $this->parser->line;
                        do {
                            // Start '':'' min '1' max '1'
                            if (':' == substr($this->parser->source, $this->parser->pos, 1)) {
                                $this->parser->pos += 1;
                                $result['_text'] .= ':';
                                $this->parser->successLiteral(':');
                                $valid = true;
                            } else {
                                $this->parser->failLiteral(':');
                                $valid = false;
                            }
                            // End '':''
                            if (!$valid) {
                                break;
                            }
                            // Start 'param:Value' tag 'param' min '1' max '1'
                            $this->parser->addBacktrace(array('Value', $result));
                            $subres = $this->parser->matchRule($result, 'Value');
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('Value',  $subres));
                                $result['_text'] .= $subres['_text'];
                                $this->ModifierValue_param($result, $subres);
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            // End 'param:Value'
                            if (!$valid) {
                                break;
                            }
                            break;
                        } while (true);
                        if (!$valid) {
                            $this->parser->pos = $pos8;
                            $this->parser->line = $line8;
                            $result = $backup8;
                        }
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
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos4;
                    $this->parser->line = $line4;
                    $result = $backup4;
                }
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
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        }
        unset($backup1);
        // end sequence
        // End 'ModifierValue'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        $this->parser->packCache[$pos0]['ModifierValue'] = $result;
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
        $string = new Node\Value\String($this->parser);
        $string->setValue($subres['_text'], true);
        $result['name'] = $string;
    }


    /**
     *
     * Parser rules and action for node 'Expr'
     *
     *  Rule:
    <token Expr>
            <rule> value:Mathexpr | value:Logexpr _? </rule>
             <action _all>
            {
               $result['node'] = $subres['node'];
            }
            </action>
       </token>

     *
    */
    public function matchNodeExpr($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Expr' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Expr' min '1' max '1'
            // start option
            do {
                // Start 'value:Mathexpr' tag 'value' min '1' max '1'
                $this->parser->addBacktrace(array('Mathexpr', $result));
                $subres = $this->parser->matchRule($result, 'Mathexpr');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Mathexpr',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Expr___ALL($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'value:Mathexpr'
                if ($valid) {
                    break;
                }
                // Start 'value:Logexpr' tag 'value' min '1' max '1'
                $this->parser->addBacktrace(array('Logexpr', $result));
                $subres = $this->parser->matchRule($result, 'Logexpr');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Logexpr',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Expr___ALL($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'value:Logexpr'
                if ($valid) {
                    break;
                }
                break;
            } while (true);
            // end option
            // End 'Expr'
            if (!$valid) {
                break;
            }
            // Start '_?' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                if ($match[0]) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                    $result['_text'] .= ' ';
                }
            }
            $valid = true;
            // End '_?'
            if (!$valid) {
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        }
        unset($backup1);
        // end sequence
        // End 'Expr'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
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
    public function matchNodeMathexpr($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Mathexpr' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Mathexpr' min '1' max '1'
            // start option
            do {
                // Start '( operator:Unimath left:ModifierValue)' min '1' max '1'
                // start sequence
                $backup4 = $result;
                $pos4 = $this->parser->pos;
                $line4 = $this->parser->line;
                do {
                    // Start 'operator:Unimath' tag 'operator' min '1' max '1'
                    $this->parser->addBacktrace(array('Unimath', $result));
                    $subres = $this->parser->matchRule($result, 'Unimath');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Unimath',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->Mathexpr___ALL($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'operator:Unimath'
                    if (!$valid) {
                        break;
                    }
                    // Start 'left:ModifierValue' tag 'left' min '1' max '1'
                    $this->parser->addBacktrace(array('ModifierValue', $result));
                    $subres = $this->parser->matchRule($result, 'ModifierValue');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('ModifierValue',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->Mathexpr___ALL($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'left:ModifierValue'
                    if (!$valid) {
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos4;
                    $this->parser->line = $line4;
                    $result = $backup4;
                }
                unset($backup4);
                // end sequence
                // End '( operator:Unimath left:ModifierValue)'
                if ($valid) {
                    break;
                }
                // Start '( left:ModifierValue)' tag 'left' min '1' max '1'
                $this->parser->addBacktrace(array('ModifierValue', $result));
                $subres = $this->parser->matchRule($result, 'ModifierValue');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('ModifierValue',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Mathexpr___ALL($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End '( left:ModifierValue)'
                if ($valid) {
                    break;
                }
                break;
            } while (true);
            // end option
            // End 'Mathexpr'
            if (!$valid) {
                break;
            }
            // Start '( operator:Unimath | ( operator:Math operator:Unimath?) right:ModifierValue)*' min '0' max 'null'
            $iteration8 = 0;
            do {
                // start sequence
                $backup9 = $result;
                $pos9 = $this->parser->pos;
                $line9 = $this->parser->line;
                do {
                    // Start 'Mathexpr' min '1' max '1'
                    // start option
                    do {
                        // Start 'operator:Unimath' tag 'operator' min '1' max '1'
                        $this->parser->addBacktrace(array('Unimath', $result));
                        $subres = $this->parser->matchRule($result, 'Unimath');
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('Unimath',  $subres));
                            $result['_text'] .= $subres['_text'];
                            $this->Mathexpr___ALL($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'operator:Unimath'
                        if ($valid) {
                            break;
                        }
                        // Start '( operator:Math operator:Unimath?)' min '1' max '1'
                        // start sequence
                        $backup13 = $result;
                        $pos13 = $this->parser->pos;
                        $line13 = $this->parser->line;
                        do {
                            // Start 'operator:Math' tag 'operator' min '1' max '1'
                            $this->parser->addBacktrace(array('Math', $result));
                            $subres = $this->parser->matchRule($result, 'Math');
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('Math',  $subres));
                                $result['_text'] .= $subres['_text'];
                                $this->Mathexpr___ALL($result, $subres);
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            // End 'operator:Math'
                            if (!$valid) {
                                break;
                            }
                            // Start 'operator:Unimath?' tag 'operator' min '0' max '1'
                            $this->parser->addBacktrace(array('Unimath', $result));
                            $subres = $this->parser->matchRule($result, 'Unimath');
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('Unimath',  $subres));
                                $result['_text'] .= $subres['_text'];
                                $this->Mathexpr___ALL($result, $subres);
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            $valid = true;
                            // End 'operator:Unimath?'
                            if (!$valid) {
                                break;
                            }
                            break;
                        } while (true);
                        if (!$valid) {
                            $this->parser->pos = $pos13;
                            $this->parser->line = $line13;
                            $result = $backup13;
                        }
                        unset($backup13);
                        // end sequence
                        // End '( operator:Math operator:Unimath?)'
                        if ($valid) {
                            break;
                        }
                        break;
                    } while (true);
                    // end option
                    // End 'Mathexpr'
                    if (!$valid) {
                        break;
                    }
                    // Start 'right:ModifierValue' tag 'right' min '1' max '1'
                    $this->parser->addBacktrace(array('ModifierValue', $result));
                    $subres = $this->parser->matchRule($result, 'ModifierValue');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('ModifierValue',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->Mathexpr___ALL($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'right:ModifierValue'
                    if (!$valid) {
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos9;
                    $this->parser->line = $line9;
                    $result = $backup9;
                }
                unset($backup9);
                // end sequence
                $iteration8 = $valid ? ($iteration8 + 1) : $iteration8;
                if (!$valid && $iteration8 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) break;
            } while (true);
            // End '( operator:Unimath | ( operator:Math operator:Unimath?) right:ModifierValue)*'
            if (!$valid) {
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        }
        unset($backup1);
        // end sequence
        // End 'Mathexpr'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
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
            <rule> (operator:Unilog left:ModifierValue)|(left:ModifierValue operator:NamedCondition?) ( (operator:Condition|operator:NamedCondition2) (operator:Unilog right:ModifierValue)|(right:ModifierValue operator:NamedCondition?) )* </rule>
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
    public function matchNodeLogexpr($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Logexpr' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Logexpr' min '1' max '1'
            // start option
            do {
                // Start '( operator:Unilog left:ModifierValue)' min '1' max '1'
                // start sequence
                $backup4 = $result;
                $pos4 = $this->parser->pos;
                $line4 = $this->parser->line;
                do {
                    // Start 'operator:Unilog' tag 'operator' min '1' max '1'
                    $this->parser->addBacktrace(array('Unilog', $result));
                    $subres = $this->parser->matchRule($result, 'Unilog');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Unilog',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->Logexpr___ALL($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'operator:Unilog'
                    if (!$valid) {
                        break;
                    }
                    // Start 'left:ModifierValue' tag 'left' min '1' max '1'
                    $this->parser->addBacktrace(array('ModifierValue', $result));
                    $subres = $this->parser->matchRule($result, 'ModifierValue');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('ModifierValue',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->Logexpr___ALL($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'left:ModifierValue'
                    if (!$valid) {
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos4;
                    $this->parser->line = $line4;
                    $result = $backup4;
                }
                unset($backup4);
                // end sequence
                // End '( operator:Unilog left:ModifierValue)'
                if ($valid) {
                    break;
                }
                // Start '( left:ModifierValue operator:NamedCondition?)' min '1' max '1'
                // start sequence
                $backup8 = $result;
                $pos8 = $this->parser->pos;
                $line8 = $this->parser->line;
                do {
                    // Start 'left:ModifierValue' tag 'left' min '1' max '1'
                    $this->parser->addBacktrace(array('ModifierValue', $result));
                    $subres = $this->parser->matchRule($result, 'ModifierValue');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('ModifierValue',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->Logexpr___ALL($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'left:ModifierValue'
                    if (!$valid) {
                        break;
                    }
                    // Start 'operator:NamedCondition?' tag 'operator' min '0' max '1'
                    $this->parser->addBacktrace(array('NamedCondition', $result));
                    $subres = $this->parser->matchRule($result, 'NamedCondition');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('NamedCondition',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->Logexpr___ALL($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    $valid = true;
                    // End 'operator:NamedCondition?'
                    if (!$valid) {
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos8;
                    $this->parser->line = $line8;
                    $result = $backup8;
                }
                unset($backup8);
                // end sequence
                // End '( left:ModifierValue operator:NamedCondition?)'
                if ($valid) {
                    break;
                }
                break;
            } while (true);
            // end option
            // End 'Logexpr'
            if (!$valid) {
                break;
            }
            // Start '( ( operator:Condition | operator:NamedCondition2) ( operator:Unilog right:ModifierValue) | ( right:ModifierValue operator:NamedCondition?))*' min '0' max 'null'
            $iteration11 = 0;
            do {
                // start sequence
                $backup12 = $result;
                $pos12 = $this->parser->pos;
                $line12 = $this->parser->line;
                do {
                    // Start '( operator:Condition | operator:NamedCondition2)' min '1' max '1'
                    // start option
                    do {
                        // Start 'operator:Condition' tag 'operator' min '1' max '1'
                        $this->parser->addBacktrace(array('Condition', $result));
                        $subres = $this->parser->matchRule($result, 'Condition');
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('Condition',  $subres));
                            $result['_text'] .= $subres['_text'];
                            $this->Logexpr___ALL($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'operator:Condition'
                        if ($valid) {
                            break;
                        }
                        // Start 'operator:NamedCondition2' tag 'operator' min '1' max '1'
                        $this->parser->addBacktrace(array('NamedCondition2', $result));
                        $subres = $this->parser->matchRule($result, 'NamedCondition2');
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('NamedCondition2',  $subres));
                            $result['_text'] .= $subres['_text'];
                            $this->Logexpr___ALL($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'operator:NamedCondition2'
                        if ($valid) {
                            break;
                        }
                        break;
                    } while (true);
                    // end option
                    // End '( operator:Condition | operator:NamedCondition2)'
                    if (!$valid) {
                        break;
                    }
                    // Start 'Logexpr' min '1' max '1'
                    // start option
                    do {
                        // Start '( operator:Unilog right:ModifierValue)' min '1' max '1'
                        // start sequence
                        $backup18 = $result;
                        $pos18 = $this->parser->pos;
                        $line18 = $this->parser->line;
                        do {
                            // Start 'operator:Unilog' tag 'operator' min '1' max '1'
                            $this->parser->addBacktrace(array('Unilog', $result));
                            $subres = $this->parser->matchRule($result, 'Unilog');
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('Unilog',  $subres));
                                $result['_text'] .= $subres['_text'];
                                $this->Logexpr___ALL($result, $subres);
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            // End 'operator:Unilog'
                            if (!$valid) {
                                break;
                            }
                            // Start 'right:ModifierValue' tag 'right' min '1' max '1'
                            $this->parser->addBacktrace(array('ModifierValue', $result));
                            $subres = $this->parser->matchRule($result, 'ModifierValue');
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('ModifierValue',  $subres));
                                $result['_text'] .= $subres['_text'];
                                $this->Logexpr___ALL($result, $subres);
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            // End 'right:ModifierValue'
                            if (!$valid) {
                                break;
                            }
                            break;
                        } while (true);
                        if (!$valid) {
                            $this->parser->pos = $pos18;
                            $this->parser->line = $line18;
                            $result = $backup18;
                        }
                        unset($backup18);
                        // end sequence
                        // End '( operator:Unilog right:ModifierValue)'
                        if ($valid) {
                            break;
                        }
                        // Start '( right:ModifierValue operator:NamedCondition?)' min '1' max '1'
                        // start sequence
                        $backup22 = $result;
                        $pos22 = $this->parser->pos;
                        $line22 = $this->parser->line;
                        do {
                            // Start 'right:ModifierValue' tag 'right' min '1' max '1'
                            $this->parser->addBacktrace(array('ModifierValue', $result));
                            $subres = $this->parser->matchRule($result, 'ModifierValue');
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('ModifierValue',  $subres));
                                $result['_text'] .= $subres['_text'];
                                $this->Logexpr___ALL($result, $subres);
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            // End 'right:ModifierValue'
                            if (!$valid) {
                                break;
                            }
                            // Start 'operator:NamedCondition?' tag 'operator' min '0' max '1'
                            $this->parser->addBacktrace(array('NamedCondition', $result));
                            $subres = $this->parser->matchRule($result, 'NamedCondition');
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('NamedCondition',  $subres));
                                $result['_text'] .= $subres['_text'];
                                $this->Logexpr___ALL($result, $subres);
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            $valid = true;
                            // End 'operator:NamedCondition?'
                            if (!$valid) {
                                break;
                            }
                            break;
                        } while (true);
                        if (!$valid) {
                            $this->parser->pos = $pos22;
                            $this->parser->line = $line22;
                            $result = $backup22;
                        }
                        unset($backup22);
                        // end sequence
                        // End '( right:ModifierValue operator:NamedCondition?)'
                        if ($valid) {
                            break;
                        }
                        break;
                    } while (true);
                    // end option
                    // End 'Logexpr'
                    if (!$valid) {
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos12;
                    $this->parser->line = $line12;
                    $result = $backup12;
                }
                unset($backup12);
                // end sequence
                $iteration11 = $valid ? ($iteration11 + 1) : $iteration11;
                if (!$valid && $iteration11 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) break;
            } while (true);
            // End '( ( operator:Condition | operator:NamedCondition2) ( operator:Unilog right:ModifierValue) | ( right:ModifierValue operator:NamedCondition?))*'
            if (!$valid) {
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        }
        unset($backup1);
        // end sequence
        // End 'Logexpr'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
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
            <rule>/(\s*(?<op>(===|!==|==|!=|<>|<=|<|>=|>))\s*)|(\s+(?<op2>(eq|ne|ge|gte|gt|le|lte|lt|instanceof))\s+)/ </rule>
            <action op>
            {
                $result->_type = 'operator';
                $result->_subtype = 'bool';
                switch ($subres['_matchres']['op']) {
                        case '<>':
                            $result->_compile = '!=';
                            break;
                        default:
                            $result->_compile = $subres['_matchres']['op'];
                            break;
                }
                $result->_compile = ' ' . $result->_compile . ' ';
                unset($subres['_matchres']['op']);
            }
            </action>
            <action op2>
            {
                $result->_type = 'operator';
                $result->_subtype = 'bool';
                switch ($subres['_matchres']['op2']) {
                       case 'eq':
                            $result->_compile = '==';
                            break;
                        case 'ne':
                            $result->_compile = '==';
                            break;
                        case 'ge':
                        case 'gte':
                            $result->_compile = '>=';
                            break;
                        case 'gt':
                            $result->_compile = '>';
                            break;
                        case 'le':
                        case 'lte':
                            $result->_compile = '<=';
                            break;
                        case 'lt':
                            $result->_compile = '<';
                            break;
                        case 'lt':
                            $result->_compile = 'instanceof';
                            break;
                        default:
                            $result->_compile = $subres['_matchres']['op2'];
                            break;
                }
                $result->_compile = ' ' . $result->_compile . ' ';
                unset($subres['_matchres']['op2']);
            }
            </action>
        </token>

     *
    */
    public function matchNodeCondition($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/(\s*(?<op>(===|!==|==|!=|<>|<=|<|>=|>))\s*)|(\s+(?<op2>(eq|ne|ge|gte|gt|le|lte|lt|instanceof))\s+)/' min '1' max '1'
        $regexp = "/(\\s*(?<op>(===|!==|==|!=|<>|<=|<|>=|>))\\s*)|(\\s+(?<op2>(eq|ne|ge|gte|gt|le|lte|lt|instanceof))\\s+)/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Condition2'][$pos])) {
            $subres = $this->parser->regexpCache['Condition2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['Condition2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['Condition2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    if (strlen($match[0]) != 0) {
                        $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                        foreach ($match as $n => $v) {
                            if (is_string($n) && !empty($v[0])) {
                                $subres['_matchres'][$n] = $v[0];
                            }
                        }
                    } else {
                        $this->parser->regexpCache['Condition2'][$pos] = false;
                        $subres = false;
                    }
                    $this->parser->regexpCache['Condition2'][$match[1]] = $subres;
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
            if (isset($subres['_matchres']['op'])) {
                $this->Condition_op($result, $subres);
                unset($subres['_matchres']['op']);
            }
            if (isset($subres['_matchres']['op2'])) {
                $this->Condition_op2($result, $subres);
                unset($subres['_matchres']['op2']);
            }
            $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/(\s*(?<op>(===|!==|==|!=|<>|<=|<|>=|>))\s*)|(\s+(?<op2>(eq|ne|ge|gte|gt|le|lte|lt|instanceof))\s+)/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Condition_op (&$result, $subres) {
        $result->_type = 'operator';
        $result->_subtype = 'bool';
        switch ($subres['_matchres']['op']) {
            case '<>':$result->_compile = '!=';
            break;
            default:$result->_compile = $subres['_matchres']['op'];
            break;
        }
        $result->_compile = ' '. $result->_compile . ' ';
        unset($subres['_matchres']['op']);
    }


    public function Condition_op2 (&$result, $subres) {
        $result->_type = 'operator';
        $result->_subtype = 'bool';
        switch ($subres['_matchres']['op2']) {
            case 'eq':$result->_compile = '==';
            break;
            case 'ne':$result->_compile = '==';
            break;
            case 'ge':case 'gte':$result->_compile = '>=';
            break;
            case 'gt':$result->_compile = '>';
            break;
            case 'le':case 'lte':$result->_compile = '<=';
            break;
            case 'lt':$result->_compile = '<';
            break;
            case 'lt':$result->_compile = 'instanceof';
            break;
            default:$result->_compile = $subres['_matchres']['op2'];
            break;
        }
        $result->_compile = ' '. $result->_compile . ' ';
        unset($subres['_matchres']['op2']);
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
    public function matchNodeNamedCondition($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/' min '1' max '1'
        $regexp = "/\\s+is\\s+(not\\s+)?(((odd|even|div)\\s+by)|in)\\s+/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['NamedCondition2'][$pos])) {
            $subres = $this->parser->regexpCache['NamedCondition2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['NamedCondition2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['NamedCondition2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['NamedCondition2'][$match[1]] = $subres;
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
        }
        // End '/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'NamedCondition2'
     *
     *  Rule:
    

        <token Logop>
            <attribute>matchall</attribute>
            <rule>/\s*((\|\||\|&&|&|^)\s*)|((and|or|xor)\s+)/</rule>
        </token>

     *
    */
    public function matchNodeNamedCondition2($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/' min '1' max '1'
        $regexp = "/\\s+is\\s+(not\\s+)?(((odd|even|div)\\s+by)|in)\\s+/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['NamedCondition22'][$pos])) {
            $subres = $this->parser->regexpCache['NamedCondition22'][$pos];
        } else {
            if (empty($this->parser->regexpCache['NamedCondition22']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['NamedCondition22'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['NamedCondition22'][$match[1]] = $subres;
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
        }
        // End '/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'Logop'
     *
     *  Rule:
    <token Logop>
            <attribute>matchall</attribute>
            <rule>/\s*((\|\||\|&&|&|^)\s*)|((and|or|xor)\s+)/</rule>
        </token>

     *
    */
    public function matchNodeLogop($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\s*((\|\||\|&&|&|^)\s*)|((and|or|xor)\s+)/' min '1' max '1'
        $regexp = "/\\s*((\\|\\||\\|&&|&|^)\\s*)|((and|or|xor)\\s+)/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Logop2'][$pos])) {
            $subres = $this->parser->regexpCache['Logop2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['Logop2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['Logop2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['Logop2'][$match[1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['Logop2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['Logop2'][$pos])) {
            $subres = $this->parser->regexpCache['Logop2'][$pos];
        } else {
            $this->parser->regexpCache['Logop2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Logop';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/\s*((\|\||\|&&|&|^)\s*)|((and|or|xor)\s+)/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'Math'
     *
     *  Rule:
    <node Math>
            <attribute>matchall</attribute>
            <rule>/(\s*(\*|\/|%)\s*)|(\s+mod\s+)/</rule>
            <action _finish>
            {
                $result['node'] = new Node\Operator\Math($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

     *
    */
    public function matchNodeMath($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/(\s*(\*|\/|%)\s*)|(\s+mod\s+)/' min '1' max '1'
        $regexp = "/(\\s*(\\*|\\/|%)\\s*)|(\\s+mod\\s+)/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Math2'][$pos])) {
            $subres = $this->parser->regexpCache['Math2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['Math2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['Math2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['Math2'][$match[1]] = $subres;
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
        }
        // End '/(\s*(\*|\/|%)\s*)|(\s+mod\s+)/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Math___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Math___FINISH (&$result) {
        $result['node'] = new Node\Operator\Math($this->parser);
        $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }


    /**
     *
     * Parser rules and action for node 'Unimath'
     *
     *  Rule:
    <node Unimath>
            <attribute>matchall</attribute>
            <rule>/\s*(\+|-)\s* /</rule>
            <action _finish>
            {
                $result['node'] = new Node\Operator\Unimath($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
         </node>

     *
    */
    public function matchNodeUnimath($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\s*(\+|-)\s* /' min '1' max '1'
        $regexp = "/\\s*(\\+|-)\\s* /";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Unimath2'][$pos])) {
            $subres = $this->parser->regexpCache['Unimath2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['Unimath2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['Unimath2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['Unimath2'][$match[1]] = $subres;
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
        }
        // End '/\s*(\+|-)\s* /'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Unimath___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Unimath___FINISH (&$result) {
        $result['node'] = new Node\Operator\Unimath($this->parser);
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
                $result['node'] = new Node\Operator\Unilog($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

     *
    */
    public function matchNodeUnilog($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/((!|~)\s*)|(not\s+)/' min '1' max '1'
        $regexp = "/((!|~)\\s*)|(not\\s+)/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Unilog2'][$pos])) {
            $subres = $this->parser->regexpCache['Unilog2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['Unilog2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['Unilog2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['Unilog2'][$match[1]] = $subres;
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
        }
        // End '/((!|~)\s*)|(not\s+)/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Unilog___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Unilog___FINISH (&$result) {
        $result['node'] = new Node\Operator\Unilog($this->parser);
        $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }




}

