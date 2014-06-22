<?php
namespace Smarty\Compiler\Target\Language\Php\Parser;

use Smarty\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Resource
 */
class ResourceParser
{

   
    /**
     *
     * Parser generated on 2014-06-21 12:41:38
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Target/Language/Php/Parser/Resource.peg.inc' dated 2014-06-10 22:49:39
     *
    */




    public $rules = array(
            "Resource" => array(
                    "_attr" => array(
                            "_nodetype" => "node"
                        ),
                    "_name" => "Resource",
                    "_param" => "Template",
                    "_tag" => "main",
                    "_type" => "recurse",
                    "_actions" => array(
                            "_match" => array(
                                    "main" => array(
                                            "Resource_main" => true
                                        )
                                )
                        )
                )
        );
    public function matchNodeResource(){
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
     * Parser rules and action for node 'Resource'
     *
     *  Rule:
     <node Resource> <rule>  main:Template </rule>  <action main> {
                    $result['node']->templateNode = $subres['node'];
                } </action> </node> 
     *
    */

    public function Resource_main (&$result, $subres) {
        $result['node']->templateNode = $subres['node'];
    }




}

