<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Nodes;
use Smarty\Compiler\Source\Shared\Nodes\InternalText;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\Smarty
 */
class CoreParser
{
   
    /**
     *
     * Parser generated on 2014-06-21 17:29:16
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/Core.peg.inc' dated 2014-06-19 23:25:13
     *
    */




    public $rules = array(
            "Ldel" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "Ldel",
                    "_param" => "/{getLdel}/",
                    "_type" => "rx",
                    "_actions" => array(
                            "_init" => array(
                                    "Ldel_INIT_getLdel" => true
                                )
                        )
                ),
            "LdelSlash" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "LdelSlash",
                    "_param" => "/{getLdel}\\//",
                    "_type" => "rx",
                    "_actions" => array(
                            "_init" => array(
                                    "LdelSlash_INIT_getLdel" => true
                                )
                        )
                ),
            "Rdel" => array(
                    "_attr" => array(
                            "_nodetype" => "token",
                            "matchall" => true
                        ),
                    "_name" => "Rdel",
                    "_param" => "/\\s*{getRdel}/",
                    "_type" => "rx",
                    "_actions" => array(
                            "_init" => array(
                                    "Rdel_INIT_getRdel" => true
                                )
                        )
                ),
            "Text" => array(
                    "_attr" => array(
                            "_nodetype" => "node"
                        ),
                    "_name" => "Text",
                    "_param" => "/({getLdel}\\s*literal\\s*{getRdel}.*?{getLdel}\\/\\s*literal\\s*{getRdel})?(([\\s\\S])*?(?=({getLdel})))|[\\S\\s]+/",
                    "_type" => "rx",
                    "_actions" => array(
                            "_finish" => array(
                                    "Text___FINISH" => true
                                ),
                            "_init" => array(
                                    "Text_INIT_getLdel" => true,
                                    "Text_INIT_getRdel" => true
                                )
                        )
                )
        );
    public function matchNodeLdel(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $valid = $this->parser->matchToken($result, $params);
        $iteration1 = $valid ? $iteration1++ : $iteration1;
    }



    public function matchNodeLdelSlash(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $valid = $this->parser->matchToken($result, $params);
        $iteration2 = $valid ? $iteration2++ : $iteration2;
    }



    public function matchNodeRdel(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $valid = $this->parser->matchToken($result, $params);
        $iteration3 = $valid ? $iteration3++ : $iteration3;
    }



    public function matchNodeText(){
        $result = $this->parser->resultDefault;
        $result['_parser'] = $this->parser;
        $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $valid = $this->parser->matchToken($result, $params);
        $iteration4 = $valid ? $iteration4++ : $iteration4;
    }



    /**
     *
     * Parser rules and action for node 'Ldel'
     *
     *  Rule:
     <token Ldel> <attribute> matchall </attribute>  <rule>  /{getLdel}/ </rule>  <action _init(getLdel)> {
                    return $rule->parser->Ldel;
                } </action> </token> 
     *
    */

    public function Ldel_INIT_getLdel (&$rule) {
        return $rule->parser->Ldel;
    }


    /**
     *
     * Parser rules and action for node 'LdelSlash'
     *
     *  Rule:
     <token LdelSlash> <attribute> matchall </attribute>  <rule>  /{getLdel}\// </rule>  <action _init(getLdel)> {
                    return $rule->parser->Ldel;
                } </action> </token> 
     *
    */

    public function LdelSlash_INIT_getLdel (&$rule) {
        return $rule->parser->Ldel;
    }


    /**
     *
     * Parser rules and action for node 'Rdel'
     *
     *  Rule:
     <token Rdel> <attribute> matchall </attribute>  <rule>  /\s*{getRdel}/ </rule>  <action _init(getRdel)> {
                    return $rule->parser->Rdel;
                } </action> </token> 
     *
    */

    public function Rdel_INIT_getRdel (&$rule) {
        return $rule->parser->Rdel;
    }


    /**
     *
     * Parser rules and action for node 'Text'
     *
     *  Rule:
     <node Text> <rule>  /({getLdel}\s*literal\s*{getRdel}.*?{getLdel}\/\s*literal\s*{getRdel})?(([\s\S])*?(?=({getLdel})))|[\S\s]+/ </rule>  <action _finish> {
                if ($result['_text'] == '') {
                    $result = false;
                    return;
                }
                $result['node'] = new InternalText($result['_parser']);
                $result['node']->addText($result['_text'])->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                $result['_text'] = '';
                $result['_silent'] = 1;
            } </action>  <action _init(getLdel)> {
                    return $rule->parser->Ldel;
                } </action>  <action _init(getRdel)> {
                    return $rule->parser->Rdel;
                } </action> </node> 
     *
    */

    public function Text___FINISH (&$result) {
        if ($result['_text'] == '') {
            $result = false;
            return;
        }
        $result['node'] = new InternalText($result['_parser']);
        $result['node']->addText($result['_text'])->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
        $result['_text'] = '';
        $result['_silent'] = 1;
    }


    public function Text_INIT_getLdel (&$rule) {
        return $rule->parser->Ldel;
    }


    public function Text_INIT_getRdel (&$rule) {
        return $rule->parser->Rdel;
    }



}
