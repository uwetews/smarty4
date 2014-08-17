<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\PegParser;

/**
 * Class TagNocacheParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagNocacheParser extends PegParser
{
    /*!*
        <pegparser TagNocache>

            <node TagNocache>
                <attribute>options=()</attribute>
                <rule>Ldel 'nocache'  Rdel  body:Body? close:Smarty_Tag_Block_Close</rule>
                <action _start>
                {
                    $result['node'] = $previous['node'];
                }
                </action>
                <action body>
                {
                    $result['node']->addSubTree($subres['node']);
                }
                </action>
            </node>

       </pegparser>
    */
}

