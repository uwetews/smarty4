<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Peg\RuleRoot;

/**
 * Class TagStatementParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagStatementParser extends RuleRoot
{
    /*!*
         <pegparser TagStatement>
             <node TagStatement>
                <attribute>attributes=(required=(variable,value),optional=(append,istag)),options=(nocache,cachevalue)</attribute>
                 <rule>Ldel statement:Statement SmartyTagAttributes SmartyTagOptions Rdel</rule>
                 <action statement>
                 {
                     $nodeRes['node'] = $matchRes['node'];
                     $nodeRes['node']->setTagAttribute(array('istag', true));
                 }
                 </action>
             </node>
         </pegparser>
     */
}

