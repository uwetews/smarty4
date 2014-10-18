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
   
    /**
     *
     * Parser generated on 2014-09-04 02:35:37
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/Unexpected.peg.inc' dated 2014-08-22 04:53:53
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
            "Unexpected" => "matchNodeUnexpected"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array();
    /**
     *
     * Parser rules and actions for node 'Unexpected'
     *
     *  Rule:
     * 
     *         <token Unexpected>
     *             <rule> &unexpected:/\s*[\S]+/ /\s*([\S])*?(?=(({getLdel})|({getRdel})))/ </rule>
     *             <action unexpected>
     *             {
     *                 $nodeRes['error'][] = array('type' => 'unexpected', 'value' => $matchRes['_text'], 'line' => $matchRes['_lineno'], 'pos' => $matchRes['_startpos']);
     *             }
     *             </action>
     *              <action _init(getLdel)>
     *                 {
     *                     return $this->parser->Ldel;
     *                 }
     *             </action>
     *             <action _init(getRdel)>
     *                 {
     *                     return $this->parser->Rdel;
     *                 }
     *             </action>
     *        </token>
     * 
     *
    */
    public function matchNodeUnexpected($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        // start sequence
        $backup0 = $nodeRes;
        $pos0 = $this->parser->pos;
        $line0 = $this->parser->line;
        $error0 = $error;
        if ($trace) {
            $traceObj->addBacktrace(array('_s0_', ''));
        }
        do {
            $error = array();
            /*
             * Start rule: &unexpected:/\s*[\S]+/
             *       tag: 'unexpected'
             *       min: 1 max: 1
             *       look ahead: 'positive'
             */
            $backup1 = $nodeRes;
            $pos1 = $this->parser->pos;
            $line1 = $this->parser->line;
            $regexp = "/\\s*[\\S]+/";
            $pos = $this->parser->pos;
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
                $this->Unexpected_MATCH_unexpected($nodeRes, $matchRes);
                $valid = true;
            } else {
                $valid = false;
            }
            if (!$valid) {
                $this->parser->matchError($error, 'rx', "/\\s*[\\S]+/");
            }
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $nodeRes = $backup1;
            unset($backup1);
            /*
             * End rule: &unexpected:/\s*[\S]+/
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: /\s*([\S])*?(?=(({getLdel})|({getRdel})))/
             *       min: 1 max: 1
             */
            $regexp = "/\\s*([\\S])*?(?=(({getLdel})|({getRdel})))/";
            $pos = $this->parser->pos;
            if (isset($this->parser->rxCache['Rx_Unexpected4'])) {
                $regexp = $this->parser->rxCache['Rx_Unexpected4'];
            } else {
                $this->parser->rxCache['Rx_Unexpected4'] = $regexp = $this->parser->initRxReplace('Unexpected',$regexp);
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
                $this->parser->matchError($error, 'rx', "/\\s*([\\S])*?(?=(({getLdel})|({getRdel})))/");
            }
            /*
             * End rule: /\s*([\S])*?(?=(({getLdel})|({getRdel})))/
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            if ($trace) {
                $traceObj->failNode();
            }
            $this->parser->pos = $pos0;
            $this->parser->line = $line0;
            $nodeRes = $backup0;
        } elseif ($trace) {
            $traceObj->successNode();
        }
        $error = $error0;
        unset($backup0);
        // end sequence
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Unexpected');
        }
        return $nodeRes;
    }
    public function Unexpected_MATCH_unexpected (&$nodeRes, $matchRes)
    {
        $nodeRes['error'][] = array('type' => 'unexpected', 'value' => $matchRes['_text'], 'line' => $matchRes['_lineno'], 'pos' => $matchRes['_startpos']);
    }

    public function Unexpected_INIT_getLdel (&$rule)
    {
        return $this->parser->Ldel;
    }

    public function Unexpected_INIT_getRdel (&$rule)
    {
        return $this->parser->Rdel;
    }


}
