<?php
namespace Smarty\Nodes\Number;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Core
 */
class PegParser
{
    /*!*
    <pegparser Number>
        <node Number>
            <rule>/[0-9]+(?:\.[0-9]+)?/</rule>
            <action _finish>
            {
                $result->_value = $result->_text;
                $result->_compile = $result->_text;
                $result->_type = 'value';
                $result->_subtype = 'numeric';
            }
            </action>
        </node>
    </pegparser>
    */
}

