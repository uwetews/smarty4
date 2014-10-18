<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Peg\RuleRoot;

/**
 * Class RuleRoot;
 *
 * @package Smarty\Source\Smarty\Nodes\foreachTag
 */
class TagForeachParser extends RuleRoot
{
    /*!*
        <pegparser TagForeach>

            <node TagForeach>
                <attribute>attributes=(required=(from,item),optional=(key),subtags=(foreachelse)),options=nocache</attribute>
                <rule>tag:(Ldel 'foreach' _  from:Value _ 'as' _ (key:Variable _? '=>' _?)? item:Variable (!Rdel SmartyTagOptions)? Rdel) | ..Smarty_Tag_Default body:Body? (!LdelSlash ..elseTagforeach)? close:SmartyBlockCloseTag</rule>
                <action _start>
                {
                    $nodeRes['node'] = $previous['node'];
                }
                </action>
                <action from>
                {
                    $nodeRes['node']->setTagAttribute(array('from', $matchRes['node']));
                }
                </action>
                <action key>
                {
                    $nodeRes['key'] = $matchRes['node'];
                }
                </action>
                <action item>
                {
                    $nodeRes['node']->setTagAttribute(array('item', $matchRes['node']));
                }
                </action>
                <action _finish>
                {
                    if (isset($nodeRes['key'])) {
                        $nodeRes['node']->setTagAttribute(array('key', $nodeRes['key']));
                    }
                }
                </action>
                <action body>
                {
                    $nodeRes['node']->addSubTree($matchRes['node'],'foreach');
                }
                </action>
            </node>

            <token elseTagforeach>
                <rule>Ldel 'foreachelse'  Rdel body:Body?</rule>
                <action _start>
                 {
                    $nodeRes['node'] = $previous['node'];
                 }
                </action>
                <action body>
                {
                    $nodeRes['node']->addSubTree($matchRes['node'],'foreachelse');
                }
                </action>
            </token>

       </pegparser>
    */
}

