<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Tag\TagOutput;
use Smarty\PegParser;

/**
 * Class TagOutputParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagOutputParser extends PegParser
{
   
    /**
     *
     * Parser generated on 2014-07-10 23:09:01
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/TagOutput.peg.inc' dated 2014-07-06 20:56:04
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
            "TagOutput" => "matchNodeTagOutput"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "TagOutput" => array(
                    "_nodetype" => "node"
                )
        );
    /**
     *
     * Parser rules and action for node 'TagOutput'
     *
     *  Rule:
    
             <node TagOutput>
                 <rule>Ldel _? value:Expr Rdel</rule>
                 <action value>
                 {
                     $result['node'] = new TagOutput($this->parser);
                     $result['node']->addSubTree($subres['node'], 'value');
                     $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                 }
                 </action>
             </node>

     *
    */
    public function matchNodeTagOutput($previous, &$errorResult){
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'TagOutput' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        $error1 = $error;
        do {
            $error = array();
            // Start 'Ldel' min '1' max '1'
            $this->parser->addBacktrace(array('Ldel', ''));
            $subres = $this->parser->matchRule($result, 'Ldel', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Ldel',  $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Ldel'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start '_?' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                if (!empty($match[0])) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                    $result['_text'] .= ' ';
                }
            }
            $this->parser->successNode(array("' '",  $match[0]));
            $valid = true;
            // End '_?'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'value:Expr' tag 'value' min '1' max '1'
            $this->parser->addBacktrace(array('Expr', ''));
            $subres = $this->parser->matchRule($result, 'Expr', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Expr',  $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $this->TagOutput_value($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'value:Expr'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'Rdel' min '1' max '1'
            $this->parser->addBacktrace(array('Rdel', ''));
            $subres = $this->parser->matchRule($result, 'Rdel', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Rdel',  $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Rdel'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        }
        $error = $error1;
        unset($backup1);
        // end sequence
        // End 'TagOutput'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'TagOutput');
        }
        return $result;
    }

    public function TagOutput_value (&$result, $subres) {
        $result['node'] = new TagOutput($this->parser);
        $result['node']->addSubTree($subres['node'], 'value');
        $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
    }



}

