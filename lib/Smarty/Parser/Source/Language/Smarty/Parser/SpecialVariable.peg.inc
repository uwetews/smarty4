<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Value\String;
use Smarty\Parser\Peg\RuleRoot;
use Smarty\Node;

/**
 * Class SpecialVariableParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class SpecialVariableParser extends RuleRoot
{
    /*!*
    <pegparser SpecialVariable>
    #
    #  Special Smarty variable starting with  $smarty.
    #
    #
        <node SpecialVariable>
            <attribute>hash</attribute>
            <rule>'$smarty.' </rule>
            <action _start>
            {
                $i = 1;
            }
            </action>
        </node>
    </pegparser>

    */
}
