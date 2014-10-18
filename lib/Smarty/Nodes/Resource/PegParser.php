<?php
namespace Smarty\Nodes\Resource;

/**
 * Class RuleRoot;
 *
 * @package Smarty\Nodes\Resource
 */

class RuleRoot;
{

    public $rules = array(
        "Resource" => array(
            "_name"  => "Resource",
            "_param" => "Template",
            "_tag"   => "main",
            "_type"  => "token"
        )
    );
    /**
     * Parser rules and action for node 'Resource'
     *  Rule: ->  <node Resource> <rule>  main:Template </rule> </node>  <-

     */

}

