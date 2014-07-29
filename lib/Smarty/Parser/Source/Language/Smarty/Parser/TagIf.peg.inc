<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\PegParser;

/**
 * Class TagIfParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagIfParser extends PegParser
{
    /*!*
        <pegparser TagIf>
            <node TagIf>
                <attribute>attributes=(subtags=(elseif,else)),options=nocache</attribute>
                <rule>Ldel 'if' _ condition:( Unilog? Statement) | condition:Logexpr SmartyTagOptions Rdel body:Body? (!SmartyBlockCloseTag elseifTagif)* (!SmartyBlockCloseTag elseTagif)? close:SmartyBlockCloseTag</rule>
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
                    $result['node']->addSubTree(array('condition' => $result['condition'], 'body' => isset($result['body']) ? $result['body'] : false),'if');
                }
                </action>
            </node>
            <token elseifTagif>
                <rule>Ldel 'elseif' _ condition:( Unilog? Statement) | condition:Logexpr Rdel body:Body?</rule>
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

