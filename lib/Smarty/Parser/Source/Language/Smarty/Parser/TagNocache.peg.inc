<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Peg\RuleRoot;

/**
 * Class TagNocacheParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagNocacheParser extends RuleRoot
{
    /*!*
        <pegparser TagNocache>

            <node TagNocache>
                <attribute>options=()</attribute>
                <rule>Ldel 'nocache'  Rdel  body:Body? close:Smarty_Tag_Block_Close</rule>
                <action _start>
                {
                    $nodeRes['node'] = $previous['node'];
                }
                </action>
                <action body>
                {
                    $nodeRes['node']->addSubTree($matchRes['node']);
                }
                </action>
            </node>

       </pegparser>
    */
}

