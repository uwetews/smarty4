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
   
    /**
     *
     * Parser generated on 2014-09-04 02:35:35
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/Text.peg.inc' dated 2014-08-22 04:53:52
     *
    */

    /**
     Flag that compiled Peg Parser class is valid
     *
     * @var bool
     */
    public $valid = true;


    /**
     * Array of match method names for rules of this Peg Parser
     *
     * @var array
     */
    public $ruleMethods = array(
            "Text" => "matchNodeText"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array();
    /**
     *
     * Parser rules and actions for node 'Text'
     *
     *  Rule:
     * 
     *         <node Text>
     *             # do not change! real left delimiter regular expression will be obtained by parser
     *             #
     *             # Get template text section
     *             # Also content between {literal} .. {/literal} tags is processed here
     *             #
     *             <rule>/({getLdel}\s*literal\s*{getRdel}.*?{getLdel}\/\s*literal\s*{getRdel})?(([\s\S])*?(?=({getLdel})))|[\S\s]+/</rule>
     *             <action _finish>
     *             {
     *                 if ($nodeRes['_text'] == '') {
     *                     $nodeRes = false;
     *                     return;
     *                 }
     *                 $nodeRes['node'] = new InternalText($this->parser);
     *                 $nodeRes['node']->addText($nodeRes['_text'])->setTraceInfo($nodeRes['_lineno'], '', $nodeRes['_startpos'], $nodeRes['_endpos']);
     *                 $nodeRes['_text'] = '';
     *                 $nodeRes['_silent'] = 1;
     *             }
     *             </action>
     *             <action _init(getLdel)>
     *                 {
     *                     return $this->parser->Ldel;
     *                 }
     *             </action>
     *             <action _init(getRdel)>
     *                 {
     *                     return $this->parser->Rdel;
     *                 }
     *             </action>
     *         </node>
     * 
     *
    */
    public function matchNodeText($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        /*
         * Start rule: /({getLdel}\s*literal\s*{getRdel}.*?{getLdel}\/\s*literal\s*{getRdel})?(([\s\S])*?(?=({getLdel})))|[\S\s]+/
         *       min: 1 max: 1
         */
        $regexp = "/({getLdel}\\s*literal\\s*{getRdel}.*?{getLdel}\\/\\s*literal\\s*{getRdel})?(([\\s\\S])*?(?=({getLdel})))|[\\S\\s]+/";
        $pos = $this->parser->pos;
        if (isset($this->parser->rxCache['Rx_Text1'])) {
            $regexp = $this->parser->rxCache['Rx_Text1'];
        } else {
            $this->parser->rxCache['Rx_Text1'] = $regexp = $this->parser->initRxReplace('Text',$regexp);
        }
        if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos) && (strlen($pregMatch[0][0]) || (isset($pregMatch[1]) && strlen($pregMatch[1][0])))) {
            $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
            if ($matchRes['_startpos'] != $pos) {
                $matchRes = false;
            }
        } else {
            $matchRes = false;
        }
        if ($matchRes) {
            $matchRes['_lineno'] = $this->parser->line;
            $this->parser->pos = $matchRes['_endpos'];
            $this->parser->line += substr_count($matchRes['_text'], "\n");
            $nodeRes['_text'] .= $matchRes['_text'];
            $valid = true;
        } else {
            $valid = false;
        }
        if (!$valid) {
            $this->parser->matchError($error, 'rx', "/({getLdel}\\s*literal\\s*{getRdel}.*?{getLdel}\\/\\s*literal\\s*{getRdel})?(([\\s\\S])*?(?=({getLdel})))|[\\S\\s]+/");
        }
        /*
         * End rule: /({getLdel}\s*literal\s*{getRdel}.*?{getLdel}\/\s*literal\s*{getRdel})?(([\s\S])*?(?=({getLdel})))|[\S\s]+/
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
            $this->Text_FINISH($nodeRes);
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Text');
        }
        return $nodeRes;
    }
    public function Text_FINISH (&$nodeRes)
    {
        if ($nodeRes['_text'] == '')        {
            $nodeRes = false;
            return;
        }
        $nodeRes['node'] = new InternalText($this->parser);
        $nodeRes['node']->addText($nodeRes['_text'])->setTraceInfo($nodeRes['_lineno'], '', $nodeRes['_startpos'], $nodeRes['_endpos']);
        $nodeRes['_text'] = '';
        $nodeRes['_silent'] = 1;
    }

    public function Text_INIT_getLdel (&$rule)
    {
        return $this->parser->Ldel;
    }

    public function Text_INIT_getRdel (&$rule)
    {
        return $this->parser->Rdel;
    }


}
