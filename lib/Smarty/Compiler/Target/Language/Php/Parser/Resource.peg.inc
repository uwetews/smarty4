<?php
namespace Smarty\Compiler\Target\Language\Php\Parser;

use Smarty\Nodes;
use Smarty\PegParser;

/**
 * Class ResourceParser
 *
 * @package Smarty\Compiler\Target\Language\Php\Parser
 */
class ResourceParser extends PegParser
{

    /*!*
        <pegparser Resource>
            <node Resource>
                <rule>main:Template</rule>
                <action _start>
                {
                    $result['node'] = $previous['node'];
                }
                </action>
                <action main>
                {
                    $result['node']->templateNode = $subres['node'];
                }
                </action>
            </node>
       </pegparser>

    */

}

