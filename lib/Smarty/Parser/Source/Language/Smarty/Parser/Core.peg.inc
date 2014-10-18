<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Node;
use Smarty\Parser\Source\Shared\Node\InternalText;
use Smarty\Parser\Peg\RuleRoot;

/**
 * Class CoreParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class CoreParser extends RuleRoot
{
    // TODO not used
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

    </pegparser>

    */
}
