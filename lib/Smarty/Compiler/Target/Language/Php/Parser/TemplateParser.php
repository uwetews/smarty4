<?php
namespace Smarty\Compiler\Target\Language\Php\Parser;

use Smarty\Node;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Template
 */
class TemplateParser
{
   
    /**
     *
     * Parser generated on 2014-06-21 12:41:38
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Target/Language/Php/Parser/Template.peg.inc' dated 2014-06-19 22:57:19
     *
    */




    public $rules = array(
            "Template" => array(
                    "_attr" => array(
                            "_nodetype" => "node"
                        ),
                    "_name" => "Template",
                    "_param" => array(
                            0 => array(
                                    "_min" => 0,
                                    "_param" => "Bom",
                                    "_silent" => 1,
                                    "_type" => "recurse"
                                ),
                            1 => array(
                                    "_min" => 0,
                                    "_param" => "Body",
                                    "_tag" => "nodes",
                                    "_type" => "recurse"
                                ),
                            2 => array(
                                    "_min" => 0,
                                    "_param" => "Unexpected",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_start" => array(
                                    "Template___START" => true
                                ),
                            "_match" => array(
                                    "nodes" => array(
                                            "Template_nodes" => true
                                        )
                                )
                        )
                ),
            "Bom" => array(
                    "_attr" => array(
                            "_nodetype" => "node"
                        ),
                    "_name" => "Bom",
                    "_param" => "/\\xEF\\xBB\\xBF|\\xFE\\xFF|\\xFF\\xFE/",
                    "_type" => "rx"
                )
        );
    public function matchNodeTemplate(){
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



    public function matchNodeBom(){
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



    /**
     *
     * Parser rules and action for node 'Template'
     *
     *  Rule:
     <node Template> <rule>  .Bom? nodes:Body? Unexpected? </rule>  <action _start> {
                    $result['node'] = new Node\Template($result['_parser'], $result);
                } </action>  <action nodes> {
                    $result['node']->templateBodyNode = $subres['node'];
                    $result['node']->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
                    $result['node']->templateBodyNode->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
                } </action> </node> 
     *
    */

    public function Template___START (&$result, $previous) {
        $result['node'] = new Node\Template($result['_parser'], $result);
    }


    public function Template_nodes (&$result, $subres) {
        $result['node']->templateBodyNode = $subres['node'];
        $result['node']->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
        $result['node']->templateBodyNode->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
    }


    /**
     *
     * Parser rules and action for node 'Bom'
     *
     *  Rule:
     <node Bom> <rule>  /\xEF\xBB\xBF|\xFE\xFF|\xFF\xFE/ </rule> </node> 
     *
    */



}

