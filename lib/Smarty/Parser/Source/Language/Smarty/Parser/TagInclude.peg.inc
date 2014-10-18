<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Peg\RuleRoot;

/**
 * Class TagIncludeParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagIncludeParser extends RuleRoot
{
    /*!*
       <pegparser TagInclude>

           <node TagInclude>
               <attribute>attributes=(required=file,optional=(assign,cache_lifetime,compile_id,cache_id)),options=(nocache,caching,inline)</attribute>
               <rule>Ldel 'include' SmartyTagAttributes SmartyTagScopes SmartyTagOptions Rdel</rule>
               <action _start>
               {
                   $nodeRes['node'] = $previous['node'];
               }
               </action>
           </node>

      </pegparser>
   */
}

