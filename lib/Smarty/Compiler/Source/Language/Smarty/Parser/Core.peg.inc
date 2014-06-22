<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Nodes;
use Smarty\Compiler\Source\Shared\Nodes\InternalText;

/**
 * Class PegParser
 *
 * @package Smarty\Source\Smarty\Nodes\Smarty
 */
class CoreParser
{
    /*!*
    <pegparser Core>
        <token Ldel>
            <attribute>matchall</attribute>
            # do not change! real left delimiter regular expression will be obtained by parser
            <rule>/{getLdel}/</rule>
            <action _init(getLdel)>
                {
                    return $rule->parser->Ldel;
                }
            </action>
        </token>

        <token LdelSlash>
            <attribute>matchall</attribute>
            # do not change! real left delimiter regular expression will be obtained by parser
            <rule>/{getLdel}\//</rule>
            <action _init(getLdel)>
                {
                    return $rule->parser->Ldel;
                }
            </action>
        </token>

        <token Rdel>
            <attribute>matchall</attribute>
            # do not change! real left delimiter regular expression will be obtained by parser
            <rule>/\s*{getRdel}/</rule>
            <action _init(getRdel)>
                {
                    return $rule->parser->Rdel;
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
                $result['node'] = new InternalText($result['_parser']);
                $result['node']->addText($result['_text'])->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                $result['_text'] = '';
                $result['_silent'] = 1;
            }
            </action>
            <action _init(getLdel)>
                {
                    return $rule->parser->Ldel;
                }
            </action>
            <action _init(getRdel)>
                {
                    return $rule->parser->Rdel;
                }
            </action>
        </node>


    </pegparser>

    */
}
