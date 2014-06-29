<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Compiler\Source\Shared\Node;
use Smarty\PegParser;

/**
 * Class TagOutputParser
 *
 * @package Smarty\Compiler\Source\Language\Smarty\Parser
 */
class TagOutputParser extends PegParser
{
   
    /**
     *
     * Parser generated on 2014-06-29 18:39:02
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/TagOutput.peg.inc' dated 2014-06-28 02:53:31
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
                     $result['node'] = new Node\TagOutput($this->parser);
                     $result['node']->addSubTree($subres['node'], 'value');
                     $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                 }
                 </action>
             </node>

     *
    */
    public function matchNodeTagOutput($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'TagOutput' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Ldel' min '1' max '1'
            $this->parser->addBacktrace(array('Ldel', $result));
            $subres = $this->parser->matchRule($result, 'Ldel');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Ldel',  $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Ldel'
            if (!$valid) {
                break;
            }
            // Start '_?' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                if ($match[0]) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                    $result['_text'] .= ' ';
                }
            }
            $valid = true;
            // End '_?'
            if (!$valid) {
                break;
            }
            // Start 'value:Expr' tag 'value' min '1' max '1'
            $this->parser->addBacktrace(array('Expr', $result));
            $subres = $this->parser->matchRule($result, 'Expr');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Expr',  $subres));
                $result['_text'] .= $subres['_text'];
                $this->TagOutput_value($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'value:Expr'
            if (!$valid) {
                break;
            }
            // Start 'Rdel' min '1' max '1'
            $this->parser->addBacktrace(array('Rdel', $result));
            $subres = $this->parser->matchRule($result, 'Rdel');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Rdel',  $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Rdel'
            if (!$valid) {
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        }
        unset($backup1);
        // end sequence
        // End 'TagOutput'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function TagOutput_value (&$result, $subres) {
        $result['node'] = new Node\TagOutput($this->parser);
        $result['node']->addSubTree($subres['node'], 'value');
        $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
    }



}

