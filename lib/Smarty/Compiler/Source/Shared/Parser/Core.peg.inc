<?php
namespace Smarty\Compiler\Source\Shared\Parser;

use Smarty\Node;
use Smarty\PegParser;

/**
 * Class CoreParser
 *
 * @package Smarty\Compiler\Source\Shared\Parser
 */
class CoreParser extends PegParser
{

    /*!*
    <pegparser Core>

        <token Id>
            <rule>/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* /</rule>
         </token>

        <token Attr>
            <rule>/[\S]+/</rule>
         </token>

        <token OpenP>
            <attribute>matchall</attribute>
            <rule>/\s*\(\s* /</rule>
         </token>

        <token OpenB>
            <attribute>matchall</attribute>
            <rule>/\s*\[\s* /</rule>
         </token>

        <token OpenC>
            <attribute>matchall</attribute>
            <rule>/\{\s* /</rule>
         </token>

         <token CloseP>
            <attribute>matchall</attribute>
            <rule>/\s*\)\s* /</rule>
         </token>

        <token CloseB>
            <attribute>matchall</attribute>
            <rule>/\s*\}/</rule>
         </token>

        <token CloseC>
            <attribute>matchall</attribute>
            <rule>/\s*\}/</rule>
         </token>
           <token Dollar>
            <attribute>matchall</attribute>
            <rule>/\$/</rule>
        </token>

        <token Hatch>
            <attribute>matchall</attribute>
            <rule>/#/</rule>
        </token>

        <token Comma>
            <attribute>matchall</attribute>
            <rule>/\s*,\s* /</rule>
        </token>

        <token Ptr>
            <attribute>matchall</attribute>
            <rule>/->/</rule>
        </token>

        <token Unexpected>
            <rule> /[\s\S]{1,30}/ </rule>
            <action _finish>

                {
                    $this->parserContext->compiler->error("unexpected '{$result['text']}'", $this->parserContext->line, $this);
                    }


            </action>
        </token>

    </pegparser>
    */
}

