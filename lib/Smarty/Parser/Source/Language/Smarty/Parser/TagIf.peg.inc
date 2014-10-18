<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Peg\RuleRoot;

/**
 * Class TagIfParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagIfParser extends RuleRoot
{
    /*!*
        <pegparser TagIf>
            <node TagIf>
                <attribute>attributes=(subtags=(elseif,else)),options=nocache</attribute>
                <rule>Ldel 'if' _ condition:( Unilog? Statement) | condition:Logexpr SmartyTagOptions Rdel body:Body? (!SmartyBlockCloseTag elseifTagif)* (!SmartyBlockCloseTag elseTagif)? close:SmartyBlockCloseTag</rule>
                <action _start>
                {
                    $nodeRes['node'] = $previous['node'];
                }
                </action>
                <action condition>
                {
                    $nodeRes['condition'] = $matchRes['node'];
                }
                </action>
                <action body>
                {
                    $nodeRes['body'] = $matchRes['node'];
                }
                </action>
                <action _finish>
                {
                    $nodeRes['node']->addSubTree(array('condition' => $nodeRes['condition'], 'body' => isset($nodeRes['body']) ? $nodeRes['body'] : false),'if');
                }
                </action>
            </node>
            <token elseifTagif>
                <rule>Ldel 'elseif' _ condition:( Unilog? Statement) | condition:Logexpr Rdel body:Body?</rule>
                <action _start>
                 {
                    $nodeRes['node'] = $previous['node'];
                 }
                </action>
                <action condition>
                {
                    $nodeRes['condition'] = $matchRes['node'];
                }
                </action>
                <action body>
                {
                    $nodeRes['body'] = $matchRes['node'];
                }
                </action>
                <action _finish>
                {
                    $nodeRes['node']->addSubTree(array('condition' => $nodeRes['condition'], 'body' => isset($nodeRes['body']) ? $nodeRes['body'] : false),'elseif', true);
                }
                </action>
            </token>

            <token elseTagif>
                <rule>Ldel 'else'  Rdel body:Body?</rule>
                <action _start>
                {
                    $nodeRes['node'] = $previous['node'];
                }
                </action>
                <action body>
                {
                    $nodeRes['body'] = $matchRes['node'];
                }
                </action>
                <action _finish>
                {
                    $nodeRes['node']->addSubTree(array('body' => isset($nodeRes['body']) ? $nodeRes['body'] : false),'else');
                }
                </action>
            </token>
       </pegparser>
    */
}

