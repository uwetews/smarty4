<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node;
use Smarty\PegParser;

/**
 * Class BodyParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class BodyParser extends PegParser
{
    
    /**
     *
     * Parser generated on 2014-07-13 07:20:23
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/Body.peg.inc' dated 2014-07-13 07:20:15
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
            <rule> ((!LdelSlash &Ldel .nodes:CoreTag) | nodes:Text )*</rule>
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
    public function matchNodeBody($previous, &$errorResult){
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '( ( !LdelSlash &Ldel .nodes:CoreTag) | nodes:Text)*' min '0' max 'null'
        $iteration0 = 0;
        do {
            // start option
            $error1 = $error;
            $errorOption1 =array();
            $this->parser->addBacktrace(array('_o1_', ''));
            do {
                $error = array();
                array_pop($this->parser->backtrace);
                $this->parser->addBacktrace(array('_o1:1_', ''));
                // Start '( !LdelSlash &Ldel .nodes:CoreTag)' min '1' max '1'
                // start sequence
                $backup3 = $result;
                $pos3 = $this->parser->pos;
                $line3 = $this->parser->line;
                $error3 = $error;
                $this->parser->addBacktrace(array('_s3_', ''));
                do {
                    $error = array();
                    // Start '!LdelSlash' min '1' max '1' negative lookahead
                    $backup4 = $result;
                    $pos4 = $this->parser->pos;
                    $line4 = $this->parser->line;
                    $this->parser->addBacktrace(array('LdelSlash', ''));
                    $subres = $this->parser->matchRule($result, 'LdelSlash', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('LdelSlash',  $subres['_text']));
                        $result['_text'] .= $subres['_text'];
                        $valid = false;
                    } else {
                        $valid = true;
                        $this->parser->failNode($remove);
                    }
                    $this->parser->pos = $pos4;
                    $this->parser->line = $line4;
                    $result = $backup4;
                    unset($backup4);
                    // End '!LdelSlash'
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    // Start '&Ldel' min '1' max '1' positive lookahead
                    $backup5 = $result;
                    $pos5 = $this->parser->pos;
                    $line5 = $this->parser->line;
                    $this->parser->addBacktrace(array('Ldel', ''));
                    $subres = $this->parser->matchRule($result, 'Ldel', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $result['_text'] .= $subres['_text'];
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    $this->parser->pos = $pos5;
                    $this->parser->line = $line5;
                    $result = $backup5;
                    unset($backup5);
                    // End '&Ldel'
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    // Start '.nodes:CoreTag' tag 'nodes' min '1' max '1'
                    $this->parser->addBacktrace(array('CoreTag', ''));
                    $subres = $this->parser->matchRule($result, 'CoreTag', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('CoreTag',  $subres['_text']));
                        $this->Body_nodes($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End '.nodes:CoreTag'
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    break;
                } while (true);
                $remove = array_pop($this->parser->backtrace);
                if (!$valid) {
                    $this->parser->failNode($remove);
                    $this->parser->pos = $pos3;
                    $this->parser->line = $line3;
                    $result = $backup3;
                } else {
                    $this->parser->successNode($remove);
                    }
                    $error = $error3;
                    unset($backup3);
                    // end sequence
                    // End '( !LdelSlash &Ldel .nodes:CoreTag)'
                    if ($valid) {
                        $this->parser->successNode(array_pop($this->parser->backtrace));
                        $error = $error1;
                        break;
                    } else {
                        $this->parser->logOption($errorOption1, 'Body', $error);
                    }
                    $error = array();
                    array_pop($this->parser->backtrace);
                    $this->parser->addBacktrace(array('_o1:2_', ''));
                    // Start 'nodes:Text' tag 'nodes' min '1' max '1'
                    $this->parser->addBacktrace(array('Text', ''));
                    $subres = $this->parser->matchRule($result, 'Text', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Text',  $subres['_text']));
                        $result['_text'] .= $subres['_text'];
                        $this->Body_nodes($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'nodes:Text'
                    if ($valid) {
                        $this->parser->successNode(array_pop($this->parser->backtrace));
                        $error = $error1;
                        break;
                    } else {
                        $this->parser->logOption($errorOption1, 'Body', $error);
                    }
                    $error = $error1;
                    array_pop($this->parser->backtrace);
                    break;
                } while (true);
                // end option
                $iteration0 = $valid ? ($iteration0 + 1) : $iteration0;
                if (!$valid && $iteration0 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) break;
            } while (true);
            // End '( ( !LdelSlash &Ldel .nodes:CoreTag) | nodes:Text)*'
            if ($valid) {
                $result['_endpos'] = $this->parser->pos;
                $result['_endline'] = $this->parser->line;
                $this->Body___FINISH($result);
            }
            if (!$valid) {
                $result = false;
                $this->parser->matchError($errorResult, 'token', $error, 'Body');
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
