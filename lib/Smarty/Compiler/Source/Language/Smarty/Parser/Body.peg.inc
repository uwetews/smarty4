<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Compiler\Source\Language\Smarty\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\Smarty
 */
class BodyParser
{
    /*!*
    <pegparser Body>


        <node  Body>
            <rule> ( !LdelSlash ((&Ldel nodes:CoreTag) | nodes:Text ))*</rule>
            <action nodes>
               {
                 $result['nodes'][] = $subres['node'];
               }
            </action>
            <action _finish>
            {
                if (isset($result['nodes'])) {
                    $result['node'] = new Nodes\Body($result['_parser']);
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
