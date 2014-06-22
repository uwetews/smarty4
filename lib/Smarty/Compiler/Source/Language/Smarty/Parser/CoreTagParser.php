<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\Smarty
 */
class CoreTagParser
{
   
    /**
     *
     * Parser generated on 2014-06-21 12:41:39
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/CoreTag.peg.inc' dated 2014-06-19 02:58:46
     *
    */




    public $rules = array(
            "CoreTag" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "CoreTag",
                    "_param" => array(
                            0 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "Ldel",
                                                    "_silent" => 1,
                                                    "_type" => "recurse"
                                                ),
                                            1 => array(
                                                    "_param" => "Id",
                                                    "_silent" => 1,
                                                    "_tag" => "tagname",
                                                    "_type" => "recurse"
                                                ),
                                            2 => array(
                                                    "_nla" => true,
                                                    "_param" => "(",
                                                    "_type" => "literal"
                                                ),
                                            3 => array(
                                                    "_param" => "tagDispatcher",
                                                    "_tag" => "tag",
                                                    "_type" => "expression"
                                                )
                                        ),
                                    "_type" => "sequence"
                                ),
                            1 => array(
                                    "_param" => "TagOutput",
                                    "_tag" => "tag",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "option",
                    "_actions" => array(
                            "_start" => array(
                                    "CoreTag___START" => true
                                ),
                            "_expression" => array(
                                    "CoreTag_EXP_tagDispatcher" => true
                                ),
                            "_match" => array(
                                    "tag" => array(
                                            "CoreTag_tag" => true
                                        )
                                )
                        )
                ),
            "Smarty_Tag_Attributes" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_max" => null,
                    "_min" => 0,
                    "_name" => "Smarty_Tag_Attributes",
                    "_param" => array(
                            0 => array(
                                    "_param" => false,
                                    "_type" => "whitespace"
                                ),
                            1 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => "Id",
                                                    "_tag" => "name",
                                                    "_type" => "recurse"
                                                ),
                                            1 => array(
                                                    "_param" => true,
                                                    "_type" => "whitespace"
                                                ),
                                            2 => array(
                                                    "_param" => "=",
                                                    "_type" => "literal"
                                                ),
                                            3 => array(
                                                    "_param" => true,
                                                    "_type" => "whitespace"
                                                )
                                        ),
                                    "_type" => "sequence"
                                ),
                            2 => array(
                                    "_param" => "Value",
                                    "_tag" => "value",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_start" => array(
                                    "Smarty_Tag_Attributes___START" => true
                                ),
                            "_match" => array(
                                    "name" => array(
                                            "Smarty_Tag_Attributes_name" => true
                                        ),
                                    "value" => array(
                                            "Smarty_Tag_Attributes_value" => true
                                        )
                                ),
                            "_finish" => array(
                                    "Smarty_Tag_Attributes___FINISH" => true
                                )
                        )
                ),
            "Smarty_Tag_Params" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_max" => null,
                    "_min" => 0,
                    "_name" => "Smarty_Tag_Params",
                    "_param" => array(
                            0 => array(
                                    "_param" => false,
                                    "_type" => "whitespace"
                                ),
                            1 => array(
                                    "_param" => "Id",
                                    "_tag" => "option",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_start" => array(
                                    "Smarty_Tag_Params___START" => true
                                ),
                            "_match" => array(
                                    "option" => array(
                                            "Smarty_Tag_Params_option" => true
                                        )
                                )
                        )
                ),
            "Smarty_Tag_Block_Close" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "Smarty_Tag_Block_Close",
                    "_param" => array(
                            0 => array(
                                    "_param" => "LdelSlash",
                                    "_type" => "recurse"
                                ),
                            1 => array(
                                    "_param" => "Id",
                                    "_tag" => "tag",
                                    "_type" => "recurse"
                                ),
                            2 => array(
                                    "_param" => "Rdel",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "sequence"
                ),
            "Smarty_Tag_Default" => array(
                    "_attr" => array(
                            "_nodetype" => "node"
                        ),
                    "_name" => "Smarty_Tag_Default",
                    "_param" => array(
                            0 => array(
                                    "_param" => "Ldel",
                                    "_type" => "recurse"
                                ),
                            1 => array(
                                    "_param" => "Id",
                                    "_type" => "recurse"
                                ),
                            2 => array(
                                    "_param" => "Smarty_Tag_Attributes",
                                    "_type" => "recurse"
                                ),
                            3 => array(
                                    "_param" => "Smarty_Tag_Params",
                                    "_type" => "recurse"
                                ),
                            4 => array(
                                    "_param" => "Rdel",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_start" => array(
                                    "Smarty_Tag_Default___START" => true
                                ),
                            "_finish" => array(
                                    "Smarty_Tag_Default___FINISH" => true
                                )
                        )
                ),
            "Smarty_Tag_Block_Default" => array(
                    "_attr" => array(
                            "_nodetype" => "node"
                        ),
                    "_name" => "Smarty_Tag_Block_Default",
                    "_param" => array(
                            0 => array(
                                    "_param" => "Smarty_Tag_Default",
                                    "_type" => "recurse"
                                ),
                            1 => array(
                                    "_param" => "Body",
                                    "_tag" => "body",
                                    "_type" => "recurse"
                                ),
                            2 => array(
                                    "_param" => "Smarty_Tag_Block_Close",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "sequence"
                )
        );
    public function matchNodeCoreTag(){
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



    public function matchNodeSmarty_Tag_Attributes(){
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
            if (!$valid && $iteration2 >= 0) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeSmarty_Tag_Params(){
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
            if (!$valid && $iteration3 >= 0) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeSmarty_Tag_Block_Close(){
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



    public function matchNodeSmarty_Tag_Default(){
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



    public function matchNodeSmarty_Tag_Block_Default(){
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



    /**
     *
     * Parser rules and action for node 'CoreTag'
     *
     *  Rule:
     <token CoreTag> <rule>  (  .Ldel .tagname:Id !'(' tag:$tagDispatcher ) | tag:TagOutput </rule>  <action _start> {
                $i = 1;
            } </action>  <action _expression(tagDispatcher)> {
                    $result['_text'] = '';
                    return $result['_parser']->tagDispatcher($result);
                } </action>  <action tag> {
                    $result['node'] = $subres['node'];
                } </action> </token> 
     *
    */

    public function CoreTag___START (&$result, $previous) {
        $i = 1;
    }


    public function CoreTag_EXP_tagDispatcher (&$result) {
        $result['_text'] = '';
        return $result['_parser']->tagDispatcher($result);
    }


    public function CoreTag_tag (&$result, $subres) {
        $result['node'] = $subres['node'];
    }


    /**
     *
     * Parser rules and action for node 'Smarty_Tag_Attributes'
     *
     *  Rule:
     <token Smarty_Tag_Attributes> <rule>  (  _ (  name:Id _? '=' _? ) value:Value )* </rule>  <action _start> {
                $result['node'] = $previous['node'];
            } </action>  <action name> {
                $result['name'] = strtolower($subres['_text']);
            } </action>  <action value> {
                $result['node']->setTagAttribute(array(isset($result['name']) ? $result['name'] : null, $subres['node']));
            } </action>  <action _finish> {
                $i = 1;
            } </action> </token> 
     *
    */

    public function Smarty_Tag_Attributes___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function Smarty_Tag_Attributes_name (&$result, $subres) {
        $result['name'] = strtolower($subres['_text']);
    }


    public function Smarty_Tag_Attributes_value (&$result, $subres) {
        $result['node']->setTagAttribute(array(isset($result['name']) ? $result['name'] : null, $subres['node']));
    }


    public function Smarty_Tag_Attributes___FINISH (&$result) {
        $i = 1;
    }


    /**
     *
     * Parser rules and action for node 'Smarty_Tag_Params'
     *
     *  Rule:
     <token Smarty_Tag_Params> <rule>  (  _ option:Id )* </rule>  <action _start> {
                $result['node'] = $previous['node'];
            } </action>  <action option> {
                $result['node']->setTagOption(strtolower($subres['_text']));
            } </action> </token> 
     *
    */

    public function Smarty_Tag_Params___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function Smarty_Tag_Params_option (&$result, $subres) {
        $result['node']->setTagOption(strtolower($subres['_text']));
    }


    /**
     *
     * Parser rules and action for node 'Smarty_Tag_Block_Close'
     *
     *  Rule:
     <token Smarty_Tag_Block_Close> <rule>  LdelSlash tag:Id Rdel </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'Smarty_Tag_Default'
     *
     *  Rule:
     <node Smarty_Tag_Default> <rule>  Ldel Id Smarty_Tag_Attributes Smarty_Tag_Params Rdel </rule>  <action _start> {
                $result['node'] = $previous['node'];
            } </action>  <action _finish> {
                $result['tagAttributes'] = array();
                if (isset($result['attrib'])) {
                    $result['tagAttributes'] = $result['attrib']['attrib'];
                    unset($result['attrib']);
                }
                $result['tagOptions'] = array();
                if (isset($result['options'])) {
                    $result['tagOptions'] = $result['options']['Options'];
                    unset($result['options']);
                }

            } </action> </node> 
     *
    */

    public function Smarty_Tag_Default___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function Smarty_Tag_Default___FINISH (&$result) {
        $result['tagAttributes'] = array();
        if (isset($result['attrib'])) {
            $result['tagAttributes'] = $result['attrib']['attrib'];
            unset($result['attrib']);
        }
        $result['tagOptions'] = array();
        if (isset($result['options'])) {
            $result['tagOptions'] = $result['options']['Options'];
            unset($result['options']);
        }
    }


    /**
     *
     * Parser rules and action for node 'Smarty_Tag_Block_Default'
     *
     *  Rule:
     <node Smarty_Tag_Block_Default> <rule>  Smarty_Tag_Default body:Body Smarty_Tag_Block_Close </rule> </node> 
     *
    */


}
