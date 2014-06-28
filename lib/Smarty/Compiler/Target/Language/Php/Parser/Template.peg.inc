<?php
namespace Smarty\Compiler\Target\Language\Php\Parser;

use Smarty\Node;
use Smarty\PegParser;

/**
 * Class TemplateParser
 *
 * @package Smarty\Compiler\Target\Language\Php\Parser
 */
class TemplateParser extends PegParser
{
    /*!*
         <pegparser Template>
             <node Template>
                 <rule>.Bom? nodes:Body?  Unexpected?</rule>
                 <action _start>
                 {
                     $result['node'] = new Node\Template($this->parser, $result);
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

