<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\PegParser;

/**
 * Class UnexpectedParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class UnexpectedParser extends PegParser
{
    /*!*
    <pegparser Unexpected>
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
