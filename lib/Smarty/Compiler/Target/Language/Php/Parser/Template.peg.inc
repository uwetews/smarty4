<?php
namespace Smarty\Compiler\Target\Language\Php\Parser;

use Smarty\Node;
use Smarty\Parser\Peg\RuleRoot;

/**
 * Class TemplateParser
 *
 * @package Smarty\Compiler\Target\Language\Php\Parser
 */
class TemplateParser extends RuleRoot
{
    /*!*
         <pegparser Template>
             <node Template>
                 <rule>.Bom? nodes:Body?  Unexpected?</rule>
                 <action _start>
                 {
                     $nodeRes['node'] = new Node\Template($this->parser, $nodeRes);
                 }
                </action>
                 <action nodes>
                 {
                     $nodeRes['node']->templateBodyNode = $matchRes['node'];
                     $nodeRes['node']->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
                     $nodeRes['node']->templateBodyNode->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
                 }
                </action>
             </node>
             <node Bom>
                 <rule>/^(\xEF\xBB\xBF)|(\xFE\xFF)|(\xFF\xFE)/</rule>
             </node>
        </pegparser>


     */
}

