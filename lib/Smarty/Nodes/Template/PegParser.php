<?php
namespace Smarty\Nodes\Template;

use Smarty\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Template
 */
class PegParser
{

    public $rules = array(
        "Template" => array(
            "_name"    => "Template",
            "_param"   => array(
                0 => array(
                    "_min"    => 0,
                    "_silent" => 1,
                    "_param"  => "Bom",
                    "_type"   => "recurse"
                ),
                1 => array(
                    "_min"   => 0,
                    "_param" => "Body",
                    "_tag"   => "nodes",
                    "_type"  => "recurse"
                )
            ),
            "_type"    => "sequence",
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
        "Bom"      => array(
            "_name"  => "Bom",
            "_param" => "/\\xEF\\xBB\\xBF|\\xFE\\xFF|\\xFF\\xFE/",
            "_type"  => "rx"
        )
    );

    /**
     * Parser rules and action for node 'Template'
     *  Rule: ->  <node Template> <rule>  .Bom? nodes:Body? </rule>  <action _start> {
     * $result->node = new Nodes\Internal\Template($result->_peg);
     * } </action>  <action nodes> {
     * $result->node->templateBodyNode = $subres->node;
     * } </action> </node>  <-

     */

    public function Template___START($result)
    {
        $result->node = new Nodes\Internal\Template($result->_peg);
    }

    public function Template_nodes($result, $subres)
    {
        $result->node->templateBodyNode = $subres->node;
    }
    /**
     * Parser rules and action for node 'Bom'
     *  Rule: ->  <node Bom> <rule>  /\xEF\xBB\xBF|\xFE\xFF|\xFF\xFE/ </rule> </node>  <-

     */

}

