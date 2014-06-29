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

   
    /**
     *
     * Parser generated on 2014-06-29 20:33:10
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Shared/Parser/Core.peg.inc' dated 2014-06-28 02:53:31
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
    public $matchMethods = array(
            "Id" => "matchNodeId",
            "Attr" => "matchNodeAttr",
            "OpenP" => "matchNodeOpenP",
            "OpenB" => "matchNodeOpenB",
            "OpenC" => "matchNodeOpenC",
            "CloseP" => "matchNodeCloseP",
            "CloseB" => "matchNodeCloseB",
            "CloseC" => "matchNodeCloseC",
            "Dollar" => "matchNodeDollar",
            "Hatch" => "matchNodeHatch",
            "Comma" => "matchNodeComma",
            "Ptr" => "matchNodePtr",
            "Unexpected" => "matchNodeUnexpected"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "Id" => array(
                    "_nodetype" => "token"
                ),
            "Attr" => array(
                    "_nodetype" => "token"
                ),
            "OpenP" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "OpenB" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "OpenC" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "CloseP" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "CloseB" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "CloseC" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "Dollar" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "Hatch" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "Comma" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "Ptr" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "Unexpected" => array(
                    "_nodetype" => "token"
                )
        );
    /**
     *
     * Parser rules and action for node 'Id'
     *
     *  Rule:
    

        <token Id>
            <rule>/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* /</rule>
         </token>

     *
    */
    public function matchNodeId($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* /' min '1' max '1'
        $regexp = "/[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]* /";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Id2'][$pos])) {
            $subres = $this->parser->regexpCache['Id2'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                if ($subres['_startpos'] != $pos) {
                    $this->parser->regexpCache['Id2'][$subres['_startpos']] = $subres;
                    $this->parser->regexpCache['Id2'][$pos] = false;
                    $subres = false;
                }
            } else {
                $this->parser->regexpCache['Id2'][$pos] = false;
                $subres = false;
            }
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Id';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* /'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'Attr'
     *
     *  Rule:
    <token Attr>
            <rule>/[\S]+/</rule>
         </token>

     *
    */
    public function matchNodeAttr($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/[\S]+/' min '1' max '1'
        $regexp = "/[\\S]+/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Attr2'][$pos])) {
            $subres = $this->parser->regexpCache['Attr2'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                if ($subres['_startpos'] != $pos) {
                    $this->parser->regexpCache['Attr2'][$subres['_startpos']] = $subres;
                    $this->parser->regexpCache['Attr2'][$pos] = false;
                    $subres = false;
                }
            } else {
                $this->parser->regexpCache['Attr2'][$pos] = false;
                $subres = false;
            }
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Attr';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/[\S]+/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'OpenP'
     *
     *  Rule:
    <token OpenP>
            <attribute>matchall</attribute>
            <rule>/\s*\(\s* /</rule>
         </token>

     *
    */
    public function matchNodeOpenP($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\s*\(\s* /' min '1' max '1'
        $regexp = "/\\s*\\(\\s* /";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['OpenP2'][$pos])) {
            $subres = $this->parser->regexpCache['OpenP2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['OpenP2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['OpenP2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['OpenP2'][$match[1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['OpenP2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['OpenP2'][$pos])) {
            $subres = $this->parser->regexpCache['OpenP2'][$pos];
        } else {
            $this->parser->regexpCache['OpenP2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'OpenP';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/\s*\(\s* /'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'OpenB'
     *
     *  Rule:
    <token OpenB>
            <attribute>matchall</attribute>
            <rule>/\s*\[\s* /</rule>
         </token>

     *
    */
    public function matchNodeOpenB($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\s*\[\s* /' min '1' max '1'
        $regexp = "/\\s*\\[\\s* /";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['OpenB2'][$pos])) {
            $subres = $this->parser->regexpCache['OpenB2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['OpenB2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['OpenB2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['OpenB2'][$match[1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['OpenB2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['OpenB2'][$pos])) {
            $subres = $this->parser->regexpCache['OpenB2'][$pos];
        } else {
            $this->parser->regexpCache['OpenB2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'OpenB';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/\s*\[\s* /'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'OpenC'
     *
     *  Rule:
    <token OpenC>
            <attribute>matchall</attribute>
            <rule>/\{\s* /</rule>
         </token>

     *
    */
    public function matchNodeOpenC($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\{\s* /' min '1' max '1'
        $regexp = "/\\{\\s* /";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['OpenC2'][$pos])) {
            $subres = $this->parser->regexpCache['OpenC2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['OpenC2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['OpenC2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['OpenC2'][$match[1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['OpenC2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['OpenC2'][$pos])) {
            $subres = $this->parser->regexpCache['OpenC2'][$pos];
        } else {
            $this->parser->regexpCache['OpenC2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'OpenC';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/\{\s* /'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'CloseP'
     *
     *  Rule:
    <token CloseP>
            <attribute>matchall</attribute>
            <rule>/\s*\)\s* /</rule>
         </token>

     *
    */
    public function matchNodeCloseP($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\s*\)\s* /' min '1' max '1'
        $regexp = "/\\s*\\)\\s* /";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['CloseP2'][$pos])) {
            $subres = $this->parser->regexpCache['CloseP2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['CloseP2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['CloseP2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['CloseP2'][$match[1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['CloseP2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['CloseP2'][$pos])) {
            $subres = $this->parser->regexpCache['CloseP2'][$pos];
        } else {
            $this->parser->regexpCache['CloseP2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'CloseP';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/\s*\)\s* /'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'CloseB'
     *
     *  Rule:
    <token CloseB>
            <attribute>matchall</attribute>
            <rule>/\s*\}/</rule>
         </token>

     *
    */
    public function matchNodeCloseB($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\s*\}/' min '1' max '1'
        $regexp = "/\\s*\\}/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['CloseB2'][$pos])) {
            $subres = $this->parser->regexpCache['CloseB2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['CloseB2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['CloseB2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['CloseB2'][$match[1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['CloseB2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['CloseB2'][$pos])) {
            $subres = $this->parser->regexpCache['CloseB2'][$pos];
        } else {
            $this->parser->regexpCache['CloseB2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'CloseB';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/\s*\}/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'CloseC'
     *
     *  Rule:
    <token CloseC>
            <attribute>matchall</attribute>
            <rule>/\s*\}/</rule>
         </token>

     *
    */
    public function matchNodeCloseC($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\s*\}/' min '1' max '1'
        $regexp = "/\\s*\\}/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['CloseC2'][$pos])) {
            $subres = $this->parser->regexpCache['CloseC2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['CloseC2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['CloseC2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['CloseC2'][$match[1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['CloseC2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['CloseC2'][$pos])) {
            $subres = $this->parser->regexpCache['CloseC2'][$pos];
        } else {
            $this->parser->regexpCache['CloseC2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'CloseC';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/\s*\}/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'Dollar'
     *
     *  Rule:
    <token Dollar>
            <attribute>matchall</attribute>
            <rule>/\$/</rule>
        </token>

     *
    */
    public function matchNodeDollar($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\$/' min '1' max '1'
        $regexp = "/\\$/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Dollar2'][$pos])) {
            $subres = $this->parser->regexpCache['Dollar2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['Dollar2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['Dollar2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['Dollar2'][$match[1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['Dollar2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['Dollar2'][$pos])) {
            $subres = $this->parser->regexpCache['Dollar2'][$pos];
        } else {
            $this->parser->regexpCache['Dollar2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Dollar';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/\$/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'Hatch'
     *
     *  Rule:
    <token Hatch>
            <attribute>matchall</attribute>
            <rule>/#/</rule>
        </token>

     *
    */
    public function matchNodeHatch($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/#/' min '1' max '1'
        $regexp = "/#/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Hatch2'][$pos])) {
            $subres = $this->parser->regexpCache['Hatch2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['Hatch2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['Hatch2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['Hatch2'][$match[1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['Hatch2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['Hatch2'][$pos])) {
            $subres = $this->parser->regexpCache['Hatch2'][$pos];
        } else {
            $this->parser->regexpCache['Hatch2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Hatch';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/#/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'Comma'
     *
     *  Rule:
    <token Comma>
            <attribute>matchall</attribute>
            <rule>/\s*,\s* /</rule>
        </token>

     *
    */
    public function matchNodeComma($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\s*,\s* /' min '1' max '1'
        $regexp = "/\\s*,\\s* /";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Comma2'][$pos])) {
            $subres = $this->parser->regexpCache['Comma2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['Comma2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['Comma2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['Comma2'][$match[1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['Comma2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['Comma2'][$pos])) {
            $subres = $this->parser->regexpCache['Comma2'][$pos];
        } else {
            $this->parser->regexpCache['Comma2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Comma';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/\s*,\s* /'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'Ptr'
     *
     *  Rule:
    <token Ptr>
            <attribute>matchall</attribute>
            <rule>/->/</rule>
        </token>

     *
    */
    public function matchNodePtr($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/->/' min '1' max '1'
        $regexp = "/->/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Ptr2'][$pos])) {
            $subres = $this->parser->regexpCache['Ptr2'][$pos];
        } else {
            if (empty($this->parser->regexpCache['Ptr2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['Ptr2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]), '_matchres' => array());
                    $this->parser->regexpCache['Ptr2'][$match[1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['Ptr2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['Ptr2'][$pos])) {
            $subres = $this->parser->regexpCache['Ptr2'][$pos];
        } else {
            $this->parser->regexpCache['Ptr2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Ptr';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End '/->/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     *
     * Parser rules and action for node 'Unexpected'
     *
     *  Rule:
    <token Unexpected>
            <rule> /[\s\S]{1,30}/ </rule>
            <action _finish>

                {
                    $this->parserContext->compiler->error("unexpected '{$result['text']}'", $this->parserContext->line, $this);
                    }


            </action>
        </token>

     *
    */
    public function matchNodeUnexpected($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/[\s\S]{1,30}/' min '1' max '1'
        $regexp = "/[\\s\\S]{1,30}/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Unexpected2'][$pos])) {
            $subres = $this->parser->regexpCache['Unexpected2'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                if ($subres['_startpos'] != $pos) {
                    $this->parser->regexpCache['Unexpected2'][$subres['_startpos']] = $subres;
                    $this->parser->regexpCache['Unexpected2'][$pos] = false;
                    $subres = false;
                }
            } else {
                $this->parser->regexpCache['Unexpected2'][$pos] = false;
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
        }
        // End '/[\s\S]{1,30}/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Unexpected___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Unexpected___FINISH (&$result) {
        $this->parserContext->compiler->error("unexpected '{$result['text']}'", $this->parserContext->line, $this);
    }



}

