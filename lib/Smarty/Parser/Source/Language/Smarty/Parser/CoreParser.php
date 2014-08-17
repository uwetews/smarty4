<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Node;
use Smarty\Parser\Source\Shared\Node\InternalText;
use Smarty\PegParser;

/**
 * Class CoreParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class CoreParser extends PegParser
{

    /**
     * Parser generated on 2014-08-11 03:30:47
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/Core.peg.inc' dated 2014-08-11 03:30:44

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
        "Ldel"      => "matchNodeLdel",
        "LdelSlash" => "matchNodeLdelSlash",
        "Rdel"      => "matchNodeRdel"
    );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
        "Ldel"      => array(
            "_nodetype" => "token",
            "matchall"  => true
        ),
        "LdelSlash" => array(
            "_nodetype" => "token",
            "matchall"  => true
        ),
        "Rdel"      => array(
            "_nodetype" => "token",
            "matchall"  => true
        )
    );

    /**
     * Parser rules and action for node 'Ldel'
     *  Rule:
     * <token Ldel>
     * <attribute>matchall</attribute>
     * # do not change! real left delimiter regular expression will be obtained by parser
     * <rule>/{getLdel}/</rule>
     * <action _init(getLdel)>
     * {
     * return $this->parser->Ldel;
     * }
     * </action>
     * </token>


     */
    public function matchNodeLdel($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/{getLdel}/' min '1' max '1'
        $regexp = "/{getLdel}/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Ldel2'][$pos])) {
            $subres = $this->parser->regexpCache['Ldel2'][$pos];
        } else {
            if (isset($this->parser->rxCache['Ldel2'])) {
                $regexp = $this->parser->rxCache['Ldel2'];
            } else {
                $this->parser->rxCache['Ldel2'] = $regexp = $this->parser->initRxReplace('Ldel', $regexp);
            }
            if (empty($this->parser->regexpCache['Ldel2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE + PREG_SET_ORDER, $pos)) {
                $this->parser->regexpCache['Ldel2'][- 1] = true;
                foreach ($matches as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                    $this->parser->regexpCache['Ldel2'][$match[0][1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['Ldel2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['Ldel2'][$pos])) {
            $subres = $this->parser->regexpCache['Ldel2'][$pos];
        } else {
            $this->parser->regexpCache['Ldel2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Ldel';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        } else {
            $this->parser->matchError($error, 'rx', "/{getLdel}/");
        }
        // End '/{getLdel}/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Ldel');
        }
        return $result;
    }

    public function Ldel_INIT_getLdel(&$rule)
    {
        return $this->parser->Ldel;
    }

    /**
     * Parser rules and action for node 'LdelSlash'
     *  Rule:
     * <token LdelSlash>
     * <attribute>matchall</attribute>
     * # do not change! real left delimiter regular expression will be obtained by parser
     * <rule>/{getLdel}\//</rule>
     * <action _init(getLdel)>
     * {
     * return $this->parser->Ldel;
     * }
     * </action>
     * </token>


     */
    public function matchNodeLdelSlash($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/{getLdel}\//' min '1' max '1'
        $regexp = "/{getLdel}\\//";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['LdelSlash2'][$pos])) {
            $subres = $this->parser->regexpCache['LdelSlash2'][$pos];
        } else {
            if (isset($this->parser->rxCache['LdelSlash2'])) {
                $regexp = $this->parser->rxCache['LdelSlash2'];
            } else {
                $this->parser->rxCache['LdelSlash2'] = $regexp = $this->parser->initRxReplace('LdelSlash', $regexp);
            }
            if (empty($this->parser->regexpCache['LdelSlash2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE + PREG_SET_ORDER, $pos)) {
                $this->parser->regexpCache['LdelSlash2'][- 1] = true;
                foreach ($matches as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                    $this->parser->regexpCache['LdelSlash2'][$match[0][1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['LdelSlash2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['LdelSlash2'][$pos])) {
            $subres = $this->parser->regexpCache['LdelSlash2'][$pos];
        } else {
            $this->parser->regexpCache['LdelSlash2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'LdelSlash';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        } else {
            $this->parser->matchError($error, 'rx', "/{getLdel}\\//");
        }
        // End '/{getLdel}\//'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'LdelSlash');
        }
        return $result;
    }

    public function LdelSlash_INIT_getLdel(&$rule)
    {
        return $this->parser->Ldel;
    }

    /**
     * Parser rules and action for node 'Rdel'
     *  Rule:
     * <token Rdel>
     * <attribute>matchall</attribute>
     * # do not change! real left delimiter regular expression will be obtained by parser
     * <rule>/\s*{getRdel}/</rule>
     * <action _init(getRdel)>
     * {
     * return $this->parser->Rdel;
     * }
     * </action>
     * </token>


     */
    public function matchNodeRdel($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\s*{getRdel}/' min '1' max '1'
        $regexp = "/\\s*{getRdel}/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Rdel2'][$pos])) {
            $subres = $this->parser->regexpCache['Rdel2'][$pos];
        } else {
            if (isset($this->parser->rxCache['Rdel2'])) {
                $regexp = $this->parser->rxCache['Rdel2'];
            } else {
                $this->parser->rxCache['Rdel2'] = $regexp = $this->parser->initRxReplace('Rdel', $regexp);
            }
            if (empty($this->parser->regexpCache['Rdel2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE + PREG_SET_ORDER, $pos)) {
                $this->parser->regexpCache['Rdel2'][- 1] = true;
                foreach ($matches as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                    $this->parser->regexpCache['Rdel2'][$match[0][1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['Rdel2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['Rdel2'][$pos])) {
            $subres = $this->parser->regexpCache['Rdel2'][$pos];
        } else {
            $this->parser->regexpCache['Rdel2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Rdel';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        } else {
            $this->parser->matchError($error, 'rx', "/\\s*{getRdel}/");
        }
        // End '/\s*{getRdel}/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Rdel');
        }
        return $result;
    }

    public function Rdel_INIT_getRdel(&$rule)
    {
        return $this->parser->Rdel;
    }
}
