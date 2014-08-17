<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\PegParser;

/**
 * Class TagIncludeParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagIncludeParser extends PegParser
{
    /*!*
       <pegparser TagInclude>

           <node TagInclude>
               <attribute>attributes=(required=file,optional=(assign,cache_lifetime,compile_id,cache_id)),options=(nocache,caching,inline)</attribute>
               <rule>Ldel 'include' SmartyTagAttributes SmartyTagScopes SmartyTagOptions Rdel</rule>
               <action _start>
               {
                   $result['node'] = $previous['node'];
               }
               </action>
           </node>

      </pegparser>
   */
}

