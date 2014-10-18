<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Peg\RuleRoot;
use Smarty\Node;

/**
 * Class CoreTagParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class CoreTagParser extends RuleRoot
{
    /*!*
    <pegparser CoreTag>

        <token Ldel>
            <attribute>matchall</attribute>
            # do not change! real left delimiter regular expression will be obtained by parser
            <rule>/{getLdel}/</rule>
            <action _init(getLdel)>
                {
                    return $this->parser->Ldel;
                }
            </action>
        </token>

        <token LdelSlash>
            <attribute>matchall</attribute>
            # do not change! real left delimiter regular expression will be obtained by parser
            <rule>/{getLdel}\//</rule>
            <action _init(getLdel)>
                {
                    return $this->parser->Ldel;
                }
            </action>
        </token>

        <token Rdel>
            <attribute>matchall</attribute>
            # do not change! real left delimiter regular expression will be obtained by parser
            <rule>/\s*{getRdel}/</rule>
            <action _init(getRdel)>
                {
                    return $this->parser->Rdel;
                }
            </action>
        </token>


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
            <rule> ( /({getLdel})(?<tagname>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* ))(?!(\s*\())/ tag:$SmartyTag) | ( ( ../(?=({getLdel}.*?=.*?{getRdel}))/ tag:TagStatement ) | tag:TagOutput ) </rule>
            <action _start>
            {
                $i = 1;
            }
            </action>
             <action _expression(SmartyTag)>
                {
                    $nodeRes['_text'] = '';
                    return $this->parser->tagDispatcher($nodeRes);
                }
            </action>
            <action tag>
                {
                    $nodeRes['node'] = $matchRes['node'];
                }
            </action>
            <action tagname>
                {
                    $nodeRes['tagname'] = $matchRes['_pregMatch']['tagname'];
                    $nodeRes['savedstartpos'] = $matchRes['_startpos'];
                    $nodeRes['savedline'] = $matchRes['_lineno'];
                }
            </action>
            <action _init(getLdel)>
                {
                    return $this->parser->Ldel;
                }
            </action>
            <action _init(getRdel)>
                {
                    return $this->parser->Rdel;
                }
            </action>
        </token>

    #
    # Tag attribute
    #
        <token SmartyTagAttributes>
            <rule>  ( _  (&'scope' scope:SmartyTagScopes) | (( name:Id _? '=' _?)? value:Expr))* </rule>
             <action _start>
            {
                $nodeRes['node'] = $previous['node'];
            }
            </action>
           <action name>
            {
                $nodeRes['name'] = strtolower($matchRes['_text']);
            }
            </action>
            <action value>
            {
                $nodeRes['node']->setTagAttribute(array(isset($nodeRes['name']) ? $nodeRes['name'] : null, $matchRes['node']));
            }
            </action>
            <action scope>
            {
                $nodeRes['node']->setTagAttribute(array('scope', $matchRes['node']));
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
                $nodeRes['node'] = $previous['node'];
            }
            </action>
           <action option>
            {
                $nodeRes['node']->setTagOption(strtolower($matchRes['_text']));
            }
            </action>
        </token>
    #
    # Tag scopes
    #
    #
        <token SmartyTagScopes>
            <attribute>expected=(literal=(parent,root,global))</attribute>
            <rule> 'scope' _? '=' _? /(?<scope>(parent|root|global))/ | error:Unexpected </rule>
            <action _start>
            {
                $nodeRes['node'] = new Node($this->parser, 'SmartyTagScopes');
            }
            </action>
           <action scope>
            {
                $nodeRes['node']->setValue(strtolower($matchRes['_pregMatch']['scope']));
            }
            </action>
           <action error>
            {
                $nodeRes['node']->addError($matchRes['error']);
            }
            </action>
        </token>

    #
    # Default tag syntax
    #
        <node Smarty_Tag_Default>
            <rule> Ldel Id SmartyTagAttributes SmartyTagOptions Rdel </rule>
            <action _start>
            {
                $nodeRes['node'] = $previous['node'];
            }
            </action>
            <action _finish>
            {
                $nodeRes['tagAttributes'] = array();
                if (isset($nodeRes['attrib'])) {
                    $nodeRes['tagAttributes'] = $nodeRes['attrib']['attrib'];
                    unset($nodeRes['attrib']);
                }
                $nodeRes['tagOptions'] = array();
                if (isset($nodeRes['options'])) {
                    $nodeRes['tagOptions'] = $nodeRes['options']['Options'];
                    unset($nodeRes['options']);
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

        <token SmartyTagPrefix>
            <attribute>matchall</attribute>
            # do not change! real left delimiter regular expression will be obtained by parser
            <rule>/({getLdel})(?<tagname>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* ))(?!(\s*\())/</rule>
            <action _init(getLdel)>
                {
                    return $this->parser->Ldel;
                }
            </action>
        </token>

        <token SmartyBlockCloseTag>
            <attribute>matchall</attribute>
            # do not change! real left delimiter regular expression will be obtained by parser
            <rule>/{getLdel}\/(?<name>[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* ){getRdel}/</rule>
            <action _init(getLdel)>
                {
                    return $this->parser->Ldel;
                }
            </action>
            <action _init(getRdel)>
                {
                    return $this->parser->Rdel;
                }
            </action>
        </token>


    </pegparser>

    */
}
