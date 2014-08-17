<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node;
use Smarty\PegParser;

/**
 * Class BodyParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class BodyParser extends PegParser
{
    /*!*
   <pegparser Body>

       <node  Body>
           <attribute>node='Body'</attribute>
           <rule> ((!LdelSlash &Ldel .nodes:CoreTag) | nodes:Text )*</rule>
           <action nodes>
              {
                $result['nodes'][] = $subres['node'];
              }
           </action>
           <action _finish>
           {
               if (isset($result['nodes'])) {
                   $result['node'] = new Node\Body($this->parser);
                   $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                   $result['node']->addSubTree($result['nodes']);
                   unset($result['nodes']);
               } else {
                   $result = false;
               }
           }
           </action>
       </node>
   </pegparser>

   */
}
