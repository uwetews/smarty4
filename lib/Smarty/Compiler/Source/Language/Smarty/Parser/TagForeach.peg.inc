<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Compiler\Source\Shared\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\foreachTag
 */
class TagForeachParser
{
    /*!*
        <pegparser TagForeach>

            <node TagForeach>
                <attribute>attributes=(required=(from,item),optional=(key),subtags=(foreachelse)),options=nocache</attribute>
                <rule>tag:(Ldel 'foreach' _  from:Value _ 'as' _ (key:Variable _? '=>' _?)? item:Variable Smarty_Tag_Params Rdel) | ..Smarty_Tag_Default body:Body? (!LdelSlash ..elseTagforeach)? close:Smarty_Tag_Block_Close</rule>
                <action _start>
                {
                    $i = 1;
                }
                </action>
                <action from>
                {
                    $result['node']->setTagAttribute(array('from', $subres['node']));
                }
                </action>
                <action key>
                {
                    $result['node']->setTagAttribute(array('key', $subres['node']));
                }
                </action>
                <action item>
                {
                    $result['node']->setTagAttribute(array('item', $subres['node']));
                }
                </action>
                <action body>
                {
                    $result['node']->addSubTree($subres['node'],'foreach');
                }
                </action>
            </node>

            <token elseTagforeach>
                <rule>Ldel 'foreachelse'  Rdel body:Body?</rule>
                <action _start>
                 {
                    $result['node'] = $previous['node'];
                 }
                </action>
                <action body>
                {
                    $result['node']->addSubTree($subres['node'],'foreachelse');
                }
                </action>
            </token>

       </pegparser>
    */
}
