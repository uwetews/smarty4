<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Compiler\Source\Shared\Nodes;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\ifTag
 */
class TagIfParser
{
    /*!*
        <pegparser TagIf>
            <node TagIf>
                <attribute>attributes=(subtags=(elseif,else)),options=nocache</attribute>
                <rule>Ldel 'if' _ condition:Statement | condition:Logexpr Smarty_Tag_Params Rdel body:Body? (!LdelSlash elseifTagif)* (!LdelSlash elseTagif)? close:Smarty_Tag_Block_Close</rule>
                <action _start>
                {
                    $i =1;
                }
                </action>
                <action condition>
                {
                    $result['condition'] = $subres['node'];
                }
                </action>
                <action body>
                {
                    $result['body'] = $subres['node'];
                }
                </action>
                <action _finish>
                {
                    $result['node']->addSubTree(array('condition' => $result['condition'], 'body' => isset($result['body']) ? $result['body'] : false),'if');
                }
                </action>
            </node>
            <token elseifTagif>
                <rule>Ldel 'elseif' _ condition:Statement | condition:Logexpr Rdel body:Body?</rule>
                <action _start>
                 {
                    $result['node'] = $previous['node'];
                 }
                </action>
                <action condition>
                {
                    $result['condition'] = $subres['node'];
                }
                </action>
                <action body>
                {
                    $result['body'] = $subres['node'];
                }
                </action>
                <action _finish>
                {
                    $result['node']->addSubTree(array('condition' => $result['condition'], 'body' => isset($result['body']) ? $result['body'] : false),'elseif', true);
                }
                </action>
            </token>

            <token elseTagif>
                <rule>Ldel 'else'  Rdel body:Body?</rule>
                <action _start>
                {
                    $result['node'] = $previous['node'];
                }
                </action>
                <action body>
                {
                    $result['body'] = $subres['node'];
                }
                </action>
                <action _finish>
                {
                    $result['node']->addSubTree(array('body' => isset($result['body']) ? $result['body'] : false),'else');
                }
                </action>
            </token>
       </pegparser>
    */
}

