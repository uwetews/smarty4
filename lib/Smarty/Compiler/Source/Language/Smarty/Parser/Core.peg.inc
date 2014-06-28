<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Node;
use Smarty\Compiler\Source\Shared\Node\InternalText;
use Smarty\PegParser;

/**
 * Class CoreParser
 *
 * @package Smarty\Compiler\Source\Language\Smarty\Parser
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


    </pegparser>

    */
}
