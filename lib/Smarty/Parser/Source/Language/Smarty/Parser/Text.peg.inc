<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Node;
use Smarty\Parser\Source\Shared\Node\InternalText;
use Smarty\PegParser;

/**
 * Class TextParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TextParser extends PegParser
{
    /*!*
    <pegparser Text>
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
