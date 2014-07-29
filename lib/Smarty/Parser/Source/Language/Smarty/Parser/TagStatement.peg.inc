<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\PegParser;

/**
 * Class TagStatementParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagStatementParser extends PegParser
{
    /*!*
         <pegparser TagStatement>
             <node TagStatement>
                <attribute>attributes=(required=(variable,value),optional=(append,istag)),options=(nocache,cachevalue)</attribute>
                 <rule>Ldel statement:Statement SmartyTagAttributes SmartyTagOptions Rdel</rule>
                 <action statement>
                 {
                     $result['node'] = $subres['node'];
                     $result['node']->setTagAttribute(array('istag', true));
                 }
                 </action>
             </node>
         </pegparser>
     */
}

