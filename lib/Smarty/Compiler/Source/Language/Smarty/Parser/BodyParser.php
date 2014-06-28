<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Compiler\Source\Language\Smarty\Node;
use Smarty\PegParser;

/**
 * Class BodyParser
 *
 * @package Smarty\Compiler\Source\Language\Smarty\Parser
 */
class BodyParser extends PegParser
{
    
    /**
     *
     * Parser generated on 2014-06-28 13:05:41
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/Body.peg.inc' dated 2014-06-28 13:05:38
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
            "Body" => "matchNodeBody"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "Body" => array(
                    "_nodetype" => "node"
                )
        );
    /**
     *
     * Parser rules and action for node 'Body'
     *
     *  Rule:
    

        <node  Body>
            <rule> ( !LdelSlash ((&Ldel nodes:CoreTag) | nodes:Text ))*</rule>
            <action nodes>
               {
                 $result['nodes'][] = $subres['node'];
               }
            </action>
            <action _finish>
            {
                if (isset($result['nodes'])) {
                    $result['node'] = new Node\Body($this->parser);
                    $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
                    $result['node']->addSubTree($result['nodes']);
                    unset($result['nodes']);
                } else {
                    $result = false;
                }
            }
            </action>
        </node>

     *
    */
    public function matchNodeBody($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '(  !LdelSlash (  (  &Ldel nodes:CoreTag ) | nodes:Text ) )*' min '0' max 'null'
        $iteration0 = 0;
        do {
            // start sequence
            $backup1 = $result;
            $pos1 = $this->parser->pos;
            $line1 = $this->parser->line;
            do {
                // Start '!LdelSlash' min '1' max '1' negative lookahead
                $backup2 = $result;
                $pos2 = $this->parser->pos;
                $line2 = $this->parser->line;
                $this->parser->addBacktrace(array('LdelSlash', $result));
                $subres = $this->parser->matchRule($result, 'LdelSlash');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('LdelSlash',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $valid = false;
                } else {
                    $valid = true;
                    $this->parser->failNode($remove);
                }
                $this->parser->pos = $pos2;
                $this->parser->line = $line2;
                $result = $backup2;
                unset($backup2);
                // End '!LdelSlash'
                if (!$valid) {
                    break;
                }
                // Start '(  (  &Ldel nodes:CoreTag ) | nodes:Text )' min '1' max '1'
                // start option
                do {
                    // Start '(  &Ldel nodes:CoreTag )' min '1' max '1'
                    // start sequence
                    $backup5 = $result;
                    $pos5 = $this->parser->pos;
                    $line5 = $this->parser->line;
                    do {
                        // Start '&Ldel' min '1' max '1' positive lookahead
                        $backup6 = $result;
                        $pos6 = $this->parser->pos;
                        $line6 = $this->parser->line;
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
                        $this->parser->pos = $pos6;
                        $this->parser->line = $line6;
                        $result = $backup6;
                        unset($backup6);
                        // End '&Ldel'
                        if (!$valid) {
                            break;
                        }
                        // Start 'nodes:CoreTag' tag 'nodes' min '1' max '1'
                        $this->parser->addBacktrace(array('CoreTag', $result));
                        $subres = $this->parser->matchRule($result, 'CoreTag');
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('CoreTag',  $subres));
                            $result['_text'] .= $subres['_text'];
                            $this->Body_nodes($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'nodes:CoreTag'
                        if (!$valid) {
                            break;
                        }
                        break;
                    } while (true);
                    if (!$valid) {
                        $this->parser->pos = $pos5;
                        $this->parser->line = $line5;
                        $result = $backup5;
                    }
                    unset($backup5);
                    // end sequence
                    // End '(  &Ldel nodes:CoreTag )'
                    if ($valid) {
                        break;
                    }
                    // Start 'nodes:Text' tag 'nodes' min '1' max '1'
                    $this->parser->addBacktrace(array('Text', $result));
                    $subres = $this->parser->matchRule($result, 'Text');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Text',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->Body_nodes($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'nodes:Text'
                    if ($valid) {
                        break;
                    }
                    break;
                } while (true);
                // end option
                // End '(  (  &Ldel nodes:CoreTag ) | nodes:Text )'
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
            $iteration0 = $valid ? ($iteration0 + 1) : $iteration0;
            if (!$valid && $iteration0 >= 0) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        // End '(  !LdelSlash (  (  &Ldel nodes:CoreTag ) | nodes:Text ) )*'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Body___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Body_nodes (&$result, $subres) {
        $result['nodes'][] = $subres['node'];
    }


    public function Body___FINISH (&$result) {
        if (isset($result['nodes'])) {
            $result['node'] = new Node\Body($this->parser);
            $result['node']->setTraceInfo($result['_lineno'], '', $result['_startpos'], $result['_endpos']);
            $result['node']->addSubTree($result['nodes']);
            unset($result['nodes']);
        }
        else {
            $result = false;
        }
    }



}
