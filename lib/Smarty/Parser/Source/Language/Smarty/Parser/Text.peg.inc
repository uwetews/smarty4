<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Node;
use Smarty\Parser\Source\Shared\Node\InternalText;
use Smarty\Parser\Peg\RuleRoot;

/**
 * Class TextParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TextParser extends RuleRoot
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
                if ($nodeRes['_text'] == '') {
                    $nodeRes = false;
                    return;
                }
                $nodeRes['node'] = new InternalText($this->parser);
                $nodeRes['node']->addText($nodeRes['_text'])->setTraceInfo($nodeRes['_lineno'], '', $nodeRes['_startpos'], $nodeRes['_endpos']);
                $nodeRes['_text'] = '';
                $nodeRes['_silent'] = 1;
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
