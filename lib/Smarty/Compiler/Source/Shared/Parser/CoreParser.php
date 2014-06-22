<?php
namespace Smarty\Compiler\Source\Shared\Parser;

use Smarty\Node;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Core
 */
class CoreParser
{
   
    /**
     *
     * Parser generated on 2014-06-21 12:41:38
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Shared/Parser/Core.peg.inc' dated 2014-06-10 22:49:44
     *
    */




    public $rules = array(
            "Id" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "Id",
                    "_param" => "/[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]* /",
                    "_type" => "rx"
                ),
            "Attr" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "Attr",
                    "_param" => "/[\\S]+/",
                    "_type" => "rx"
                ),
            "OpenP" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "OpenP",
                    "_param" => "/\\s*\\(\\s* /",
                    "_type" => "rx"
                ),
            "OpenB" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "OpenB",
                    "_param" => "/\\s*\\[\\s* /",
                    "_type" => "rx"
                ),
            "OpenC" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "OpenC",
                    "_param" => "/\\{\\s* /",
                    "_type" => "rx"
                ),
            "CloseP" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "CloseP",
                    "_param" => "/\\s*\\)\\s* /",
                    "_type" => "rx"
                ),
            "CloseB" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "CloseB",
                    "_param" => "/\\s*\\}/",
                    "_type" => "rx"
                ),
            "CloseC" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "CloseC",
                    "_param" => "/\\s*\\}/",
                    "_type" => "rx"
                ),
            "Dollar" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "Dollar",
                    "_param" => "/\\\$/",
                    "_type" => "rx"
                ),
            "Hatch" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "Hatch",
                    "_param" => "/#/",
                    "_type" => "rx"
                ),
            "Comma" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "Comma",
                    "_param" => "/\\s*,\\s* /",
                    "_type" => "rx"
                ),
            "Ptr" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "Ptr",
                    "_param" => "/->/",
                    "_type" => "rx"
                ),
            "Unexpected" => array(
                    "_attr" => array(
                            "_nodetype" => "token"
                        ),
                    "_name" => "Unexpected",
                    "_param" => "/[\\s\\S]{1,30}/",
                    "_type" => "rx",
                    "_actions" => array(
                            "_finish" => array(
                                    "Unexpected___FINISH" => true
                                )
                        )
                )
        );
    public function matchNodeId(){
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



    public function matchNodeAttr(){
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



    public function matchNodeOpenP(){
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



    public function matchNodeOpenB(){
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



    public function matchNodeOpenC(){
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



    public function matchNodeCloseP(){
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



    public function matchNodeCloseB(){
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
            if (!$valid && $iteration7 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    public function matchNodeCloseC(){
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



    public function matchNodeDollar(){
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



    public function matchNodeHatch(){
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



    public function matchNodeComma(){
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



    public function matchNodePtr(){
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



    public function matchNodeUnexpected(){
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



    /**
     *
     * Parser rules and action for node 'Id'
     *
     *  Rule:
     <token Id> <rule>  /[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* / </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'Attr'
     *
     *  Rule:
     <token Attr> <rule>  /[\S]+/ </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'OpenP'
     *
     *  Rule:
     <token OpenP> <attribute> matchall </attribute>  <rule>  /\s*\(\s* / </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'OpenB'
     *
     *  Rule:
     <token OpenB> <attribute> matchall </attribute>  <rule>  /\s*\[\s* / </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'OpenC'
     *
     *  Rule:
     <token OpenC> <attribute> matchall </attribute>  <rule>  /\{\s* / </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'CloseP'
     *
     *  Rule:
     <token CloseP> <attribute> matchall </attribute>  <rule>  /\s*\)\s* / </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'CloseB'
     *
     *  Rule:
     <token CloseB> <attribute> matchall </attribute>  <rule>  /\s*\}/ </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'CloseC'
     *
     *  Rule:
     <token CloseC> <attribute> matchall </attribute>  <rule>  /\s*\}/ </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'Dollar'
     *
     *  Rule:
     <token Dollar> <attribute> matchall </attribute>  <rule>  /\$/ </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'Hatch'
     *
     *  Rule:
     <token Hatch> <attribute> matchall </attribute>  <rule>  /#/ </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'Comma'
     *
     *  Rule:
     <token Comma> <attribute> matchall </attribute>  <rule>  /\s*,\s* / </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'Ptr'
     *
     *  Rule:
     <token Ptr> <attribute> matchall </attribute>  <rule>  /->/ </rule> </token> 
     *
    */

    /**
     *
     * Parser rules and action for node 'Unexpected'
     *
     *  Rule:
     <token Unexpected> <rule>  /[\s\S]{1,30}/ </rule>  <action _finish> {
                    $this->parserContext->compiler->error("unexpected '{$result['text']}'", $this->parserContext->line, $this);
                    } </action> </token> 
     *
    */

    public function Unexpected___FINISH (&$result) {
        $this->parserContext->compiler->error("unexpected '{$result['text']}'", $this->parserContext->line, $this);
    }



}

