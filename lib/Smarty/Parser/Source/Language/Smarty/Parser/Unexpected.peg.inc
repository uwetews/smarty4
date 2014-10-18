<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Peg\RuleRoot;

/**
 * Class UnexpectedParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class UnexpectedParser extends RuleRoot
{
    /*!*
    <pegparser Unexpected>
        <token Unexpected>
            <rule> &unexpected:/\s*[\S]+/ /\s*([\S])*?(?=(({getLdel})|({getRdel})))/ </rule>
            <action unexpected>
            {
                $nodeRes['error'][] = array('type' => 'unexpected', 'value' => $matchRes['_text'], 'line' => $matchRes['_lineno'], 'pos' => $matchRes['_startpos']);
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
