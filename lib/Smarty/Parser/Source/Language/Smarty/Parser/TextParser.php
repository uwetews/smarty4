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

    /**
     * Parser generated on 2014-08-11 03:30:47
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/Text.peg.inc' dated 2014-08-11 03:30:44

     */

    /**
     * Flag that compiled Peg Parser class is valid
     * @var bool
     */
    public $valid = true;

    /**
     * Array of match method names for rules of this Peg Parser
     *
     * @var array
     */
    public $matchMethods = array(
        "Text" => "matchNodeText"
    );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
        "Text" => array(
            "_nodetype" => "node"
        )
    );

    /**
     * Parser rules and action for node 'Text'
     *  Rule:
     * <node Text>
     * # do not change! real left delimiter regular expression will be obtained by parser
     * #
     * # Get template text section
     * # Also content between {literal} .. {/literal} tags is processed here
     * #
     * <rule>/({getLdel}\s*literal\s*{getRdel}.*?{getLdel}\/\s*literal\s*{getRdel})?(([\s\S])*?(?=({getLdel})))|[\S\s]+/</rule>
     * <action _finish>
     * {
     * if ($result['_text'] == '') {
     * $result = false;
     * return;
     * }
     * $result['node'] = new InternalText($this->parser);
     * $result['node']->addText($result['_text'])->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
     * $result['_text'] = '';
     * $result['_silent'] = 1;
     * }
     * </action>
     * <action _init(getLdel)>
     * {
     * return $this->parser->Ldel;
     * }
     * </action>
     * <action _init(getRdel)>
     * {
     * return $this->parser->Rdel;
     * }
     * </action>
     * </node>


     */
    public function matchNodeText($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/({getLdel}\s*literal\s*{getRdel}.*?{getLdel}\/\s*literal\s*{getRdel})?(([\s\S])*?(?=({getLdel})))|[\S\s]+/' min '1' max '1'
        $regexp = "/({getLdel}\\s*literal\\s*{getRdel}.*?{getLdel}\\/\\s*literal\\s*{getRdel})?(([\\s\\S])*?(?=({getLdel})))|[\\S\\s]+/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Text2'][$pos])) {
            $subres = $this->parser->regexpCache['Text2'][$pos];
        } else {
            if (isset($this->parser->rxCache['Text2'])) {
                $regexp = $this->parser->rxCache['Text2'];
            } else {
                $this->parser->rxCache['Text2'] = $regexp = $this->parser->initRxReplace('Text', $regexp);
            }
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                if ($subres['_startpos'] != $pos) {
                    $this->parser->regexpCache['Text2'][$subres['_startpos']] = $subres;
                    $this->parser->regexpCache['Text2'][$pos] = false;
                    $subres = false;
                }
            } else {
                $this->parser->regexpCache['Text2'][$pos] = false;
                $subres = false;
            }
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Text';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        } else {
            $this->parser->matchError($error, 'rx', "/({getLdel}\\s*literal\\s*{getRdel}.*?{getLdel}\\/\\s*literal\\s*{getRdel})?(([\\s\\S])*?(?=({getLdel})))|[\\S\\s]+/");
        }
        // End '/({getLdel}\s*literal\s*{getRdel}.*?{getLdel}\/\s*literal\s*{getRdel})?(([\s\S])*?(?=({getLdel})))|[\S\s]+/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Text___FINISH($result);
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Text');
        }
        return $result;
    }

    public function Text___FINISH(&$result)
    {
        if ($result['_text'] == '') {
            $result = false;
            return;
        }
        $result['node'] = new InternalText($this->parser);
        $result['node']->addText($result['_text'])
                       ->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
        $result['_text'] = '';
        $result['_silent'] = 1;
    }

    public function Text_INIT_getLdel(&$rule)
    {
        return $this->parser->Ldel;
    }

    public function Text_INIT_getRdel(&$rule)
    {
        return $this->parser->Rdel;
    }
}
