<?php
namespace Smarty\Compiler\Source\Shared\Parser;

use Smarty\Node;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Core
 */
class ExpressionParser
{
   
    /**
     *
     * Parser generated on 2014-06-21 13:09:34
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Shared/Parser/Expression.peg.inc' dated 2014-06-21 03:36:25
     *
    */




    public $rules = array(
            "Number" => array(
                    "_attr" => array(
                            "_nodetype" => "node",
                            "hash" => true
                        ),
                    "_name" => "Number",
                    "_param" => "/-?[0-9]+(?:\\.[0-9]+)?/",
                    "_type" => "rx",
                    "_actions" => array(
                            "_finish" => array(
                                    "Number___FINISH" => true
                                )
                        )
                ),
            "String" => array(
                    "_attr" => array(
                            "_nodetype" => "node",
                            "hash" => true
                        ),
                    "_name" => "String",
                    "_param" => "/'[^'\\\\]*(?:\\\\.[^'\\\\]*)*'/",
                    "_type" => "rx",
                    "_actions" => array(
                            "_finish" => array(
                                    "String___FINISH" => true
                                )
                        )
                ),
            "Boolean" => array(
                    "_attr" => array(
                            "_nodetype" => "node",
                            "hash" => true
                        ),
                    "_name" => "Boolean",
                    "_param" => "/(true|false)(?![^a-zA-Z0-9])/",
                    "_type" => "rx",
                    "_actions" => array(
                            "_finish" => array(
                                    "Boolean___FINISH" => true
                                )
                        )
                ),
            "Null" => array(
                    "_attr" => array(
                            "_nodetype" => "node",
                            "hash" => true
                        ),
                    "_name" => "Null",
                    "_param" => "/null(?![^a-zA-Z0-9])/",
                    "_type" => "rx",
                    "_actions" => array(
                            "_finish" => array(
                                    "Null___FINISH" => true
                                )
                        )
                ),
            "AnyLiteral" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "hash" => true
                        ),
                    "_name" => "AnyLiteral",
                    "_param" => "/(?<number>(-?[0-9]+(?:\\.[0-9]+)?))|(?<string>('[^'\\\\]*(?:\\\\.[^'\\\\]*)*'))|(((?<null>null)|(?<bool>(true|false)))(?![_a-zA-Z0-9]))/",
                    "_type" => "rx",
                    "_actions" => array(
                            "_start" => array(
                                    "AnyLiteral___START" => true
                                ),
                            "_finish" => array(
                                    "AnyLiteral___FINISH" => true
                                )
                        )
                ),
            "Array" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "Array",
                    "_param" => array(
                            0 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "array",
                                                    "_type" => "literal"
                                                ),
                                            1 => array(
                                                    "_param" => true,
                                                    "_type" => "whitespace"
                                                ),
                                            2 => array(
                                                    "_param" => "(",
                                                    "_type" => "literal"
                                                ),
                                            3 => array(
                                                    "_param" => "Arrayitem",
                                                    "_tag" => "item",
                                                    "_type" => "recurse"
                                                ),
                                            4 => array(
                                                    "_max" => null,
                                                    "_min" => 0,
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_param" => ",",
                                                                    "_type" => "literal"
                                                                ),
                                                            1 => array(
                                                                    "_param" => "Arrayitem",
                                                                    "_tag" => "item",
                                                                    "_type" => "recurse"
                                                                )
                                                        ),
                                                    "_type" => "sequence"
                                                ),
                                            5 => array(
                                                    "_min" => 0,
                                                    "_param" => ",",
                                                    "_type" => "literal"
                                                ),
                                            6 => array(
                                                    "_param" => ")",
                                                    "_type" => "literal"
                                                )
                                        ),
                                    "_type" => "sequence"
                                ),
                            1 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "[",
                                                    "_type" => "literal"
                                                ),
                                            1 => array(
                                                    "_param" => "Arrayitem",
                                                    "_tag" => "item",
                                                    "_type" => "recurse"
                                                ),
                                            2 => array(
                                                    "_max" => null,
                                                    "_min" => 0,
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_param" => ",",
                                                                    "_type" => "literal"
                                                                ),
                                                            1 => array(
                                                                    "_param" => "Arrayitem",
                                                                    "_tag" => "item",
                                                                    "_type" => "recurse"
                                                                )
                                                        ),
                                                    "_type" => "sequence"
                                                ),
                                            3 => array(
                                                    "_min" => 0,
                                                    "_param" => ",",
                                                    "_type" => "literal"
                                                ),
                                            4 => array(
                                                    "_param" => "]",
                                                    "_type" => "literal"
                                                )
                                        ),
                                    "_type" => "sequence"
                                )
                        ),
                    "_type" => "option"
                ),
            "Arrayitem" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_min" => 0,
                    "_name" => "Arrayitem",
                    "_param" => array(
                            0 => array(
                                    "_param" => "Value",
                                    "_tag" => "index",
                                    "_type" => "recurse"
                                ),
                            1 => array(
                                    "_param" => true,
                                    "_type" => "whitespace"
                                ),
                            2 => array(
                                    "_param" => "=>",
                                    "_type" => "literal"
                                ),
                            3 => array(
                                    "_param" => true,
                                    "_type" => "whitespace"
                                ),
                            4 => array(
                                    "_param" => "Value",
                                    "_tag" => "value",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "sequence"
                ),
            "Functioncall" => array(
                    "_attr" => array(
                            "_nodetype" => "node"
                        ),
                    "_name" => "Functioncall",
                    "_param" => array(
                            0 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "Id",
                                                    "_tag" => "name",
                                                    "_type" => "recurse"
                                                ),
                                            1 => array(
                                                    "_param" => "Variable",
                                                    "_tag" => "namevar",
                                                    "_type" => "recurse"
                                                )
                                        ),
                                    "_type" => "option"
                                ),
                            1 => array(
                                    "_param" => "Parameter",
                                    "_tag" => "param",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_match" => array(
                                    "name" => array(
                                            "Functioncall_name" => true
                                        ),
                                    "namevar" => array(
                                            "Functioncall_namevar" => true
                                        ),
                                    "param" => array(
                                            "Functioncall_param" => true
                                        )
                                )
                        )
                ),
            "Parameter" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "Parameter",
                    "_param" => array(
                            0 => array(
                                    "_param" => "(",
                                    "_type" => "literal"
                                ),
                            1 => array(
                                    "_min" => 0,
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "Expr",
                                                    "_tag" => "param",
                                                    "_type" => "recurse"
                                                ),
                                            1 => array(
                                                    "_max" => null,
                                                    "_min" => 0,
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_param" => ",",
                                                                    "_type" => "literal"
                                                                ),
                                                            1 => array(
                                                                    "_param" => "Expr",
                                                                    "_tag" => "param",
                                                                    "_type" => "recurse"
                                                                )
                                                        ),
                                                    "_type" => "sequence"
                                                )
                                        ),
                                    "_type" => "sequence"
                                ),
                            2 => array(
                                    "_param" => ")",
                                    "_type" => "literal"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_match" => array(
                                    "param" => array(
                                            "Parameter_param" => true
                                        )
                                )
                        )
                ),
            "Value" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "hash" => true
                        ),
                    "_name" => "Value",
                    "_param" => array(
                            0 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "Variable",
                                                    "_tag" => "value",
                                                    "_type" => "recurse"
                                                ),
                                            1 => array(
                                                    "_nla" => true,
                                                    "_param" => "(",
                                                    "_type" => "literal"
                                                )
                                        ),
                                    "_type" => "sequence"
                                ),
                            1 => array(
                                    "_param" => "AnyLiteral",
                                    "_tag" => "value",
                                    "_type" => "recurse"
                                ),
                            2 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "(",
                                                    "_type" => "literal"
                                                ),
                                            1 => array(
                                                    "_param" => "Expr",
                                                    "_tag" => "subexpr",
                                                    "_type" => "recurse"
                                                ),
                                            2 => array(
                                                    "_param" => ")",
                                                    "_type" => "literal"
                                                )
                                        ),
                                    "_type" => "sequence"
                                ),
                            3 => array(
                                    "_param" => "Functioncall",
                                    "_tag" => "value",
                                    "_type" => "recurse"
                                ),
                            4 => array(
                                    "_param" => "Array",
                                    "_tag" => "value",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "option",
                    "_actions" => array(
                            "_match" => array(
                                    "value" => array(
                                            "Value_value" => true
                                        ),
                                    "subexpr" => array(
                                            "Value_subexpr" => true
                                        )
                                )
                        )
                ),
            "Statement" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "Statement",
                    "_param" => array(
                            0 => array(
                                    "_param" => "Variable",
                                    "_tag" => "var",
                                    "_type" => "recurse"
                                ),
                            1 => array(
                                    "_param" => "=",
                                    "_type" => "literal"
                                ),
                            2 => array(
                                    "_param" => "Expr",
                                    "_tag" => "value",
                                    "_type" => "recurse"
                                ),
                            3 => array(
                                    "_param" => true,
                                    "_type" => "whitespace"
                                )
                        ),
                    "_type" => "sequence"
                ),
            "ModifierValue" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "hash" => true
                        ),
                    "_name" => "ModifierValue",
                    "_param" => array(
                            0 => array(
                                    "_param" => "Value",
                                    "_silent" => 1,
                                    "_tag" => "value",
                                    "_type" => "recurse"
                                ),
                            1 => array(
                                    "_max" => null,
                                    "_min" => 0,
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "|",
                                                    "_type" => "literal"
                                                ),
                                            1 => array(
                                                    "_param" => "Id",
                                                    "_tag" => "name",
                                                    "_type" => "recurse"
                                                ),
                                            2 => array(
                                                    "_max" => null,
                                                    "_min" => 0,
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_param" => ":",
                                                                    "_type" => "literal"
                                                                ),
                                                            1 => array(
                                                                    "_param" => "Value",
                                                                    "_tag" => "param",
                                                                    "_type" => "recurse"
                                                                )
                                                        ),
                                                    "_type" => "sequence"
                                                )
                                        ),
                                    "_silent" => 1,
                                    "_tag" => "addmodifier",
                                    "_type" => "sequence"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_match" => array(
                                    "value" => array(
                                            "ModifierValue_value" => true
                                        ),
                                    "addmodifier" => array(
                                            "ModifierValue_addmodifier" => true
                                        ),
                                    "param" => array(
                                            "ModifierValue_param" => true
                                        ),
                                    "name" => array(
                                            "ModifierValue_name" => true
                                        )
                                )
                        )
                ),
            "Expr" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "Expr",
                    "_param" => array(
                            0 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "Mathexpr",
                                                    "_tag" => "value",
                                                    "_type" => "recurse"
                                                ),
                                            1 => array(
                                                    "_param" => "Logexpr",
                                                    "_tag" => "value",
                                                    "_type" => "recurse"
                                                )
                                        ),
                                    "_type" => "option"
                                ),
                            1 => array(
                                    "_param" => true,
                                    "_type" => "whitespace"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_all" => array(
                                    "Expr___ALL" => true
                                )
                        )
                ),
            "Mathexpr" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "Mathexpr",
                    "_param" => array(
                            0 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_param" => "Unimath",
                                                                    "_tag" => "operator",
                                                                    "_type" => "recurse"
                                                                ),
                                                            1 => array(
                                                                    "_param" => "ModifierValue",
                                                                    "_tag" => "left",
                                                                    "_type" => "recurse"
                                                                )
                                                        ),
                                                    "_type" => "sequence"
                                                ),
                                            1 => array(
                                                    "_param" => "ModifierValue",
                                                    "_tag" => "left",
                                                    "_type" => "recurse"
                                                )
                                        ),
                                    "_type" => "option"
                                ),
                            1 => array(
                                    "_max" => null,
                                    "_min" => 0,
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_param" => "Unimath",
                                                                    "_tag" => "operator",
                                                                    "_type" => "recurse"
                                                                ),
                                                            1 => array(
                                                                    "_param" => array(
                                                                            0 => array(
                                                                                    "_param" => "Math",
                                                                                    "_tag" => "operator",
                                                                                    "_type" => "recurse"
                                                                                ),
                                                                            1 => array(
                                                                                    "_min" => 0,
                                                                                    "_param" => "Unimath",
                                                                                    "_tag" => "operator",
                                                                                    "_type" => "recurse"
                                                                                )
                                                                        ),
                                                                    "_type" => "sequence"
                                                                )
                                                        ),
                                                    "_type" => "option"
                                                ),
                                            1 => array(
                                                    "_param" => "ModifierValue",
                                                    "_tag" => "right",
                                                    "_type" => "recurse"
                                                )
                                        ),
                                    "_type" => "sequence"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_all" => array(
                                    "Mathexpr___ALL" => true
                                )
                        )
                ),
            "Logexpr" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "Logexpr",
                    "_param" => array(
                            0 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_param" => "Unilog",
                                                                    "_tag" => "operator",
                                                                    "_type" => "recurse"
                                                                ),
                                                            1 => array(
                                                                    "_param" => "ModifierValue",
                                                                    "_tag" => "left",
                                                                    "_type" => "recurse"
                                                                )
                                                        ),
                                                    "_type" => "sequence"
                                                ),
                                            1 => array(
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_param" => "ModifierValue",
                                                                    "_tag" => "left",
                                                                    "_type" => "recurse"
                                                                ),
                                                            1 => array(
                                                                    "_min" => 0,
                                                                    "_param" => "NamedCondition",
                                                                    "_tag" => "operator",
                                                                    "_type" => "recurse"
                                                                )
                                                        ),
                                                    "_type" => "sequence"
                                                )
                                        ),
                                    "_type" => "option"
                                ),
                            1 => array(
                                    "_max" => null,
                                    "_min" => 0,
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_param" => "Condition",
                                                                    "_tag" => "operator",
                                                                    "_type" => "recurse"
                                                                ),
                                                            1 => array(
                                                                    "_param" => "NamedCondition2",
                                                                    "_tag" => "operator",
                                                                    "_type" => "recurse"
                                                                )
                                                        ),
                                                    "_type" => "option"
                                                ),
                                            1 => array(
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_param" => array(
                                                                            0 => array(
                                                                                    "_param" => "Unilog",
                                                                                    "_tag" => "operator",
                                                                                    "_type" => "recurse"
                                                                                ),
                                                                            1 => array(
                                                                                    "_param" => "ModifierValue",
                                                                                    "_tag" => "right",
                                                                                    "_type" => "recurse"
                                                                                )
                                                                        ),
                                                                    "_type" => "sequence"
                                                                ),
                                                            1 => array(
                                                                    "_param" => array(
                                                                            0 => array(
                                                                                    "_param" => "ModifierValue",
                                                                                    "_tag" => "right",
                                                                                    "_type" => "recurse"
                                                                                ),
                                                                            1 => array(
                                                                                    "_min" => 0,
                                                                                    "_param" => "NamedCondition",
                                                                                    "_tag" => "operator",
                                                                                    "_type" => "recurse"
                                                                                )
                                                                        ),
                                                                    "_type" => "sequence"
                                                                )
                                                        ),
                                                    "_type" => "option"
                                                )
                                        ),
                                    "_type" => "sequence"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_all" => array(
                                    "Logexpr___ALL" => true
                                )
                        )
                ),
            "Condition" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "Condition",
                    "_param" => "/(\\s*(?<op>(===|!==|==|!=|<>|<=|<|>=|>))\\s*)|(\\s+(?<op2>(eq|ne|ge|gte|gt|le|lte|lt|instanceof))\\s+)/",
                    "_type" => "rx",
                    "_actions" => array(
                            "_match" => array(
                                    "op" => array(
                                            "Condition_op" => true
                                        ),
                                    "op2" => array(
                                            "Condition_op2" => true
                                        )
                                )
                        )
                ),
            "NamedCondition" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "NamedCondition",
                    "_param" => "/\\s+is\\s+(not\\s+)?(((odd|even|div)\\s+by)|in)\\s+/",
                    "_type" => "rx"
                ),
            "NamedCondition2" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "NamedCondition2",
                    "_param" => "/\\s+is\\s+(not\\s+)?(((odd|even|div)\\s+by)|in)\\s+/",
                    "_type" => "rx"
                ),
            "Logop" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "Logop",
                    "_param" => "/\\s*((\\|\\||\\|&&|&|^)\\s*)|((and|or|xor)\\s+)/",
                    "_type" => "rx"
                ),
            "Math" => array(
                    "_attr" => array(
                            "_nodetype" => "node",
                            "matchall" => true
                        ),
                    "_name" => "Math",
                    "_param" => "/(\\s*(\\*|\\/|%)\\s*)|(\\s+mod\\s+)/",
                    "_type" => "rx",
                    "_actions" => array(
                            "_finish" => array(
                                    "Math___FINISH" => true
                                )
                        )
                ),
            "Unimath" => array(
                    "_attr" => array(
                            "_nodetype" => "node",
                            "matchall" => true
                        ),
                    "_name" => "Unimath",
                    "_param" => "/\\s*(\\+|-)\\s* /",
                    "_type" => "rx",
                    "_actions" => array(
                            "_finish" => array(
                                    "Unimath___FINISH" => true
                                )
                        )
                ),
            "Unilog" => array(
                    "_attr" => array(
                            "_nodetype" => "node",
                            "matchall" => true
                        ),
                    "_name" => "Unilog",
                    "_param" => "/((!|~)\\s*)|(not\\s+)/",
                    "_type" => "rx",
                    "_actions" => array(
                            "_finish" => array(
                                    "Unilog___FINISH" => true
                                )
                        )
                )
        );
    public function matchNodeNumber(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration1 = 0;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration1 = $valid ? $iteration1++ : $iteration1;
            if ($valid && $iteration1 == 1) break;
            if (!$valid && $iteration1 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeString(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration2 = 0;
        $pos2 = $this->parser->pos;
        $line2 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration2 = $valid ? $iteration2++ : $iteration2;
            if ($valid && $iteration2 == 1) break;
            if (!$valid && $iteration2 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeBoolean(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration3 = 0;
        $pos3 = $this->parser->pos;
        $line3 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration3 = $valid ? $iteration3++ : $iteration3;
            if ($valid && $iteration3 == 1) break;
            if (!$valid && $iteration3 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeNull(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration4 = 0;
        $pos4 = $this->parser->pos;
        $line4 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration4 = $valid ? $iteration4++ : $iteration4;
            if ($valid && $iteration4 == 1) break;
            if (!$valid && $iteration4 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeAnyLiteral(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration5 = 0;
        $pos5 = $this->parser->pos;
        $line5 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration5 = $valid ? $iteration5++ : $iteration5;
            if ($valid && $iteration5 == 1) break;
            if (!$valid && $iteration5 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeArray(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration6 = 0;
        $pos6 = $this->parser->pos;
        $line6 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration6 = $valid ? $iteration6++ : $iteration6;
            if ($valid && $iteration6 == 1) break;
            if (!$valid && $iteration6 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeArrayitem(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration7 = 0;
        $pos7 = $this->parser->pos;
        $line7 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration7 = $valid ? $iteration7++ : $iteration7;
            if ($valid && $iteration7 == 1) break;
            if (!$valid && $iteration7 >= 0) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeFunctioncall(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration8 = 0;
        $pos8 = $this->parser->pos;
        $line8 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration8 = $valid ? $iteration8++ : $iteration8;
            if ($valid && $iteration8 == 1) break;
            if (!$valid && $iteration8 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeParameter(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration9 = 0;
        $pos9 = $this->parser->pos;
        $line9 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration9 = $valid ? $iteration9++ : $iteration9;
            if ($valid && $iteration9 == 1) break;
            if (!$valid && $iteration9 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeValue(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration10 = 0;
        $pos10 = $this->parser->pos;
        $line10 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration10 = $valid ? $iteration10++ : $iteration10;
            if ($valid && $iteration10 == 1) break;
            if (!$valid && $iteration10 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeStatement(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration11 = 0;
        $pos11 = $this->parser->pos;
        $line11 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration11 = $valid ? $iteration11++ : $iteration11;
            if ($valid && $iteration11 == 1) break;
            if (!$valid && $iteration11 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeModifierValue(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration12 = 0;
        $pos12 = $this->parser->pos;
        $line12 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration12 = $valid ? $iteration12++ : $iteration12;
            if ($valid && $iteration12 == 1) break;
            if (!$valid && $iteration12 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeExpr(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration13 = 0;
        $pos13 = $this->parser->pos;
        $line13 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration13 = $valid ? $iteration13++ : $iteration13;
            if ($valid && $iteration13 == 1) break;
            if (!$valid && $iteration13 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeMathexpr(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration14 = 0;
        $pos14 = $this->parser->pos;
        $line14 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration14 = $valid ? $iteration14++ : $iteration14;
            if ($valid && $iteration14 == 1) break;
            if (!$valid && $iteration14 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeLogexpr(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration15 = 0;
        $pos15 = $this->parser->pos;
        $line15 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration15 = $valid ? $iteration15++ : $iteration15;
            if ($valid && $iteration15 == 1) break;
            if (!$valid && $iteration15 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeCondition(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration16 = 0;
        $pos16 = $this->parser->pos;
        $line16 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration16 = $valid ? $iteration16++ : $iteration16;
            if ($valid && $iteration16 == 1) break;
            if (!$valid && $iteration16 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeNamedCondition(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration17 = 0;
        $pos17 = $this->parser->pos;
        $line17 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration17 = $valid ? $iteration17++ : $iteration17;
            if ($valid && $iteration17 == 1) break;
            if (!$valid && $iteration17 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeNamedCondition2(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration18 = 0;
        $pos18 = $this->parser->pos;
        $line18 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration18 = $valid ? $iteration18++ : $iteration18;
            if ($valid && $iteration18 == 1) break;
            if (!$valid && $iteration18 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeLogop(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration19 = 0;
        $pos19 = $this->parser->pos;
        $line19 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration19 = $valid ? $iteration19++ : $iteration19;
            if ($valid && $iteration19 == 1) break;
            if (!$valid && $iteration19 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeMath(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration20 = 0;
        $pos20 = $this->parser->pos;
        $line20 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration20 = $valid ? $iteration20++ : $iteration20;
            if ($valid && $iteration20 == 1) break;
            if (!$valid && $iteration20 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeUnimath(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration21 = 0;
        $pos21 = $this->parser->pos;
        $line21 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration21 = $valid ? $iteration21++ : $iteration21;
            if ($valid && $iteration21 == 1) break;
            if (!$valid && $iteration21 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeUnilog(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $iteration22 = 0;
        $pos22 = $this->parser->pos;
        $line22 = $this->parser->line;
        do {
            $valid = $this->parser->matchToken($result, $params);
            $iteration22 = $valid ? $iteration22++ : $iteration22;
            if ($valid && $iteration22 == 1) break;
            if (!$valid && $iteration22 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    /**
     *
     * Parser rules and action for node 'Number'
     *
     *  Rule:
     <node Number> <attribute> hash </attribute>  <rule>  /-?[0-9]+(?:\.[0-9]+)?/ </rule>  <action _finish> {
                $result['node'] = new Node\Value\Number($result['_parser']);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            } </action> </node> 
     *
    */

    public function Number___FINISH (&$result) {
        $result['node'] = new Node\Value\Number($result['_parser']);
        $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }


    /**
     *
     * Parser rules and action for node 'String'
     *
     *  Rule:
     <node String> <attribute> hash </attribute>  <rule>  /'[^'\\]*(?:\\.[^'\\]*)*'/ </rule>  <action _finish> {
                $result['node'] = new Node\Value\String($result['_parser']);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            } </action> </node> 
     *
    */

    public function String___FINISH (&$result) {
        $result['node'] = new Node\Value\String($result['_parser']);
        $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }


    /**
     *
     * Parser rules and action for node 'Boolean'
     *
     *  Rule:
     <node Boolean> <attribute> hash </attribute>  <rule>  /(true|false)(?![^a-zA-Z0-9])/ </rule>  <action _finish> {
                $result['node'] = new Node\Value\Boolean($result['_parser']);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            } </action> </node> 
     *
    */

    public function Boolean___FINISH (&$result) {
        $result['node'] = new Node\Value\Boolean($result['_parser']);
        $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }


    /**
     *
     * Parser rules and action for node 'Null'
     *
     *  Rule:
     <node Null> <attribute> hash </attribute>  <rule>  /null(?![^a-zA-Z0-9])/ </rule>  <action _finish> {
                $result['node'] = new Node\Value\Null($result['_parser']);
                $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            } </action> </node> 
     *
    */

    public function Null___FINISH (&$result) {
        $result['node'] = new Node\Value\Null($result['_parser']);
        $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }


    /**
     *
     * Parser rules and action for node 'AnyLiteral'
     *
     *  Rule:
     <token AnyLiteral> <attribute> hash </attribute>  <rule>  /(?<number>(-?[0-9]+(?:\.[0-9]+)?))|(?<string>('[^'\\]*(?:\\.[^'\\]*)*'))|(((?<null>null)|(?<bool>(true|false)))(?![_a-zA-Z0-9]))/ </rule>  <action _start> {
                $i = 1;
            } </action>  <action _finish> {
                if (isset($result['_matchres']['number'])) {
                    $result['node'] = new Node\Value\Number($result['_parser']);
                } elseif (isset($result['_matchres']['string'])) {
                    $result['node'] = new Node\Value\String($result['_parser']);
                } elseif (isset($result['_matchres']['bool'])) {
                    $result['node'] = new Node\Value\Boolean($result['_parser']);
                } else {
                    $result['node'] = new Node\Value\Null($result['_parser']);
                }
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            } </action> </token> 
     *
    */

    public function AnyLiteral___START (&$result, $previous) {
        $i = 1;
    }


    public function AnyLiteral___FINISH (&$result) {
        if (isset($result['_matchres']['number'])) {
            $result['node'] = new Node\Value\Number($result['_parser']);
        }
        elseif (isset($result['_matchres']['string'])) {
            $result['node'] = new Node\Value\String($result['_parser']);
        }
        elseif (isset($result['_matchres']['bool'])) {
            $result['node'] = new Node\Value\Boolean($result['_parser']);
        }
        else {
            $result['node'] = new Node\Value\Null($result['_parser']);
        }
        $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }


    /**
     *
     * Parser rules and action for node 'Array'
     *
     *  Rule:
     <token Array> <rule>  (  'array' _? '(' item:Arrayitem (  ',' item:Arrayitem )* ','? ')' ) | (  '[' item:Arrayitem (  ',' item:Arrayitem )* ','? ']' ) </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'Arrayitem'
     *
     *  Rule:
     <token  Arrayitem> <rule>  (  index:Value _? '=>' _? )? value:Value </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'Functioncall'
     *
     *  Rule:
     <node Functioncall> <rule>  (  name:Id | namevar:Variable ) param:Parameter </rule>  <action name> {
                $result['name'] = $subres['_text'];
            } </action>  <action namevar> {
                $result['namevar'] = $subres['node'];
            } </action>  <action param> {
                $result['node'] = new Node($result['_parser'], 'Functioncall');
                if (isset($result['name'])) {
                    $string = new Node\Value\String($result['_parser']);
                    $string->setValue($result['name'], true);
                    $result['node']->addSubTree($string, 'name');
                } else {
                    $result['node']->addSubTree($result['namevar'], 'name');
                }
                $result['node']->addSubTree(isset($subres['funcpar']) ? $subres['funcpar'] : false, 'param');
            } </action> </node> 
     *
    */

    public function Functioncall_name (&$result, $subres) {
        $result['name'] = $subres['_text'];
    }


    public function Functioncall_namevar (&$result, $subres) {
        $result['namevar'] = $subres['node'];
    }


    public function Functioncall_param (&$result, $subres) {
        $result['node'] = new Node($result['_parser'], 'Functioncall');
        if (isset($result['name'])) {
            $string = new Node\Value\String($result['_parser']);
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
     <token Parameter> <rule>  '(' (  param:Expr (  ',' param:Expr )* )? ')' </rule>  <action param> {
                $result['funcpar'][] = $subres['node'];
            } </action> </token> 
     *
    */

    public function Parameter_param (&$result, $subres) {
        $result['funcpar'][] = $subres['node'];
    }


    /**
     *
     * Parser rules and action for node 'Value'
     *
     *  Rule:
     <token Value> <attribute> hash </attribute>  <rule>  (  value:Variable !'(' ) | value:AnyLiteral | (  '(' subexpr:Expr ')' ) | value:Functioncall | value:Array </rule>  <action value> {
                $result['node'] = $subres['node'];
            } </action>  <action subexpr> {
                $result['node'] = new Node\Value\Subexpression($result['_parser'], $subres['node']);
            } </action> </token> 
     *
    */

    public function Value_value (&$result, $subres) {
        $result['node'] = $subres['node'];
    }


    public function Value_subexpr (&$result, $subres) {
        $result['node'] = new Node\Value\Subexpression($result['_parser'], $subres['node']);
    }


    /**
     *
     * Parser rules and action for node 'Statement'
     *
     *  Rule:
     <token Statement> <rule>  var:Variable '=' value:Expr _? </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'ModifierValue'
     *
     *  Rule:
     <token ModifierValue> <attribute> hash </attribute>  <rule>  .value:Value .addmodifier:(  '|' name:Id (  ':' param:Value )* )* </rule>  <action value> {
               $result['node'] = $subres['node'];
            } </action>  <action addmodifier> {
                if (isset($subres['name'])) {
                        $value = $result['node'];
                        $result['node'] = new Node($result['_parser'], 'Modifier');
                        $result['node']->addSubTree($value, 'value');
                        $result['node']->addSubTree($subres['name'], 'name');
                        $result['node']->addSubTree(isset($subres['param']) ? $subres['param'] : false, 'param');
                }
            } </action>  <action param> {
               $result['param'][] = $subres['node'];
            } </action>  <action name> {
               $string = new Node\Value\String($result['_parser']);
               $string->setValue($subres['_text'], true);
               $result['name'] = $string;
            } </action> </node> 
     *
    */

    public function ModifierValue_value (&$result, $subres) {
        $result['node'] = $subres['node'];
    }


    public function ModifierValue_addmodifier (&$result, $subres) {
        if (isset($subres['name'])) {
            $value = $result['node'];
            $result['node'] = new Node($result['_parser'], 'Modifier');
            $result['node']->addSubTree($value, 'value');
            $result['node']->addSubTree($subres['name'], 'name');
            $result['node']->addSubTree(isset($subres['param']) ? $subres['param'] : false, 'param');
        }
    }


    public function ModifierValue_param (&$result, $subres) {
        $result['param'][] = $subres['node'];
    }


    public function ModifierValue_name (&$result, $subres) {
        $string = new Node\Value\String($result['_parser']);
        $string->setValue($subres['_text'], true);
        $result['name'] = $string;
    }


    /**
     *
     * Parser rules and action for node 'Expr'
     *
     *  Rule:
     <token Expr> <rule>  value:Mathexpr | value:Logexpr _? </rule>  <action _all> {
               $result['node'] = $subres['node'];
            } </action> </token> 
     *
    */

    public function Expr___ALL (&$result, $subres) {
        $result['node'] = $subres['node'];
    }


    /**
     *
     * Parser rules and action for node 'Mathexpr'
     *
     *  Rule:
     <token Mathexpr> <rule>  (  operator:Unimath left:ModifierValue ) | (  left:ModifierValue ) (  operator:Unimath | (  operator:Math operator:Unimath? ) right:ModifierValue )* </rule>  <action _all> {
                if (!isset($result['node'])) {
                    $result['node'] = array();
                }
                $result['node'][] = $subres['node'];
            } </action> </token> 
     *
    */

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
     <token Logexpr> <rule>  (  operator:Unilog left:ModifierValue ) | (  left:ModifierValue operator:NamedCondition? ) (  (  operator:Condition | operator:NamedCondition2 ) (  operator:Unilog right:ModifierValue ) | (  right:ModifierValue operator:NamedCondition? ) )* </rule>  <action _all> {
                if (!isset($result['node'])) {
                    $result['node'] = array();
                }
                $result['node'][] = $subres['node'];
            } </action> </token> 
     *
    */

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
     <token Condition> <attribute> matchall </attribute>  <rule>  /(\s*(?<op>(===|!==|==|!=|<>|<=|<|>=|>))\s*)|(\s+(?<op2>(eq|ne|ge|gte|gt|le|lte|lt|instanceof))\s+)/ </rule>  <action op> {
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
            } </action>  <action op2> {
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
            } </action> </token> 
     *
    */

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
     <token NamedCondition> <attribute> matchall </attribute>  <rule>  /\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/ </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'NamedCondition2'
     *
     *  Rule:
     <token NamedCondition2> <attribute> matchall </attribute>  <rule>  /\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/ </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'Logop'
     *
     *  Rule:
     <token Logop> <attribute> matchall </attribute>  <rule>  /\s*((\|\||\|&&|&|^)\s*)|((and|or|xor)\s+)/ </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'Math'
     *
     *  Rule:
     <node Math> <attribute> matchall </attribute>  <rule>  /(\s*(\*|\/|%)\s*)|(\s+mod\s+)/ </rule>  <action _finish> {
                $result['node'] = new Node\Operator\Math($result['_parser']);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            } </action> </node> 
     *
    */

    public function Math___FINISH (&$result) {
        $result['node'] = new Node\Operator\Math($result['_parser']);
        $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }


    /**
     *
     * Parser rules and action for node 'Unimath'
     *
     *  Rule:
     <node Unimath> <attribute> matchall </attribute>  <rule>  /\s*(\+|-)\s* / </rule>  <action _finish> {
                $result['node'] = new Node\Operator\Unimath($result['_parser']);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            } </action> </node> 
     *
    */

    public function Unimath___FINISH (&$result) {
        $result['node'] = new Node\Operator\Unimath($result['_parser']);
        $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }


    /**
     *
     * Parser rules and action for node 'Unilog'
     *
     *  Rule:
     <node Unilog> <attribute> matchall </attribute>  <rule>  /((!|~)\s*)|(not\s+)/ </rule>  <action _finish> {
                $result['node'] = new Node\Operator\Unilog($result['_parser']);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            } </action> </node> 
     *
    */

    public function Unilog___FINISH (&$result) {
        $result['node'] = new Node\Operator\Unilog($result['_parser']);
        $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }



}

