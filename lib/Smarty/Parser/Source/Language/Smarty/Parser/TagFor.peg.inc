<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\PegParser;
/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\foreachTag
 */
class TagForParser extends PegParser
{
    /*!*
        <pegparser TagFor>

            <node TagFor>
                <attribute>attributes=(required=(start,to),optional=(step,max),subtags=(forelse)),options=nocache</attribute>
                <rule>tag:(Ldel 'for' _ (start:Statement _ 'to' _ to:Mathexpr ( _ 'step' _ step:Mathexpr)?) | (start:Statement (_? ',' _? start:Statement)* _? ';' _? condition:Expr _? ';' _? iteration:Statement (_? ',' _? iteration:Statement)*) SmartyTagOptions Rdel) body:Body? (!LdelSlash ..elseTagfor)? close:SmartyBlockCloseTag</rule>
                <action _start>
                {
                    $result['node'] = $previous['node'];
                }
                </action>
                <action start>
                {
                    $subres['node']->setTagAttribute(array('istag', true));
                    $result['node']->setTagAttribute(array('start', $subres['node']));
                }
                </action>
                <action to>
                {
                    $result['node']->setTagAttribute(array('to', $subres['node']));
                }
                </action>
                <action step>
                {
                    $result['node']->setTagAttribute(array('step', $subres['node']));
                }
                </action>
                <action condition>
                {
                    $result['node']->setTagAttribute(array('condition', $subres['node']));
                }
                </action>
                <action iteration>
                {
                    $result['node']->setTagAttribute(array('iteration', $subres['node']));
                }
                </action>
                <action body>
                {
                    $result['node']->addSubTree($subres['node'],'for');
                }
                </action>
            </node>

            <token elseTagfor>
                <rule>Ldel 'forelse'  Rdel body:Body?</rule>
                <action _start>
                 {
                    $result['node'] = $previous['node'];
                 }
                </action>
                <action body>
                {
                    $result['node']->addSubTree($subres['node'],'forelse');
                }
                </action>
            </token>

       </pegparser>
    */
}

