<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Peg\RuleRoot;

/**
 * Class TagWhileParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagWhileParser extends RuleRoot
{
    /*!*
        <pegparser TagWhile>
            <node TagWhile>
                <attribute>options=nocache</attribute>
                <rule>Ldel 'while' _ condition:( Unilog? Statement) | condition:Logexpr SmartyTagOptions Rdel body:Body? close:SmartyBlockCloseTag</rule>
                <action _start>
                {
                    $nodeRes['node'] = $previous['node'];
                }
                </action>
                <action condition>
                {
                    $nodeRes['condition'] = $matchRes['node'];
                }
                </action>
                <action body>
                {
                    $nodeRes['body'] = $matchRes['node'];
                }
                </action>
                <action _finish>
                {
                    $nodeRes['node']->addSubTree(array('condition' => $nodeRes['condition'], 'body' => isset($nodeRes['body']) ? $nodeRes['body'] : false),'while');
                }
                </action>
            </node>
        </pegparser>
    */
}

