<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\PegParser;
/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\foreachTag
 */
class TagNocacheParser extends PegParser
{
    /*!*
        <pegparser TagNocache>

            <node TagNocache>
                <attribute>options=()</attribute>
                <rule>Ldel 'nocache'  Rdel  body:Body? close:SmartyBlockCloseTag</rule>
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

