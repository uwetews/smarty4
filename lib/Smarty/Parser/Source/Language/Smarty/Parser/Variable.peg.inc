<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Value\String;
use Smarty\PegParser;
use Smarty\Node;
/**
 * Class VariableParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class VariableParser  extends PegParser
{
    /*!*
    <pegparser Variable>
    #
    # Template variable
    #
    #                -> name can be nested variable                    -> array access     -> property or method
        <node Variable>
            <attribute>hash</attribute>
            <rule>  (&'$smarty.' special:SpecialVariable) | (isvar:'$' ((id:Id | ('{' var:Variable '}'))+ ('@' property:Id)? ( (&/\.|\[/ Arrayelement) | ( &'->' Object))*)) </rule>
            <action _start>
            {
                $i = 1;
            }
            </action>
            <action special>
            {
                $result['node'] = $subres['node'];
            }
            </action>
            <action isvar>
            {
                $result['node'] = new Node($this->parser, 'Variable');
            }
            </action>
            <action id>
            {
                $node = new String($this->parser);
                $result['node']->addSubTree($node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']), 'name', true);
            }
            </action>
            <action var>
            {
                $result['node']->addSubTree($subres['node'], 'name', true);
            }
            </action>
            <action property>
            {
                $result['node']->addSubTree($subres['_text'], 'property');
            }
            </action>
            <action _finish>
            {
                    $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

        <node Arrayelement>
            <rule>(('.' ( iv:Id | value:Value)) | ('['  value:Expr ']'))+</rule>
            <action _start>
            {
                $result['node'] = $previous['node'];
            }
            </action>
            <action value>
            {
                $result['node']->addSubTree(array('type' => 'arrayelement', 'node' => $subres['node']) , 'suffix', true);
            }
            </action>
            <action iv>
            {
                $node = new String($this->parser);
                $result['node']->addSubTree(array('type' => 'arrayelement', 'node' => $node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']) , 'suffix', true));
            }
            </action>
        </node>

        <token Object>
            <rule>(addsuffix:('->' ( .iv:Id | .var:Variable) method:Parameter?))+</rule>
            <action _start>
            {
                $result['node'] = $previous['node'];
            }
            </action>
            <action iv>
            {
                $node = new String($this->parser);
                $node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
                $result['name'] = $node;
            }
            </action>
            <action var>
            {
                $result['name'] = $subres['node'];
            }
            </action>
            <action method>
            {
                $result['method'] = $subres['node'];
            }
            </action>
            <action addsuffix>
            {
                $result['node']->addSubTree(array('type' => 'object', 'name' => $subres['name'], 'method' => isset($subres['method']) ? $subres['method'] : null) , 'suffix', true);
            }
            </action>
        </token>

    </pegparser>

    */
}
