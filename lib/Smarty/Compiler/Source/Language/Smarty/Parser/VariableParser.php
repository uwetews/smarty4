<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Node;
use Smarty\Compiler\Source\Language\Smarty\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\Smarty
 */
class VariableParser
{
   
    /**
     *
     * Parser generated on 2014-06-21 12:41:38
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/Variable.peg.inc' dated 2014-06-20 20:05:17
     *
    */




    public $rules = array(
            "Variable" => array(
                    "_attr" => array(
                            "_nodetype" => "node",
                            "hash" => true
                        ),
                    "_name" => "Variable",
                    "_param" => array(
                            0 => array(
                                    "_param" => "\$",
                                    "_tag" => "isvar",
                                    "_type" => "literal"
                                ),
                            1 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_max" => null,
                                                                    "_param" => array(
                                                                            0 => array(
                                                                                    "_param" => "Id",
                                                                                    "_tag" => "id",
                                                                                    "_type" => "recurse"
                                                                                ),
                                                                            1 => array(
                                                                                    "_param" => array(
                                                                                            0 => array(
                                                                                                    "_param" => "{",
                                                                                                    "_type" => "literal"
                                                                                                ),
                                                                                            1 => array(
                                                                                                    "_param" => "Variable",
                                                                                                    "_tag" => "var",
                                                                                                    "_type" => "recurse"
                                                                                                ),
                                                                                            2 => array(
                                                                                                    "_param" => "}",
                                                                                                    "_type" => "literal"
                                                                                                )
                                                                                        ),
                                                                                    "_type" => "sequence"
                                                                                )
                                                                        ),
                                                                    "_type" => "option"
                                                                ),
                                                            1 => array(
                                                                    "_min" => 0,
                                                                    "_param" => array(
                                                                            0 => array(
                                                                                    "_param" => "@",
                                                                                    "_type" => "literal"
                                                                                ),
                                                                            1 => array(
                                                                                    "_param" => "Id",
                                                                                    "_tag" => "property",
                                                                                    "_type" => "recurse"
                                                                                )
                                                                        ),
                                                                    "_type" => "sequence"
                                                                ),
                                                            2 => array(
                                                                    "_max" => null,
                                                                    "_min" => 0,
                                                                    "_param" => array(
                                                                            0 => array(
                                                                                    "_param" => "Arrayelement",
                                                                                    "_type" => "recurse"
                                                                                ),
                                                                            1 => array(
                                                                                    "_param" => "Object",
                                                                                    "_type" => "recurse"
                                                                                )
                                                                        ),
                                                                    "_type" => "option"
                                                                )
                                                        ),
                                                    "_type" => "sequence"
                                                ),
                                            1 => array(
                                                    "_param" => "Unexpected",
                                                    "_type" => "recurse"
                                                )
                                        ),
                                    "_type" => "option"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_start" => array(
                                    "Variable___START" => true
                                ),
                            "_match" => array(
                                    "isvar" => array(
                                            "Variable_isvar" => true
                                        ),
                                    "id" => array(
                                            "Variable_id" => true
                                        ),
                                    "var" => array(
                                            "Variable_var" => true
                                        ),
                                    "property" => array(
                                            "Variable_property" => true
                                        )
                                ),
                            "_finish" => array(
                                    "Variable___FINISH" => true
                                )
                        )
                ),
            "Arrayelement" => array(
                    "_attr" => array(
                            "_nodetype" => "node"
                        ),
                    "_max" => null,
                    "_name" => "Arrayelement",
                    "_param" => array(
                            0 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => ".",
                                                    "_type" => "literal"
                                                ),
                                            1 => array(
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_param" => "Id",
                                                                    "_tag" => "iv",
                                                                    "_type" => "recurse"
                                                                ),
                                                            1 => array(
                                                                    "_param" => "Value",
                                                                    "_tag" => "value",
                                                                    "_type" => "recurse"
                                                                )
                                                        ),
                                                    "_type" => "option"
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
                                                    "_param" => "Expr",
                                                    "_tag" => "value",
                                                    "_type" => "recurse"
                                                ),
                                            2 => array(
                                                    "_param" => "]",
                                                    "_type" => "literal"
                                                )
                                        ),
                                    "_type" => "sequence"
                                )
                        ),
                    "_type" => "option",
                    "_actions" => array(
                            "_start" => array(
                                    "Arrayelement___START" => true
                                ),
                            "_match" => array(
                                    "value" => array(
                                            "Arrayelement_value" => true
                                        ),
                                    "iv" => array(
                                            "Arrayelement_iv" => true
                                        )
                                )
                        )
                ),
            "Object" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_max" => null,
                    "_name" => "Object",
                    "_param" => array(
                            0 => array(
                                    "_param" => "->",
                                    "_type" => "literal"
                                ),
                            1 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "Id",
                                                    "_silent" => 1,
                                                    "_tag" => "iv",
                                                    "_type" => "recurse"
                                                ),
                                            1 => array(
                                                    "_param" => "Variable",
                                                    "_silent" => 1,
                                                    "_tag" => "var",
                                                    "_type" => "recurse"
                                                )
                                        ),
                                    "_type" => "option"
                                ),
                            2 => array(
                                    "_min" => 0,
                                    "_param" => "Parameter",
                                    "_tag" => "method",
                                    "_type" => "recurse"
                                )
                        ),
                    "_tag" => "addsuffix",
                    "_type" => "sequence",
                    "_actions" => array(
                            "_start" => array(
                                    "Object___START" => true
                                ),
                            "_match" => array(
                                    "iv" => array(
                                            "Object_iv" => true
                                        ),
                                    "var" => array(
                                            "Object_var" => true
                                        ),
                                    "method" => array(
                                            "Object_method" => true
                                        ),
                                    "addsuffix" => array(
                                            "Object_addsuffix" => true
                                        )
                                )
                        )
                )
        );
    public function matchNodeVariable(){
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



    public function matchNodeArrayelement(){
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
            if (!$valid && $iteration2 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeObject(){
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
            if (!$valid && $iteration3 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    /**
     *
     * Parser rules and action for node 'Variable'
     *
     *  Rule:
     <node Variable> <attribute> hash </attribute>  <rule>  isvar:'$' (  (  id:Id | (  '{' var:Variable '}' ) )+ (  '@' property:Id )? (  Arrayelement | Object )* ) | Unexpected </rule>  <action _start> {
                $i = 1;
            } </action>  <action isvar> {
                $result['node'] = new Node($result['_parser'], 'Variable');
            } </action>  <action id> {
                $node = new Node\Value\String($result['_parser']);
                $result['node']->addSubTree($node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']), 'name', true);
            } </action>  <action var> {
                $result['node']->addSubTree($subres['node'], 'name', true);
            } </action>  <action property> {
                $result['node']->addSubTree($subres['_text'], 'property');
            } </action>  <action _finish> {
                    $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            } </action> </node> 
     *
    */

    public function Variable___START (&$result, $previous) {
        $i = 1;
    }


    public function Variable_isvar (&$result, $subres) {
        $result['node'] = new Node($result['_parser'], 'Variable');
    }


    public function Variable_id (&$result, $subres) {
        $node = new Node\Value\String($result['_parser']);
        $result['node']->addSubTree($node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']), 'name', true);
    }


    public function Variable_var (&$result, $subres) {
        $result['node']->addSubTree($subres['node'], 'name', true);
    }


    public function Variable_property (&$result, $subres) {
        $result['node']->addSubTree($subres['_text'], 'property');
    }


    public function Variable___FINISH (&$result) {
        $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }


    /**
     *
     * Parser rules and action for node 'Arrayelement'
     *
     *  Rule:
     <node Arrayelement> <rule>  (  (  '.' (  iv:Id | value:Value ) ) | (  '[' value:Expr ']' ) )+ </rule>  <action _start> {
                $result['node'] = $previous['node'];
            } </action>  <action value> {
                $result['node']->addSubTree(array('type' => 'arrayelement', 'node' => $subres['node']) , 'suffix', true);
            } </action>  <action iv> {
                $node = new Node\Value\String($result['_parser']);
                $result['node']->addSubTree(array('type' => 'arrayelement', 'node' => $node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']) , 'suffix', true));
            } </action> </node> 
     *
    */

    public function Arrayelement___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function Arrayelement_value (&$result, $subres) {
        $result['node']->addSubTree(array('type'=> 'arrayelement', 'node'=> $subres['node']) , 'suffix', true);
    }


    public function Arrayelement_iv (&$result, $subres) {
        $node = new Node\Value\String($result['_parser']);
        $result['node']->addSubTree(array('type'=> 'arrayelement', 'node'=> $node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']) , 'suffix', true));
    }


    /**
     *
     * Parser rules and action for node 'Object'
     *
     *  Rule:
     <token Object> <rule>  (  addsuffix:(  '->' (  .iv:Id | .var:Variable ) method:Parameter? ) )+ </rule>  <action _start> {
                $result['node'] = $previous['node'];
            } </action>  <action iv> {
                $node = new Node\Value\String($result['_parser']);
                $node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
                $result['name'] = $node;
            } </action>  <action var> {
                $result['name'] = $subres['node'];
            } </action>  <action method> {
                $result['method'] = $subres['node'];
            } </action>  <action addsuffix> {
                $result['node']->addSubTree(array('type' => 'object', 'name' => $subres['name'], 'method' => isset($subres['method']) ? $subres['method'] : null) , 'suffix', true);
            } </action> </token> 
     *
    */

    public function Object___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function Object_iv (&$result, $subres) {
        $node = new Node\Value\String($result['_parser']);
        $node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
        $result['name'] = $node;
    }


    public function Object_var (&$result, $subres) {
        $result['name'] = $subres['node'];
    }


    public function Object_method (&$result, $subres) {
        $result['method'] = $subres['node'];
    }


    public function Object_addsuffix (&$result, $subres) {
        $result['node']->addSubTree(array('type'=> 'object', 'name'=> $subres['name'], 'method'=> isset($subres['method']) ? $subres['method'] : null) , 'suffix', true);
    }



}
