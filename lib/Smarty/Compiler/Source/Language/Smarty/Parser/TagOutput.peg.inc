<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Compiler\Source\Shared\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\internalPrintTag
 */
class TagOutputParser
{
    /*!*
        <pegparser TagOutput>
            <node TagOutput>
                <rule>Ldel _? value:Expr Rdel</rule>
                <action value>
                {
                    $result['node'] = new Nodes\TagOutput($result['_parser']);
                    $result['node']->addSubTree($subres['node'], 'value');
                    $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                }
                </action>
            </node>
        </pegparser>
    */
}

