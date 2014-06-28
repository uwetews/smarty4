<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Node;
use Smarty\Compiler\Source\Shared\Node\InternalText;
use Smarty\PegParser;

/**
 * Class CoreParser
 *
 * @package Smarty\Compiler\Source\Language\Smarty\Parser
 */
class CoreParser extends PegParser
{
   
    /**
     *
     * Parser generated on 2014-06-28 11:26:33
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/Core.peg.inc' dated 2014-06-28 02:53:31
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
            "Ldel" => "matchNodeLdel",
            "LdelSlash" => "matchNodeLdelSlash",
            "Rdel" => "matchNodeRdel",
            "Text" => "matchNodeText"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "Ldel" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "LdelSlash" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "Rdel" => array(
                    "_nodetype" => "token",
                    "matchall" => true
                ),
            "Text" => array(
                    "_nodetype" => "node"
                )
        );
    /**
     *
     * Parser rules and action for node 'Ldel'
     *
     *  Rule:
     <token Ldel> <attribute> matchall </attribute>  <rule>  /{getLdel}/ </rule>  <action _init(getLdel)> {
                    return $this->parser->Ldel;
                } </action> </token> 
     *
    */
    public function matchNodeLdel($previous){
        $result = $this->parser->resultDefault;
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
                $this->parser->rxCache['Ldel2'] = $regexp = $this->parser->initRxReplace('Ldel',$regexp);
            }
            if (empty($this->parser->regexpCache['Ldel2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['Ldel2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]));
                    foreach ($match as $n => $v) {
                        if (is_string($n)) {
                            $subres['_matchres'][$n] = $v[0];
                        }
                    }
                    $this->parser->regexpCache['Ldel2'][$match[1]] = $subres;
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
        }
        // End '/{getLdel}/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Ldel_INIT_getLdel (&$rule) {
        return $this->parser->Ldel;
    }


    /**
     *
     * Parser rules and action for node 'LdelSlash'
     *
     *  Rule:
     <token LdelSlash> <attribute> matchall </attribute>  <rule>  /{getLdel}\// </rule>  <action _init(getLdel)> {
                    return $this->parser->Ldel;
                } </action> </token> 
     *
    */
    public function matchNodeLdelSlash($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/{getLdel}\//' min '1' max '1'
        $regexp = "/{getLdel}\//";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['LdelSlash2'][$pos])) {
            $subres = $this->parser->regexpCache['LdelSlash2'][$pos];
        } else {
            if (isset($this->parser->rxCache['LdelSlash2'])) {
                $regexp = $this->parser->rxCache['LdelSlash2'];
            } else {
                $this->parser->rxCache['LdelSlash2'] = $regexp = $this->parser->initRxReplace('LdelSlash',$regexp);
            }
            if (empty($this->parser->regexpCache['LdelSlash2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['LdelSlash2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]));
                    foreach ($match as $n => $v) {
                        if (is_string($n)) {
                            $subres['_matchres'][$n] = $v[0];
                        }
                    }
                    $this->parser->regexpCache['LdelSlash2'][$match[1]] = $subres;
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
        }
        // End '/{getLdel}\//'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function LdelSlash_INIT_getLdel (&$rule) {
        return $this->parser->Ldel;
    }


    /**
     *
     * Parser rules and action for node 'Rdel'
     *
     *  Rule:
     <token Rdel> <attribute> matchall </attribute>  <rule>  /\s*{getRdel}/ </rule>  <action _init(getRdel)> {
                    return $this->parser->Rdel;
                } </action> </token> 
     *
    */
    public function matchNodeRdel($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/\s*{getRdel}/' min '1' max '1'
        $regexp = "/\s*{getRdel}/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Rdel2'][$pos])) {
            $subres = $this->parser->regexpCache['Rdel2'][$pos];
        } else {
            if (isset($this->parser->rxCache['Rdel2'])) {
                $regexp = $this->parser->rxCache['Rdel2'];
            } else {
                $this->parser->rxCache['Rdel2'] = $regexp = $this->parser->initRxReplace('Rdel',$regexp);
            }
            if (empty($this->parser->regexpCache['Rdel2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE, $pos)) {
                $this->parser->regexpCache['Rdel2'][- 1] = true;
                foreach ($matches[0] as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0], '_startpos' => $match[1], '_endpos' => $match[1] + strlen($match[0]));
                    foreach ($match as $n => $v) {
                        if (is_string($n)) {
                            $subres['_matchres'][$n] = $v[0];
                        }
                    }
                    $this->parser->regexpCache['Rdel2'][$match[1]] = $subres;
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
        }
        // End '/\s*{getRdel}/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Rdel_INIT_getRdel (&$rule) {
        return $this->parser->Rdel;
    }


    /**
     *
     * Parser rules and action for node 'Text'
     *
     *  Rule:
     <node Text> <rule>  /({getLdel}\s*literal\s*{getRdel}.*?{getLdel}\/\s*literal\s*{getRdel})?(([\s\S])*?(?=({getLdel})))|[\S\s]+/ </rule>  <action _finish> {
                if ($result['_text'] == '') {
                    $result = false;
                    return;
                }
                $result['node'] = new InternalText($this->parser);
                $result['node']->addText($result['_text'])->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                $result['_text'] = '';
                $result['_silent'] = 1;
            } </action>  <action _init(getLdel)> {
                    return $this->parser->Ldel;
                } </action>  <action _init(getRdel)> {
                    return $this->parser->Rdel;
                } </action> </node> 
     *
    */
    public function matchNodeText($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/({getLdel}\s*literal\s*{getRdel}.*?{getLdel}\/\s*literal\s*{getRdel})?(([\s\S])*?(?=({getLdel})))|[\S\s]+/' min '1' max '1'
        $regexp = "/({getLdel}\s*literal\s*{getRdel}.*?{getLdel}\/\s*literal\s*{getRdel})?(([\s\S])*?(?=({getLdel})))|[\S\s]+/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Text2'][$pos])) {
            $subres = $this->parser->regexpCache['Text2'][$pos];
        } else {
            if (isset($this->parser->rxCache['Text2'])) {
                $regexp = $this->parser->rxCache['Text2'];
            } else {
                $this->parser->rxCache['Text2'] = $regexp = $this->parser->initRxReplace('Text',$regexp);
            }
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]));
                foreach ($match as $n => $v) {
                    if (is_string($n)) {
                        $subres['_matchres'][$n] = $v[0];
                    }
                }
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
        }
        // End '/({getLdel}\s*literal\s*{getRdel}.*?{getLdel}\/\s*literal\s*{getRdel})?(([\s\S])*?(?=({getLdel})))|[\S\s]+/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Text___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Text___FINISH (&$result) {
        if ($result['_text'] == '') {
            $result = false;
            return;
        }
        $result['node'] = new InternalText($this->parser);
        $result['node']->addText($result['_text'])->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
        $result['_text'] = '';
        $result['_silent'] = 1;
    }


    public function Text_INIT_getLdel (&$rule) {
        return $this->parser->Ldel;
    }


    public function Text_INIT_getRdel (&$rule) {
        return $this->parser->Rdel;
    }



}
