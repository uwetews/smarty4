<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Compiler\Source\Shared\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\internalPrintTag
 */
class TagOutputParser
{
   
    /**
     *
     * Parser generated on 2014-06-21 12:41:39
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/TagOutput.peg.inc' dated 2014-06-20 15:29:35
     *
    */




    public $rules = array(
            "TagOutput" => array(
                    "_attr" => array(
                            "_nodetype" => "node"
                        ),
                    "_name" => "TagOutput",
                    "_param" => array(
                            0 => array(
                                    "_param" => "Ldel",
                                    "_type" => "recurse"
                                ),
                            1 => array(
                                    "_param" => true,
                                    "_type" => "whitespace"
                                ),
                            2 => array(
                                    "_param" => "Expr",
                                    "_tag" => "value",
                                    "_type" => "recurse"
                                ),
                            3 => array(
                                    "_param" => "Rdel",
                                    "_type" => "recurse"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_match" => array(
                                    "value" => array(
                                            "TagOutput_value" => true
                                        )
                                )
                        )
                )
        );
    public function matchNodeTagOutput(){
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



    /**
     *
     * Parser rules and action for node 'TagOutput'
     *
     *  Rule:
     <node TagOutput> <rule>  Ldel _? value:Expr Rdel </rule>  <action value> {
                    $result['node'] = new Nodes\TagOutput($result['_parser']);
                    $result['node']->addSubTree($subres['node'], 'value');
                    $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                } </action> </node> 
     *
    */

    public function TagOutput_value (&$result, $subres) {
        $result['node'] = new Nodes\TagOutput($result['_parser']);
        $result['node']->addSubTree($subres['node'], 'value');
        $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
    }



}

