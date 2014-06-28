<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;
use Smarty\PegParser;

/**
 * Class TagAssignParser
 *
 * @package Smarty\Compiler\Source\Language\Smarty\Parser
 */
class TagAssignParser extends PegParser
{
     /*!*
        <pegparser TagAssign>

            <node TagAssign>
                <attribute>attributes=(required=(name,value)),options=nocache</attribute>
                <rule>tag:(Ldel 'assign' SmartyTagAttributes SmartyTagScopes SmartyTagOptions </rule>
                <action _start>
                {
                    $result['node'] = $previous['node'];
                }
                </action>
            </node>

       </pegparser>
    */
}

