<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;
use Smarty\PegParser;

/**
 * Class CoreTagParser
 *
 * @package Smarty\Compiler\Source\Language\Smarty\Parser
 */
class CoreTagParser extends PegParser
{
    /*!*
    <pegparser CoreTag>

    #
    #   Tag parsing
    #   ###########
    #
    #   Except for the output tag a tag dispatcher is called.
    #
    #   The tag dispatcher scans for registered tags, plugins, template functions,
    #   core language tags and calls the corresponding parser.
    #
    #
        <token CoreTag>
            <rule> ( .Ldel .tagname:Id !'(' tag:$tagDispatcher) | tag:TagStatement | tag:TagOutput </rule>
            <action _start>
            {
                $i = 1;
            }
            </action>
             <action _expression(tagDispatcher)>
                {
                    $result['_text'] = '';
                    return $this->parser->tagDispatcher($result);
                }
            </action>
            <action tag>
                {
                    $result['node'] = $subres['node'];
                }
            </action>
        </token>

    #
    # Tag attribute
    #
    #           -> named                           ->shorttag
        <token SmartyTagAttributes>
            <rule>  ( _ ( name:Id _? '=' _?) value:Value)* </rule>
             <action _start>
            {
                $result['node'] = $previous['node'];
            }
            </action>
           <action name>
            {
                $result['name'] = strtolower($subres['_text']);
            }
            </action>
            <action value>
            {
                $result['node']->setTagAttribute(array(isset($result['name']) ? $result['name'] : null, $subres['node']));
            }
            </action>
            <action _finish>
            {
                $i = 1;
            }
            </action>
        </token>

    #
    # Tag options
    #
    #
        <token SmartyTagOptions>
            <rule>  ( _ option:Id)* </rule>
            <action _start>
            {
                $result['node'] = $previous['node'];
            }
            </action>
           <action option>
            {
                $result['node']->setTagOption(strtolower($subres['_text']));
            }
            </action>
        </token>
    #
    # Tag scopes
    #
    #
        <token SmartyTagScopes>
            <rule> (/scope\s*=\s*(?<scope>(parent|root|global))/)? </rule>
            <action _start>
            {
                $result['node'] = $previous['node'];
            }
            </action>
           <action option>
            {
                $result['node']->setTagOption(strtolower($subres['_text']));
            }
            </action>
        </token>

    #
    # Block Close Tag
    #
        <token Smarty_Tag_Block_Close>
            <rule> LdelSlash tag:Id Rdel</rule>
        </token>

    #
    # Default tag syntax
    #
        <node Smarty_Tag_Default>
            <rule> Ldel Id SmartyTagAttributes SmartyTagOptions Rdel </rule>
            <action _start>
            {
                $result['node'] = $previous['node'];
            }
            </action>
            <action _finish>
            {
                $result['tagAttributes'] = array();
                if (isset($result['attrib'])) {
                    $result['tagAttributes'] = $result['attrib']['attrib'];
                    unset($result['attrib']);
                }
                $result['tagOptions'] = array();
                if (isset($result['options'])) {
                    $result['tagOptions'] = $result['options']['Options'];
                    unset($result['options']);
                }

            }
            </action>
        </node>

    #
    # Default block tag syntax
    #
        <node Smarty_Tag_Block_Default>
            <rule> Smarty_Tag_Default body:Body Smarty_Tag_Block_Close</rule>
        </node>



    </pegparser>

    */
}
