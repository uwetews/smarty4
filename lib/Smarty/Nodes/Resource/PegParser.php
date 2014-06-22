<?php
namespace Smarty\Nodes\Resource;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Resource
 */

class PegParser
{

    public $rules = array(
        "Resource" => array(
            "_name"    => "Resource",
            "_param" => "Template",
            "_tag"     => "main",
            "_type"    => "recurse"
        )
    );
    /**
     * Parser rules and action for node 'Resource'
     *  Rule: ->  <node Resource> <rule>  main:Template </rule> </node>  <-

     */

}

