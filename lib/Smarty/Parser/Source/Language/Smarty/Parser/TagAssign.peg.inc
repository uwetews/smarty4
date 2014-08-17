<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\PegParser;

/**
 * Class TagAssignParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagAssignParser extends PegParser
{
    /*!*
       <pegparser TagAssign>

           <node TagAssign>
               <attribute>attributes=(required=(var,value)),options=(nocache,cachevalue)</attribute>
               <rule>Ldel 'assign' SmartyTagAttributes SmartyTagOptions Rdel</rule>
               <action _start>
               {
                   $result['node'] = $previous['node'];
               }
               </action>
           </node>

      </pegparser>
   */
}

