<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Compiler\Source\Shared\Node;
use Smarty\PegParser;

/**
 * Class TagStatementParser
 *
 * @package Smarty\Compiler\Source\Language\Smarty\Parser
 */
class TagStatementParser extends PegParser
{
    /*!*
         <pegparser TagStatement>
             <node TagStatement>
                 <rule>Ldel statement:Statement Rdel</rule>
                 <action statement>
                 {
                     $result['node'] = new Node\TagOutput($this->parser);
                     $result['node']->addSubTree($subres['node'], 'value');
                     $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                 }
                 </action>
             </node>
         </pegparser>
     */
}

