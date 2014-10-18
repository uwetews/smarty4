<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Value\String;
use Smarty\Parser\Source\Language\Smarty\Node\Value\Variable;
use Smarty\Parser\Peg\RuleRoot;
use Smarty\Node;

/**
 * Class VariableParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class VariableParser extends RuleRoot
{
    /*!*
    <pegparser Variable>
    #
    # Template variable
    #
    #                -> name can be nested variable                    -> array access     -> property or method
        <node Variable>
            <attribute>hash</attribute>
            <rule>  ( ../(?=([$]smarty[.]))/ special:SpecialVariable) | ( /(?<isvar>[$])(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/ ( '{' var:Variable /(\})(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/ )* ( ../(?=([@.\[]|(->)))/ (('@' property:Id)? ( ( ../(?=([.\[]))/ Arrayelement) | ( &'->' Object))*))? ) </rule>
            <action _start>
            {
                $i = 1;
            }
            </action>
            <action special>
            {
                $nodeRes['node'] = $matchRes['node'];
            }
            </action>
            <action isvar>
            {
                $nodeRes['node'] = new Variable($this->parser);
            }
            </action>
            <action id>
            {
                $node = new String($this->parser);
                $nodeRes['node']->addSubTree($node->setValue($matchRes['_pregMatch']['id'], true)->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']), 'name', true);
            }
            </action>
            <action var>
            {
                $nodeRes['node']->addSubTree($matchRes['node'], 'name', true);
            }
            </action>
            <action property>
            {
                $nodeRes['node']->addSubTree($matchRes['_text'], 'property');
            }
            </action>
            <action _finish>
            {
                    $nodeRes['node']->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
            }
            </action>
        </node>

        <node Arrayelement>
            <rule>(('.' ( iv:Id | value:Value)) | ('['  value:Expr ']'))+</rule>
            <action _start>
            {
                $nodeRes['node'] = $previous['node'];
            }
            </action>
            <action value>
            {
                $nodeRes['node']->addSubTree(array('type' => 'arrayelement', 'node' => $matchRes['node']) , 'suffix', true);
            }
            </action>
            <action iv>
            {
                $node = new String($this->parser);
                $nodeRes['node']->addSubTree(array('type' => 'arrayelement', 'node' => $node->setValue($matchRes['_text'], true)->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']) , 'suffix', true));
            }
            </action>
        </node>

        <token Object>
            <rule>(addsuffix:('->' ( .iv:Id | .var:Variable) method:Parameter?))+</rule>
            <action _start>
            {
                $nodeRes['node'] = $previous['node'];
            }
            </action>
            <action iv>
            {
                $node = new String($this->parser);
                $node->setValue($matchRes['_text'], true)->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
                $nodeRes['name'] = $node;
            }
            </action>
            <action var>
            {
                $nodeRes['name'] = $matchRes['node'];
            }
            </action>
            <action method>
            {
                $nodeRes['method'] = $matchRes['param'];
            }
            </action>
            <action addsuffix>
            {
                $nodeRes['node']->addSubTree(array('type' => 'object', 'name' => $matchRes['name'], 'method' => isset($matchRes['method']) ? $matchRes['method'] : null) , 'suffix', true);
            }
            </action>
        </token>

    </pegparser>

    */
}
