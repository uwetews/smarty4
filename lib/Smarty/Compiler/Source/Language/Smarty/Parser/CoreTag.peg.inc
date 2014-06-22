<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\Smarty
 */
class CoreTagParser
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
            <rule> ( .Ldel .tagname:Id !'(' tag:$tagDispatcher) | tag:TagOutput </rule>
            <action _start>
            {
                $i = 1;
            }
            </action>
             <action _expression(tagDispatcher)>
                {
                    $result['_text'] = '';
                    return $result['_parser']->tagDispatcher($result);
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
        <token Smarty_Tag_Attributes>
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
    #           -> named                           ->shorttag
        <token Smarty_Tag_Params>
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
    # Block Close Tag
    #
        <token Smarty_Tag_Block_Close>
            <rule> LdelSlash tag:Id Rdel</rule>
        </token>

    #
    # Default tag syntax
    #
        <node Smarty_Tag_Default>
            <rule> Ldel Id Smarty_Tag_Attributes Smarty_Tag_Params Rdel </rule>
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
