<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Tag\TagOutput;
use Smarty\PegParser;

/**
 * Class TagOutputParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagOutputParser extends PegParser
{
    /*!*
         <pegparser TagOutput>
             <node TagOutput>
                 <rule>Ldel _? value:Expr Rdel</rule>
                 <action value>
                 {
                     $result['node'] = new TagOutput($this->parser);
                     $result['node']->addSubTree($subres['node'], 'value');
                     $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                 }
                 </action>
             </node>
         </pegparser>
     */
}

