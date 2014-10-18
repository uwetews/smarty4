<?php
namespace Smarty\Compiler\Target\Language\Php\Parser;

use Smarty\Nodes;
use Smarty\Parser\Peg\RuleRoot;

/**
 * Class ResourceParser
 *
 * @package Smarty\Compiler\Target\Language\Php\Parser
 */
class ResourceParser extends RuleRoot
{

    /*!*
        <pegparser Resource>
            <node Resource>
                <rule>main:Template</rule>
                <action _start>
                {
                    $nodeRes['node'] = $previous['node'];
                }
                </action>
                <action main>
                {
                    $nodeRes['node']->templateNode = $matchRes['node'];
                }
                </action>
            </node>
       </pegparser>

    */

}

