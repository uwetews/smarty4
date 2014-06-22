<?php
namespace Smarty\Compiler\Target\Language\Php\Parser;

use Smarty\Node;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Template
 */
class TemplateParser
{
    /*!*
        <pegparser Template>
            <node Template>
                <rule>.Bom? nodes:Body?  Unexpected?</rule>
                <action _start>
                {
                    $result['node'] = new Node\Template($result['_parser'], $result);
                }
               </action>
                <action nodes>
                {
                    $result['node']->templateBodyNode = $subres['node'];
                    $result['node']->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
                    $result['node']->templateBodyNode->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
                }
               </action>
            </node>
            <node Bom>
                <rule>/\xEF\xBB\xBF|\xFE\xFF|\xFF\xFE/</rule>
            </node>
       </pegparser>


    */

}

