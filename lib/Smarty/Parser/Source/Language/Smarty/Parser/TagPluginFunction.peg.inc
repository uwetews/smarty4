<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Peg\RuleRoot;

/**
 * Class TagAssignParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagPluginFunctionParser extends RuleRoot
{
    /*!*
       <pegparser TagPluginFunction>

           <node TagPluginFunction>
               <attribute>attributes=(optional=(_any)),options=(nocache)</attribute>
               <rule>Ldel Id SmartyTagAttributes SmartyTagOptions Rdel</rule>
               <action _start>
               {
                   $nodeRes['node'] = $previous['node'];
               }
               </action>
           </node>

      </pegparser>
   */
}

