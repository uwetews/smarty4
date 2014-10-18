<?php
namespace Smarty\Nodes\Number;

/**
 * Class RuleRoot;
 *
 * @package Smarty\Nodes\Core
 */
class RuleRoot;
{
    /*!*
    <pegparser Number>
        <node Number>
            <rule>/[0-9]+(?:\.[0-9]+)?/</rule>
            <action _finish>
            {
                $nodeRes->_value = $nodeRes->_text;
                $nodeRes->_compile = $nodeRes->_text;
                $nodeRes->_type = 'value';
                $nodeRes->_subtype = 'numeric';
            }
            </action>
        </node>
    </pegparser>
    */
}

