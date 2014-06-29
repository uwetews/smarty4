<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Compiler\Source\Shared\Node;
use Smarty\PegParser;

/**
 * Class TagStatementParser
 *
 * @package Smarty\Compiler\Source\Language\Smarty\Parser
 */
class TagStatementParser extends PegParser
{
   
    /**
     *
     * Parser generated on 2014-06-29 20:27:43
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/TagStatement.peg.inc' dated 2014-06-28 02:53:31
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
            "TagStatement" => "matchNodeTagStatement"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "TagStatement" => array(
                    "_nodetype" => "node"
                )
        );
    /**
     *
     * Parser rules and action for node 'TagStatement'
     *
     *  Rule:
    
             <node TagStatement>
                 <rule>Ldel statement:Statement Rdel</rule>
                 <action statement>
                 {
                     $result['node'] = new Node\TagOutput($this->parser);
                     $result['node']->addSubTree($subres['node'], 'value');
                     $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                 }
                 </action>
             </node>

     *
    */
    public function matchNodeTagStatement($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'TagStatement' min '1' max '1'
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
            // Start 'statement:Statement' tag 'statement' min '1' max '1'
            $this->parser->addBacktrace(array('Statement', $result));
            $subres = $this->parser->matchRule($result, 'Statement');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Statement',  $subres));
                $result['_text'] .= $subres['_text'];
                $this->TagStatement_statement($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'statement:Statement'
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
        // End 'TagStatement'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function TagStatement_statement (&$result, $subres) {
        $result['node'] = new Node\TagOutput($this->parser);
        $result['node']->addSubTree($subres['node'], 'value');
        $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
    }



}

