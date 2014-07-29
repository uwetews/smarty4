<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Node;
use Smarty\Parser\Source\Shared\Node\InternalText;
use Smarty\PegParser;

/**
 * Class CoreParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class CoreParser extends PegParser
{
    /*!*
    <pegparser Core>
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

        <node Text>
            # do not change! real left delimiter regular expression will be obtained by parser
            #
            # Get template text section
            # Also content between {literal} .. {/literal} tags is processed here
            #
            <rule>/({getLdel}\s*literal\s*{getRdel}.*?{getLdel}\/\s*literal\s*{getRdel})?(([\s\S])*?(?=({getLdel})))|[\S\s]+/</rule>
            <action _finish>
            {
                if ($result['_text'] == '') {
                    $result = false;
                    return;
                }
                $result['node'] = new InternalText($this->parser);
                $result['node']->addText($result['_text'])->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                $result['_text'] = '';
                $result['_silent'] = 1;
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
        </node>
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
            <rule> ( tagname:SmartyTagPrefix tag:$SmartyTag) | ( !SmartyTagPrefix ( tag:TagOutput | tag:TagStatement )) </rule>
            <action _start>
            {
                $i = 1;
            }
            </action>
             <action _expression(SmartyTag)>
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
            <action tagname>
                {
                    $result['tagname'] = $subres['_matchres']['tagname'];
                    $result['savedstartpos'] = $subres['_startpos'];
                    $result['savedline'] = $subres['_lineno'];
                }
            </action>
        </token>

    #
    # Tag attribute
    #
    #           -> named                           ->shorttag
        <token SmartyTagAttributes>
            <rule>  ( _  (&'scope' scope:SmartyTagScopes) | (( name:Id _? '=' _?)? value:Expr))* </rule>
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
            <action scope>
            {
                $result['node']->setTagAttribute(array('scope', $subres['node']));
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
            <attribute>expected=(literal=(parent,root,global))</attribute>
            <rule> 'scope' _? '=' _? /(?<scope>(parent|root|global))/ | error:Unexpected </rule>
            <action _start>
            {
                $result['node'] = new Node($this->parser, 'SmartyTagScopes');
            }
            </action>
           <action scope>
            {
                $result['node']->setValue(strtolower($subres['_matchres']['scope']));
            }
            </action>
           <action error>
            {
                $result['node']->addError($subres['error']);
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


        <token Unexpected>
            <rule> &unexpected:/\s*[\S]+/ /\s*([\S])*?(?=(({getLdel})|({getRdel})))/ </rule>
            <action unexpected>
            {
                $result['error'][] = array('type' => 'unexpected', 'value' => $subres['_text'], 'line' => $subres['_lineno'], 'pos' => $subres['_startpos']);
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

    </pegparser>

    */
}
