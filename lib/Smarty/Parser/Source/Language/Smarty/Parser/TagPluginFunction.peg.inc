<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;
use Smarty\PegParser;

/**
 * Class TagAssignParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagPluginFunctionParser extends PegParser
{
     /*!*
        <pegparser TagPluginFunction>

            <node TagPluginFunction>
                <attribute>options=(nocache)</attribute>
                <rule>Ldel Id SmartyTagAttributes SmartyTagOptions Rdel</rule>
                <action _start>
                {
                    $result['node'] = $previous['node'];
                }
                </action>
            </node>

       </pegparser>
    */
}

