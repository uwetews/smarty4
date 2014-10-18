<?php
namespace Smarty\Nodes\Template;

use Smarty\Nodes;

/**
 * Class RuleRoot;
 *
 * @package Smarty\Nodes\Template
 */
class RuleRoot;
{
    /*!*
        <pegparser Template>
            <node Template>
                <rule>.Bom? nodes:Body?</rule>
                <action _start>
                {
                    $nodeRes->node = new Nodes\Internal\Template($nodeRes->_peg);
                }
               </action>
                <action nodes>
                {
                    $nodeRes->node->templateBodyNode = $matchRes->node;
                }
               </action>
            </node>
            <node Bom>
                <rule>/\xEF\xBB\xBF|\xFE\xFF|\xFF\xFE/</rule>
            </node>
       </pegparser>


    */

}

