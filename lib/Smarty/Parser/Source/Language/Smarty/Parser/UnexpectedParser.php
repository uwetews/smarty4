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

    /**
     * Parser generated on 2014-08-11 03:30:47
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/Unexpected.peg.inc' dated 2014-08-11 03:28:54

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
        "Unexpected" => "matchNodeUnexpected"
    );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
        "Unexpected" => array(
            "_nodetype" => "token"
        )
    );

    /**
     * Parser rules and action for node 'Unexpected'
     *  Rule:
     * <token Unexpected>
     * <rule> &unexpected:/\s*[\S]+/ /\s*([\S])*?(?=(({getLdel})|({getRdel})))/ </rule>
     * <action unexpected>
     * {
     * $result['error'][] = array('type' => 'unexpected', 'value' => $subres['_text'], 'line' => $subres['_lineno'], 'pos' => $subres['_startpos']);
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
     * </token>


     */
    public function matchNodeUnexpected($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Unexpected' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        $error1 = $error;
        $this->parser->addBacktrace(array('_s1_', ''));
        do {
            $error = array();
            // Start '&unexpected:/\s*[\S]+/' tag 'unexpected' min '1' max '1' positive lookahead
            $backup2 = $result;
            $pos2 = $this->parser->pos;
            $line2 = $this->parser->line;
            $regexp = "/\\s*[\\S]+/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['Unexpected4'][$pos])) {
                $subres = $this->parser->regexpCache['Unexpected4'][$pos];
            } else {
                if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                    if ($subres['_startpos'] != $pos) {
                        $this->parser->regexpCache['Unexpected4'][$subres['_startpos']] = $subres;
                        $this->parser->regexpCache['Unexpected4'][$pos] = false;
                        $subres = false;
                    }
                } else {
                    $this->parser->regexpCache['Unexpected4'][$pos] = false;
                    $subres = false;
                }
            }
            if ($subres) {
                $subres['_lineno'] = $this->parser->line;
                $this->parser->pos = $subres['_endpos'];
                $this->parser->line += substr_count($subres['_text'], "\n");
                $subres['_tag'] = 'unexpected';
                $subres['_name'] = 'Unexpected';
                $valid = true;
            } else {
                $valid = false;
            }
            if ($valid) {
                $result['_text'] .= $subres['_text'];
                $this->Unexpected_unexpected($result, $subres);
            } else {
                $this->parser->matchError($error, 'rx', "/\\s*[\\S]+/");
            }
            $this->parser->pos = $pos2;
            $this->parser->line = $line2;
            $result = $backup2;
            unset($backup2);
            // End '&unexpected:/\s*[\S]+/'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start '/\s*([\S])*?(?=(({getLdel})|({getRdel})))/' min '1' max '1'
            $regexp = "/\\s*([\\S])*?(?=(({getLdel})|({getRdel})))/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['Unexpected6'][$pos])) {
                $subres = $this->parser->regexpCache['Unexpected6'][$pos];
            } else {
                if (isset($this->parser->rxCache['Unexpected6'])) {
                    $regexp = $this->parser->rxCache['Unexpected6'];
                } else {
                    $this->parser->rxCache['Unexpected6'] = $regexp = $this->parser->initRxReplace('Unexpected', $regexp);
                }
                if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                    if ($subres['_startpos'] != $pos) {
                        $this->parser->regexpCache['Unexpected6'][$subres['_startpos']] = $subres;
                        $this->parser->regexpCache['Unexpected6'][$pos] = false;
                        $subres = false;
                    }
                } else {
                    $this->parser->regexpCache['Unexpected6'][$pos] = false;
                    $subres = false;
                }
            }
            if ($subres) {
                $subres['_lineno'] = $this->parser->line;
                $this->parser->pos = $subres['_endpos'];
                $this->parser->line += substr_count($subres['_text'], "\n");
                $subres['_tag'] = false;
                $subres['_name'] = 'Unexpected';
                $valid = true;
            } else {
                $valid = false;
            }
            if ($valid) {
                $result['_text'] .= $subres['_text'];
            } else {
                $this->parser->matchError($error, 'rx', "/\\s*([\\S])*?(?=(({getLdel})|({getRdel})))/");
            }
            // End '/\s*([\S])*?(?=(({getLdel})|({getRdel})))/'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            break;
        } while (true);
        $remove = array_pop($this->parser->backtrace);
        if (!$valid) {
            $this->parser->failNode($remove);
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        } else {
            $this->parser->successNode($remove);
        }
        $error = $error1;
        unset($backup1);
        // end sequence
        // End 'Unexpected'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Unexpected');
        }
        return $result;
    }

    public function Unexpected_unexpected(&$result, $subres)
    {
        $result['error'][] = array('type' => 'unexpected', 'value' => $subres['_text'], 'line' => $subres['_lineno'], 'pos' => $subres['_startpos']);
    }

    public function Unexpected_INIT_getLdel(&$rule)
    {
        return $this->parser->Ldel;
    }

    public function Unexpected_INIT_getRdel(&$rule)
    {
        return $this->parser->Rdel;
    }
}
