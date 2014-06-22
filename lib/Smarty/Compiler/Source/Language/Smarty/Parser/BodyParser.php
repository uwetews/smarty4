<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Compiler\Source\Language\Smarty\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\Smarty
 */
class BodyParser
{
   
    /**
     *
     * Parser generated on 2014-06-21 12:41:39
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/Body.peg.inc' dated 2014-06-20 01:14:09
     *
    */




    public $rules = array(
            "Body" => array(
                    "_attr" => array(
                            "_nodetype" => "node"
                        ),
                    "_max" => null,
                    "_min" => 0,
                    "_name" => "Body",
                    "_param" => array(
                            0 => array(
                                    "_nla" => true,
                                    "_param" => "LdelSlash",
                                    "_type" => "recurse"
                                ),
                            1 => array(
                                    "_param" => array(
                                            0 => array(
                                                    "_param" => array(
                                                            0 => array(
                                                                    "_param" => "Ldel",
                                                                    "_pla" => true,
                                                                    "_type" => "recurse"
                                                                ),
                                                            1 => array(
                                                                    "_param" => "CoreTag",
                                                                    "_tag" => "nodes",
                                                                    "_type" => "recurse"
                                                                )
                                                        ),
                                                    "_type" => "sequence"
                                                ),
                                            1 => array(
                                                    "_param" => "Text",
                                                    "_tag" => "nodes",
                                                    "_type" => "recurse"
                                                )
                                        ),
                                    "_type" => "option"
                                )
                        ),
                    "_type" => "sequence",
                    "_actions" => array(
                            "_match" => array(
                                    "nodes" => array(
                                            "Body_nodes" => true
                                        )
                                ),
                            "_finish" => array(
                                    "Body___FINISH" => true
                                )
                        )
                )
        );
    public function matchNodeBody(){
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
            if (!$valid && $iteration1 >= 0) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        return $valid;

    }



    /**
     *
     * Parser rules and action for node 'Body'
     *
     *  Rule:
     <node  Body> <rule>  (  !LdelSlash (  (  &Ldel nodes:CoreTag ) | nodes:Text ) )* </rule>  <action nodes> {
                 $result['nodes'][] = $subres['node'];
               } </action>  <action _finish> {
                if (isset($result['nodes'])) {
                    $result['node'] = new Nodes\Body($result['_parser']);
                    $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                    $result['node']->addSubTree($result['nodes']);
                    unset($result['nodes']);
                } else {
                    $result = false;
                }
            } </action> </node> 
     *
    */

    public function Body_nodes (&$result, $subres) {
        $result['nodes'][] = $subres['node'];
    }


    public function Body___FINISH (&$result) {
        if (isset($result['nodes'])) {
            $result['node'] = new Nodes\Body($result['_parser']);
            $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
            $result['node']->addSubTree($result['nodes']);
            unset($result['nodes']);
        }
        else {
            $result = false;
        }
    }



}
