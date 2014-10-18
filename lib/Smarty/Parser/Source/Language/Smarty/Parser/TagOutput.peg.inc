<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Tag\TagOutput;
use Smarty\Parser\Peg\RuleRoot;

/**
 * Class TagOutputParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagOutputParser extends RuleRoot
{
    /*!*
         <pegparser TagOutput>
             <node TagOutput>
                 <rule>Ldel _? (value:ModifierValue Rdel) | (value:Expr Rdel)</rule>
                 <action value>
                 {
                     $nodeRes['node'] = new TagOutput($this->parser);
                     $nodeRes['node']->addSubTree($matchRes['node'], 'value');
                     $nodeRes['node']->setTraceInfo($nodeRes['_lineno'], '', $nodeRes['_startpos'], $nodeRes['_endpos']);
                 }
                 </action>
             </node>
         </pegparser>
     */
}

