<?php
namespace Smarty\Nodes\Template;

use Smarty\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Template
 */
class PegParser
{
    /*!*
        <pegparser Template>
            <node Template>
                <rule>.Bom? nodes:Body?</rule>
                <action _start>
                {
                    $result->node = new Nodes\Internal\Template($result->_peg);
                }
               </action>
                <action nodes>
                {
                    $result->node->templateBodyNode = $subres->node;
                }
               </action>
            </node>
            <node Bom>
                <rule>/\xEF\xBB\xBF|\xFE\xFF|\xFF\xFE/</rule>
            </node>
       </pegparser>


    */

}

