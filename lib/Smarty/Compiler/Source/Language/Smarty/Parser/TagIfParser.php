<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Compiler\Source\Shared\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\ifTag
 */
class TagIfParser
{
   
    /**
     *
     * Parser generated on 2014-06-21 18:39:24
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/TagIf.peg.inc' dated 2014-06-20 15:01:45
     *
    */




    public $rules = array(
            "TagIf" => array(
                    "_attr" => array(
                            "_nodetype" => "node",
                            "attributes" => array(
                                    "subtags" => array(
                                            "elseif" => true,
                                            "else" => true
                                        )
                                ),
                            "options" => "nocache"
                        ),
                    "_name" => "TagIf",
                    "_param" => array(
                            0 => array(
                                    "_param" => "Ldel",
                                    "_type" => "recurse"
                                ),
                            1 => array(
                                    "_param" => "if",
                                    "_type" => "literal"
                                ),
                            2 => array(
                                    "_param" => false,
                                    "_type" => "whitespace"
                                ),
                            3 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "Statement",
                                                    "_tag" => "condition",
                                                    "_type" => "recurse"
                                                ),
                                            1 => array(
                                                    "_param" => "Logexpr",
                                                    "_tag" => "condition",
                                                    "_type" => "recurse"
                                                )
                                        ),
                                    "_type" => "option"
                                ),
                            4 => array(
                                    "_param" => "Smarty_Tag_Params",
                                    "_type" => "recurse"
                                ),
                            5 => array(
                                    "_param" => "Rdel",
                                    "_type" => "recurse"
                                ),
                            6 => array(
                                    "_min" => 0,
                                    "_param" => "Body",
                                    "_tag" => "body",
                                    "_type" => "recurse"
                                ),
                            7 => array(
                                    "_max" => null,
                                    "_min" => 0,
                                    "_param" => array(
                                            0 => array(
                                                    "_nla" => true,
                                                    "_param" => "LdelSlash",
                                                    "_type" => "recurse"
                                                ),
                                            1 => array(
                                                    "_param" => "elseifTagif",
                                                    "_type" => "recurse"
                                                )
                                        ),
                                    "_type" => "sequence"
                                ),
                            8 => array(
                                    "_min" => 0,
                                    "_param" => array(
                                            0 => array(
                                                    "_nla" => true,
                                                    "_param" => "LdelSlash",
                                                    "_type" => "recurse"
                                                ),
                                            1 => array(
                                                    "_param" => "elseTagif",
                                                    "_type" => "recurse"
                                                )
                                        ),
                                    "_type" => "sequence"
                                ),
                            9 => array(
                                    "_param" => "Smarty_Tag_Block_Close",
                                    "_tag" => "close",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_start" => array(
                                    "TagIf___START" => true
                                ),
                            "_match" => array(
                                    "condition" => array(
                                            "TagIf_condition" => true
                                        ),
                                    "body" => array(
                                            "TagIf_body" => true
                                        )
                                ),
                            "_finish" => array(
                                    "TagIf___FINISH" => true
                                )
                        )
                ),
            "elseifTagif" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "elseifTagif",
                    "_param" => array(
                            0 => array(
                                    "_param" => "Ldel",
                                    "_type" => "recurse"
                                ),
                            1 => array(
                                    "_param" => "elseif",
                                    "_type" => "literal"
                                ),
                            2 => array(
                                    "_param" => false,
                                    "_type" => "whitespace"
                                ),
                            3 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "Statement",
                                                    "_tag" => "condition",
                                                    "_type" => "recurse"
                                                ),
                                            1 => array(
                                                    "_param" => "Logexpr",
                                                    "_tag" => "condition",
                                                    "_type" => "recurse"
                                                )
                                        ),
                                    "_type" => "option"
                                ),
                            4 => array(
                                    "_param" => "Rdel",
                                    "_type" => "recurse"
                                ),
                            5 => array(
                                    "_min" => 0,
                                    "_param" => "Body",
                                    "_tag" => "body",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_start" => array(
                                    "elseifTagif___START" => true
                                ),
                            "_match" => array(
                                    "condition" => array(
                                            "elseifTagif_condition" => true
                                        ),
                                    "body" => array(
                                            "elseifTagif_body" => true
                                        )
                                ),
                            "_finish" => array(
                                    "elseifTagif___FINISH" => true
                                )
                        )
                ),
            "elseTagif" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "elseTagif",
                    "_param" => array(
                            0 => array(
                                    "_param" => "Ldel",
                                    "_type" => "recurse"
                                ),
                            1 => array(
                                    "_param" => "else",
                                    "_type" => "literal"
                                ),
                            2 => array(
                                    "_param" => "Rdel",
                                    "_type" => "recurse"
                                ),
                            3 => array(
                                    "_min" => 0,
                                    "_param" => "Body",
                                    "_tag" => "body",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_start" => array(
                                    "elseTagif___START" => true
                                ),
                            "_match" => array(
                                    "body" => array(
                                            "elseTagif_body" => true
                                        )
                                ),
                            "_finish" => array(
                                    "elseTagif___FINISH" => true
                                )
                        )
                )
        );
    public function matchNodeTagIf(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $valid = $this->parser->matchToken($result, $params);
    }



    public function matchNodeelseifTagif(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $valid = $this->parser->matchToken($result, $params);
    }



    public function matchNodeelseTagif(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $valid = $this->parser->matchToken($result, $params);
    }



    /**
     *
     * Parser rules and action for node 'TagIf'
     *
     *  Rule:
     <node TagIf> <attribute> attributes =  ( subtags =  ( elseif , else )), options =  nocache</attribute>  <rule>  Ldel 'if' _ condition:Statement | condition:Logexpr Smarty_Tag_Params Rdel body:Body? (  !LdelSlash elseifTagif )* (  !LdelSlash elseTagif )? close:Smarty_Tag_Block_Close </rule>  <action _start> {
                    $i =1;
                } </action>  <action condition> {
                    $result['condition'] = $subres['node'];
                } </action>  <action body> {
                    $result['body'] = $subres['node'];
                } </action>  <action _finish> {
                    $result['node']->addSubTree(array('condition' => $result['condition'], 'body' => isset($result['body']) ? $result['body'] : false),'if');
                } </action> </node> 
     *
    */

    public function TagIf___START (&$result, $previous) {
        $i =1;
    }


    public function TagIf_condition (&$result, $subres) {
        $result['condition'] = $subres['node'];
    }


    public function TagIf_body (&$result, $subres) {
        $result['body'] = $subres['node'];
    }


    public function TagIf___FINISH (&$result) {
        $result['node']->addSubTree(array('condition'=> $result['condition'], 'body'=> isset($result['body']) ? $result['body'] : false),'if');
    }


    /**
     *
     * Parser rules and action for node 'elseifTagif'
     *
     *  Rule:
     <token elseifTagif> <rule>  Ldel 'elseif' _ condition:Statement | condition:Logexpr Rdel body:Body? </rule>  <action _start> {
                    $result['node'] = $previous['node'];
                 } </action>  <action condition> {
                    $result['condition'] = $subres['node'];
                } </action>  <action body> {
                    $result['body'] = $subres['node'];
                } </action>  <action _finish> {
                    $result['node']->addSubTree(array('condition' => $result['condition'], 'body' => isset($result['body']) ? $result['body'] : false),'elseif', true);
                } </action> </token> 
     *
    */

    public function elseifTagif___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function elseifTagif_condition (&$result, $subres) {
        $result['condition'] = $subres['node'];
    }


    public function elseifTagif_body (&$result, $subres) {
        $result['body'] = $subres['node'];
    }


    public function elseifTagif___FINISH (&$result) {
        $result['node']->addSubTree(array('condition'=> $result['condition'], 'body'=> isset($result['body']) ? $result['body'] : false),'elseif', true);
    }


    /**
     *
     * Parser rules and action for node 'elseTagif'
     *
     *  Rule:
     <token elseTagif> <rule>  Ldel 'else' Rdel body:Body? </rule>  <action _start> {
                    $result['node'] = $previous['node'];
                } </action>  <action body> {
                    $result['body'] = $subres['node'];
                } </action>  <action _finish> {
                    $result['node']->addSubTree(array('body' => isset($result['body']) ? $result['body'] : false),'else');
                } </action> </token> 
     *
    */

    public function elseTagif___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function elseTagif_body (&$result, $subres) {
        $result['body'] = $subres['node'];
    }


    public function elseTagif___FINISH (&$result) {
        $result['node']->addSubTree(array('body'=> isset($result['body']) ? $result['body'] : false),'else');
    }



}

