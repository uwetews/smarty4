<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node;
use Smarty\Parser\Peg\RuleRoot;

/**
 * Class BodyParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class BodyParser extends RuleRoot
{
    /*!*
   <pegparser Body>

       <node  Body>
           <attribute>node='Body'</attribute>
           <rule> (( ../(?=({getLdel}(?!(\/))))/ nodes:CoreTag) | nodes:Text )*</rule>
           <action _start>
           {
                $nodeRes['node'] = new Node\Body($this->parser);
                $this->parser->pushBody($nodeRes['node']);
           }
           </action>
           <action nodes>
              {
                $nodeRes['node']->addSubTree($matchRes['node']);
                $this->parser->cleanupCache();
              }
           </action>
           <action _finish>
           {
               $this->parser->popBody();
               if ($nodeRes['node']->getCountSubTree()) {
                    $nodeRes['node']->setTraceInfo($nodeRes['_lineno'], '', $nodeRes['_startpos'], $nodeRes['_endpos']);
               } else {
                   $nodeRes = false;
               }
           }
           </action>
            <action _init(getLdel)>
                {
                    return $this->parser->Ldel;
                }
            </action>
       </node>
   </pegparser>

   */
}
