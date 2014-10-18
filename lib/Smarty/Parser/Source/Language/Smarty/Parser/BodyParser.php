<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node;
use Smarty\Parser\Peg\RuleRoot;

/**
 * Class BodyParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class BodyParser extends RuleRoot
{
   
    /**
     *
     * Parser generated on 2014-09-04 04:36:49
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/Body.peg.inc' dated 2014-09-04 04:36:29
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
            "Body" => "matchNodeBody"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "Body" => array(
                    "node" => "Body"
                )
        );
    /**
     *
     * Parser rules and actions for node 'Body'
     *
     *  Rule:
     * 
     * 
     *        <node  Body>
     *            <attribute>node='Body'</attribute>
     *            <rule> (( ../(?=({getLdel}(?!(\/))))/ nodes:CoreTag) | nodes:Text )*</rule>
     *            <action _start>
     *            {
     *                 $nodeRes['node'] = new Node\Body($this->parser);
     *                 $this->parser->pushBody($nodeRes['node']);
     *            }
     *            </action>
     *            <action nodes>
     *               {
     *                 $nodeRes['node']->addSubTree($matchRes['node']);
     *                 $this->parser->cleanupCache();
     *               }
     *            </action>
     *            <action _finish>
     *            {
     *                $this->parser->popBody();
     *                if ($nodeRes['node']->getCountSubTree()) {
     *                     $nodeRes['node']->setTraceInfo($nodeRes['_lineno'], '', $nodeRes['_startpos'], $nodeRes['_endpos']);
     *                } else {
     *                    $nodeRes = false;
     *                }
     *            }
     *            </action>
     *             <action _init(getLdel)>
     *                 {
     *                     return $this->parser->Ldel;
     *                 }
     *             </action>
     *        </node>
     * 
     *
    */
    public function matchNodeBody($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->Body_START($nodeRes, $previous);
        /*
         * Start rule: ((../(?=({getLdel}(?!(\/))))/ nodes:CoreTag) | nodes:Text)*
         *       min: 0 max: null
         */
        $iteration0 = 0;
        do {
            // start option
            $error1 = $error;
            $errorOption1 =array();
            if ($trace) {
                $traceObj->addBacktrace(array('_o1_', ''));
            }
            do {
                $error = array();
                if ($trace) {
                    $traceObj->popBacktrace();
                    $traceObj->addBacktrace(array('_o1:1_', ''));
                }
                /*
                 * Start rule: (../(?=({getLdel}(?!(\/))))/ nodes:CoreTag)
                 *       min: 1 max: 1
                 */
                // start sequence
                $backup3 = $nodeRes;
                $pos3 = $this->parser->pos;
                $line3 = $this->parser->line;
                $error3 = $error;
                if ($trace) {
                    $traceObj->addBacktrace(array('_s3_', ''));
                }
                do {
                    $error = array();
                    /*
                     * Start rule: ../(?=({getLdel}(?!(\/))))/
                     *       min: 1 max: 1
                     */
                    $regexp = "/(?=({getLdel}(?!(\\/))))/";
                    $pos = $this->parser->pos;
                    if (isset($this->parser->rxCache['Rx_Body5'])) {
                        $regexp = $this->parser->rxCache['Rx_Body5'];
                    } else {
                        $this->parser->rxCache['Rx_Body5'] = $regexp = $this->parser->initRxReplace('Body',$regexp);
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
                        $valid = true;
                    } else {
                        $valid = false;
                    }
                    if (!$valid) {
                        $this->parser->matchError($error, 'rx', "/(?=({getLdel}(?!(\\/))))/");
                    }
                    /*
                     * End rule: ../(?=({getLdel}(?!(\/))))/
                     */
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: nodes:CoreTag
                     *       tag: 'nodes'
                     *       min: 1 max: 1
                     */
                    if ($trace) {
                        $traceObj->addBacktrace(array('CoreTag', ''));
                    }
                    $matchRes = $this->parser->matchRule($nodeRes, 'CoreTag', $error);
                    if ($trace) {
                        $remove = $traceObj->popBacktrace();
                    }
                    if ($matchRes) {
                        if ($trace) {
                            $traceObj->successNode(array('CoreTag',  $matchRes['_text']));
                        }
                        $nodeRes['_text'] .= $matchRes['_text'];
                        $this->Body_MATCH_nodes($nodeRes, $matchRes);
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $traceObj->failNode($remove);
                        }
                    }
                    /*
                     * End rule: nodes:CoreTag
                     */
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    if ($trace) {
                        $traceObj->failNode();
                    }
                    $this->parser->pos = $pos3;
                    $this->parser->line = $line3;
                    $nodeRes = $backup3;
                } elseif ($trace) {
                    $traceObj->successNode();
                }
                $error = $error3;
                unset($backup3);
                // end sequence
                /*
                 * End rule: (../(?=({getLdel}(?!(\/))))/ nodes:CoreTag)
                 */
                if ($valid) {
                    if ($trace) {
                        $traceObj->successNode();
                    }
                    $error = $error1;
                    break;
                } else {
                    $this->parser->logOption($errorOption1, 'Sequence', $error);
                }
                $error = array();
                if ($trace) {
                    $traceObj->popBacktrace();
                    $traceObj->addBacktrace(array('_o1:2_', ''));
                }
                /*
                 * Start rule: nodes:Text
                 *       tag: 'nodes'
                 *       min: 1 max: 1
                 */
                if ($trace) {
                    $traceObj->addBacktrace(array('Text', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'Text', $error);
                if ($trace) {
                    $remove = $traceObj->popBacktrace();
                }
                if ($matchRes) {
                    if ($trace) {
                        $traceObj->successNode(array('Text',  $matchRes['_text']));
                    }
                    $nodeRes['_text'] .= $matchRes['_text'];
                    $this->Body_MATCH_nodes($nodeRes, $matchRes);
                    $valid = true;
                } else {
                    $valid = false;
                    if ($trace) {
                        $traceObj->failNode($remove);
                    }
                }
                /*
                 * End rule: nodes:Text
                 */
                if ($valid) {
                    if ($trace) {
                        $traceObj->successNode();
                    }
                    $error = $error1;
                    break;
                } else {
                    $this->parser->logOption($errorOption1, 'Text', $error);
                }
                $error = $error1;
                if ($trace) {
                    $traceObj->popBacktrace();
                }
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
        /*
         * End rule: ((../(?=({getLdel}(?!(\/))))/ nodes:CoreTag) | nodes:Text)*
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
            $this->Body_FINISH($nodeRes);
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Body');
        }
        return $nodeRes;
    }
    public function Body_START (&$nodeRes, $previous)
    {
        $nodeRes['node'] = new Node\Body($this->parser);
        $this->parser->pushBody($nodeRes['node']);
    }

    public function Body_MATCH_nodes (&$nodeRes, $matchRes)
    {
        $nodeRes['node']->addSubTree($matchRes['node']);
        $this->parser->cleanupCache();
    }

    public function Body_FINISH (&$nodeRes)
    {
        $this->parser->popBody();
        if ($nodeRes['node']->getCountSubTree())        {
            $nodeRes['node']->setTraceInfo($nodeRes['_lineno'], '', $nodeRes['_startpos'], $nodeRes['_endpos']);
        }
        else        {
            $nodeRes = false;
        }
    }

    public function Body_INIT_getLdel (&$rule)
    {
        return $this->parser->Ldel;
    }


}
