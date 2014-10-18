<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Value\String;
use Smarty\Parser\Source\Language\Smarty\Node\Value\Variable;
use Smarty\Parser\Peg\RuleRoot;
use Smarty\Node;

/**
 * Class VariableParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class VariableParser extends RuleRoot
{
   
    /**
     *
     * Parser generated on 2014-09-04 02:35:34
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/Variable.peg.inc' dated 2014-09-03 21:35:35
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
            "Variable" => "matchNodeVariable",
            "Arrayelement" => "matchNodeArrayelement",
            "Object" => "matchNodeObject"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "Variable" => array(
                    "hash" => true
                )
        );
    /**
     *
     * Parser rules and actions for node 'Variable'
     *
     *  Rule:
     * 
     *     #
     *     # Template variable
     *     #
     *     #                -> name can be nested variable                    -> array access     -> property or method
     *         <node Variable>
     *             <attribute>hash</attribute>
     *             <rule>  ( ../(?=([$]smarty[.]))/ special:SpecialVariable) | ( /(?<isvar>[$])(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/ ( '{' var:Variable /(\})(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/ )* ( ../(?=([@.\[]|(->)))/ (('@' property:Id)? ( ( ../(?=([.\[]))/ Arrayelement) | ( &'->' Object))*))? ) </rule>
     *             <action _start>
     *             {
     *                 $i = 1;
     *             }
     *             </action>
     *             <action special>
     *             {
     *                 $nodeRes['node'] = $matchRes['node'];
     *             }
     *             </action>
     *             <action isvar>
     *             {
     *                 $nodeRes['node'] = new Variable($this->parser);
     *             }
     *             </action>
     *             <action id>
     *             {
     *                 $node = new String($this->parser);
     *                 $nodeRes['node']->addSubTree($node->setValue($matchRes['_pregMatch']['id'], true)->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']), 'name', true);
     *             }
     *             </action>
     *             <action var>
     *             {
     *                 $nodeRes['node']->addSubTree($matchRes['node'], 'name', true);
     *             }
     *             </action>
     *             <action property>
     *             {
     *                 $nodeRes['node']->addSubTree($matchRes['_text'], 'property');
     *             }
     *             </action>
     *             <action _finish>
     *             {
     *                     $nodeRes['node']->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
     *             }
     *             </action>
     *         </node>
     * 
     *
    */
    public function matchNodeVariable($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        if (isset($this->parser->packCache[$this->parser->pos]['Variable'])) {
            $nodeRes = $this->parser->packCache[$this->parser->pos]['Variable'];
            $error = $this->parser->errorCache[$this->parser->pos]['Variable'];
            if ($nodeRes) {
                $this->parser->pos = $nodeRes['_endpos'];
                $this->parser->line = $nodeRes['_endline'];
            } else {
                $this->parser->matchError($errorResult, 'token', $error, 'Variable');
            }
            return $nodeRes;
        }
        $this->Variable_START($nodeRes, $previous);
        // start option
        $error0 = $error;
        $errorOption0 =array();
        if ($trace) {
            $traceObj->addBacktrace(array('_o0_', ''));
        }
        do {
            $error = array();
            if ($trace) {
                $traceObj->popBacktrace();
                $traceObj->addBacktrace(array('_o0:1_', ''));
            }
            /*
             * Start rule: (../(?=([$]smarty[.]))/ special:SpecialVariable)
             *       min: 1 max: 1
             */
            // start sequence
            $backup2 = $nodeRes;
            $pos2 = $this->parser->pos;
            $line2 = $this->parser->line;
            $error2 = $error;
            if ($trace) {
                $traceObj->addBacktrace(array('_s2_', ''));
            }
            do {
                $error = array();
                /*
                 * Start rule: ../(?=([$]smarty[.]))/
                 *       min: 1 max: 1
                 */
                $regexp = "/(?=([$]smarty[.]))/";
                $pos = $this->parser->pos;
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
                    $this->parser->matchError($error, 'rx', "/(?=([$]smarty[.]))/");
                }
                /*
                 * End rule: ../(?=([$]smarty[.]))/
                 */
                if (!$valid) {
                    $this->parser->matchError($error2, 'SequenceElement', $error);
                    $error = $error2;
                    break;
                }
                $error = array();
                /*
                 * Start rule: special:SpecialVariable
                 *       tag: 'special'
                 *       min: 1 max: 1
                 */
                if ($trace) {
                    $traceObj->addBacktrace(array('SpecialVariable', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'SpecialVariable', $error);
                if ($trace) {
                    $remove = $traceObj->popBacktrace();
                }
                if ($matchRes) {
                    if ($trace) {
                        $traceObj->successNode(array('SpecialVariable',  $matchRes['_text']));
                    }
                    $nodeRes['_text'] .= $matchRes['_text'];
                    $this->Variable_MATCH_special($nodeRes, $matchRes);
                    $valid = true;
                } else {
                    $valid = false;
                    if ($trace) {
                        $traceObj->failNode($remove);
                    }
                }
                /*
                 * End rule: special:SpecialVariable
                 */
                if (!$valid) {
                    $this->parser->matchError($error2, 'SequenceElement', $error);
                    $error = $error2;
                    break;
                }
                break;
            } while (true);
            if (!$valid) {
                if ($trace) {
                    $traceObj->failNode();
                }
                $this->parser->pos = $pos2;
                $this->parser->line = $line2;
                $nodeRes = $backup2;
            } elseif ($trace) {
                $traceObj->successNode();
            }
            $error = $error2;
            unset($backup2);
            // end sequence
            /*
             * End rule: (../(?=([$]smarty[.]))/ special:SpecialVariable)
             */
            if ($valid) {
                if ($trace) {
                    $traceObj->successNode();
                }
                $error = $error0;
                break;
            } else {
                $this->parser->logOption($errorOption0, 'Sequence', $error);
            }
            $error = array();
            if ($trace) {
                $traceObj->popBacktrace();
                $traceObj->addBacktrace(array('_o0:2_', ''));
            }
            /*
             * Start rule: (/(?<isvar>[$])(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/ ('{' var:Variable /(\})(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/)* (../(?=([@.\[]|(->)))/ (('@' property:Id)? ((../(?=([.\[]))/ Arrayelement) | (&'->' Object))*))?)
             *       min: 1 max: 1
             */
            // start sequence
            $backup7 = $nodeRes;
            $pos7 = $this->parser->pos;
            $line7 = $this->parser->line;
            $error7 = $error;
            if ($trace) {
                $traceObj->addBacktrace(array('_s7_', ''));
            }
            do {
                $error = array();
                /*
                 * Start rule: /(?<isvar>[$])(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/
                 *       min: 1 max: 1
                 */
                $regexp = "/(?<isvar>[$])(?<id>([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*))?/";
                $pos = $this->parser->pos;
                if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos) && (strlen($pregMatch[0][0]) || (isset($pregMatch[1]) && strlen($pregMatch[1][0])))) {
                    if (strlen($pregMatch[0][0]) != 0) {
                        $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                        foreach ($pregMatch as $n => $v) {
                            if (is_string($n) && strlen($v[0])) {
                                $matchRes['_pregMatch'][$n] = $v[0];
                            }
                        }
                        if ($matchRes['_startpos'] != $pos) {
                            $matchRes = false;
                        }
                    } else {
                        $matchRes = false;
                    }
                } else {
                    $matchRes = false;
                }
                if ($matchRes) {
                    $matchRes['_lineno'] = $this->parser->line;
                    $this->parser->pos = $matchRes['_endpos'];
                    $this->parser->line += substr_count($matchRes['_text'], "\n");
                    $nodeRes['_text'] .= $matchRes['_text'];
                    if (isset($matchRes['_pregMatch']['isvar'])) {
                        $this->Variable_MATCH_isvar($nodeRes, $matchRes);
                        unset($matchRes['_pregMatch']['isvar']);
                    }
                    if (isset($matchRes['_pregMatch']['id'])) {
                        $this->Variable_MATCH_id($nodeRes, $matchRes);
                        unset($matchRes['_pregMatch']['id']);
                    }
                    $nodeRes['_pregMatch'] = array_merge($nodeRes['_pregMatch'], $matchRes['_pregMatch']);
                    $valid = true;
                } else {
                    $valid = false;
                }
                if (!$valid) {
                    $this->parser->matchError($error, 'rx', "/(?<isvar>[$])(?<id>([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*))?/");
                }
                /*
                 * End rule: /(?<isvar>[$])(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/
                 */
                if (!$valid) {
                    $this->parser->matchError($error7, 'SequenceElement', $error);
                    $error = $error7;
                    break;
                }
                $error = array();
                /*
                 * Start rule: ('{' var:Variable /(\})(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/)*
                 *       min: 0 max: null
                 */
                $iteration10 = 0;
                do {
                    // start sequence
                    $backup11 = $nodeRes;
                    $pos11 = $this->parser->pos;
                    $line11 = $this->parser->line;
                    $error11 = $error;
                    if ($trace) {
                        $traceObj->addBacktrace(array('_s11_', ''));
                    }
                    do {
                        $error = array();
                        /*
                         * Start rule: '{'
                         *       min: 1 max: 1
                         */
                        if ('{' == substr($this->parser->source, $this->parser->pos, 1)) {
                            $this->parser->pos += 1;
                            $nodeRes['_text'] .= '{';
                            if ($trace) {
                                $traceObj->successNode(array('\'{\'', '{'));
                            }
                            $valid = true;
                        } else {
                            $this->parser->matchError($error, 'literal', '{');
                            if ($trace) {
                                $traceObj->failNode(array('\'{\'',  ''));
                            }
                            $valid = false;
                        }
                        /*
                         * End rule: '{'
                         */
                        if (!$valid) {
                            $this->parser->matchError($error11, 'SequenceElement', $error);
                            $error = $error11;
                            break;
                        }
                        $error = array();
                        /*
                         * Start rule: var:Variable
                         *       tag: 'var'
                         *       min: 1 max: 1
                         */
                        if ($trace) {
                            $traceObj->addBacktrace(array('Variable', ''));
                        }
                        $matchRes = $this->parser->matchRule($nodeRes, 'Variable', $error);
                        if ($trace) {
                            $remove = $traceObj->popBacktrace();
                        }
                        if ($matchRes) {
                            if ($trace) {
                                $traceObj->successNode(array('Variable',  $matchRes['_text']));
                            }
                            $nodeRes['_text'] .= $matchRes['_text'];
                            $this->Variable_MATCH_var($nodeRes, $matchRes);
                            $valid = true;
                        } else {
                            $valid = false;
                            if ($trace) {
                                $traceObj->failNode($remove);
                            }
                        }
                        /*
                         * End rule: var:Variable
                         */
                        if (!$valid) {
                            $this->parser->matchError($error11, 'SequenceElement', $error);
                            $error = $error11;
                            break;
                        }
                        $error = array();
                        /*
                         * Start rule: /(\})(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/
                         *       min: 1 max: 1
                         */
                        $regexp = "/(\\})(?<id>([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*))?/";
                        $pos = $this->parser->pos;
                        if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos) && (strlen($pregMatch[0][0]) || (isset($pregMatch[1]) && strlen($pregMatch[1][0])))) {
                            if (strlen($pregMatch[0][0]) != 0) {
                                $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                                foreach ($pregMatch as $n => $v) {
                                    if (is_string($n) && strlen($v[0])) {
                                        $matchRes['_pregMatch'][$n] = $v[0];
                                    }
                                }
                                if ($matchRes['_startpos'] != $pos) {
                                    $matchRes = false;
                                }
                            } else {
                                $matchRes = false;
                            }
                        } else {
                            $matchRes = false;
                        }
                        if ($matchRes) {
                            $matchRes['_lineno'] = $this->parser->line;
                            $this->parser->pos = $matchRes['_endpos'];
                            $this->parser->line += substr_count($matchRes['_text'], "\n");
                            $nodeRes['_text'] .= $matchRes['_text'];
                            if (isset($matchRes['_pregMatch']['id'])) {
                                $this->Variable_MATCH_id($nodeRes, $matchRes);
                                unset($matchRes['_pregMatch']['id']);
                            }
                            $nodeRes['_pregMatch'] = array_merge($nodeRes['_pregMatch'], $matchRes['_pregMatch']);
                            $valid = true;
                        } else {
                            $valid = false;
                        }
                        if (!$valid) {
                            $this->parser->matchError($error, 'rx', "/(\\})(?<id>([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*))?/");
                        }
                        /*
                         * End rule: /(\})(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/
                         */
                        if (!$valid) {
                            $this->parser->matchError($error11, 'SequenceElement', $error);
                            $error = $error11;
                            break;
                        }
                        break;
                    } while (true);
                    if (!$valid) {
                        if ($trace) {
                            $traceObj->failNode();
                        }
                        $this->parser->pos = $pos11;
                        $this->parser->line = $line11;
                        $nodeRes = $backup11;
                    } elseif ($trace) {
                        $traceObj->successNode();
                    }
                    $error = $error11;
                    unset($backup11);
                    // end sequence
                    $iteration10 = $valid ? ($iteration10 + 1) : $iteration10;
                    if (!$valid && $iteration10 >= 0) {
                        $valid = true;
                        break;
                    }
                    if (!$valid) break;
                } while (true);
                /*
                 * End rule: ('{' var:Variable /(\})(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/)*
                 */
                if (!$valid) {
                    $this->parser->matchError($error7, 'SequenceElement', $error);
                    $error = $error7;
                    break;
                }
                $error = array();
                /*
                 * Start rule: (../(?=([@.\[]|(->)))/ (('@' property:Id)? ((../(?=([.\[]))/ Arrayelement) | (&'->' Object))*))?
                 *       min: 0 max: 1
                 */
                $error = array();
                // start sequence
                $backup17 = $nodeRes;
                $pos17 = $this->parser->pos;
                $line17 = $this->parser->line;
                $error17 = $error;
                if ($trace) {
                    $traceObj->addBacktrace(array('_s17_', ''));
                }
                do {
                    $error = array();
                    /*
                     * Start rule: ../(?=([@.\[]|(->)))/
                     *       min: 1 max: 1
                     */
                    $regexp = "/(?=([@.\\[]|(->)))/";
                    $pos = $this->parser->pos;
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
                        $this->parser->matchError($error, 'rx', "/(?=([@.\\[]|(->)))/");
                    }
                    /*
                     * End rule: ../(?=([@.\[]|(->)))/
                     */
                    if (!$valid) {
                        $this->parser->matchError($error17, 'SequenceElement', $error);
                        $error = $error17;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: (('@' property:Id)? ((../(?=([.\[]))/ Arrayelement) | (&'->' Object))*)
                     *       min: 1 max: 1
                     */
                    // start sequence
                    $backup21 = $nodeRes;
                    $pos21 = $this->parser->pos;
                    $line21 = $this->parser->line;
                    $error21 = $error;
                    if ($trace) {
                        $traceObj->addBacktrace(array('_s21_', ''));
                    }
                    do {
                        $error = array();
                        /*
                         * Start rule: ('@' property:Id)?
                         *       min: 0 max: 1
                         */
                        $error = array();
                        // start sequence
                        $backup23 = $nodeRes;
                        $pos23 = $this->parser->pos;
                        $line23 = $this->parser->line;
                        $error23 = $error;
                        if ($trace) {
                            $traceObj->addBacktrace(array('_s23_', ''));
                        }
                        do {
                            $error = array();
                            /*
                             * Start rule: '@'
                             *       min: 1 max: 1
                             */
                            if ('@' == substr($this->parser->source, $this->parser->pos, 1)) {
                                $this->parser->pos += 1;
                                $nodeRes['_text'] .= '@';
                                if ($trace) {
                                    $traceObj->successNode(array('\'@\'', '@'));
                                }
                                $valid = true;
                            } else {
                                $this->parser->matchError($error, 'literal', '@');
                                if ($trace) {
                                    $traceObj->failNode(array('\'@\'',  ''));
                                }
                                $valid = false;
                            }
                            /*
                             * End rule: '@'
                             */
                            if (!$valid) {
                                $this->parser->matchError($error23, 'SequenceElement', $error);
                                $error = $error23;
                                break;
                            }
                            $error = array();
                            /*
                             * Start rule: property:Id
                             *       tag: 'property'
                             *       min: 1 max: 1
                             */
                            if ($trace) {
                                $traceObj->addBacktrace(array('Id', ''));
                            }
                            $matchRes = $this->parser->matchRule($nodeRes, 'Id', $error);
                            if ($trace) {
                                $remove = $traceObj->popBacktrace();
                            }
                            if ($matchRes) {
                                if ($trace) {
                                    $traceObj->successNode(array('Id',  $matchRes['_text']));
                                }
                                $nodeRes['_text'] .= $matchRes['_text'];
                                $this->Variable_MATCH_property($nodeRes, $matchRes);
                                $valid = true;
                            } else {
                                $valid = false;
                                if ($trace) {
                                    $traceObj->failNode($remove);
                                }
                            }
                            /*
                             * End rule: property:Id
                             */
                            if (!$valid) {
                                $this->parser->matchError($error23, 'SequenceElement', $error);
                                $error = $error23;
                                break;
                            }
                            break;
                        } while (true);
                        if (!$valid) {
                            if ($trace) {
                                $traceObj->failNode();
                            }
                            $this->parser->pos = $pos23;
                            $this->parser->line = $line23;
                            $nodeRes = $backup23;
                        } elseif ($trace) {
                            $traceObj->successNode();
                        }
                        $error = $error23;
                        unset($backup23);
                        // end sequence
                        if (!$valid) {
                            $this->parser->logOption($errorResult, 'Sequence', $error);
                        }
                        $valid = true;
                        /*
                         * End rule: ('@' property:Id)?
                         */
                        if (!$valid) {
                            $this->parser->matchError($error21, 'SequenceElement', $error);
                            $error = $error21;
                            break;
                        }
                        $error = array();
                        /*
                         * Start rule: ((../(?=([.\[]))/ Arrayelement) | (&'->' Object))*
                         *       min: 0 max: null
                         */
                        $iteration26 = 0;
                        do {
                            // start option
                            $error27 = $error;
                            $errorOption27 =array();
                            if ($trace) {
                                $traceObj->addBacktrace(array('_o27_', ''));
                            }
                            do {
                                $error = array();
                                if ($trace) {
                                    $traceObj->popBacktrace();
                                    $traceObj->addBacktrace(array('_o27:1_', ''));
                                }
                                /*
                                 * Start rule: (../(?=([.\[]))/ Arrayelement)
                                 *       min: 1 max: 1
                                 */
                                // start sequence
                                $backup29 = $nodeRes;
                                $pos29 = $this->parser->pos;
                                $line29 = $this->parser->line;
                                $error29 = $error;
                                if ($trace) {
                                    $traceObj->addBacktrace(array('_s29_', ''));
                                }
                                do {
                                    $error = array();
                                    /*
                                     * Start rule: ../(?=([.\[]))/
                                     *       min: 1 max: 1
                                     */
                                    $regexp = "/(?=([.\\[]))/";
                                    $pos = $this->parser->pos;
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
                                        $this->parser->matchError($error, 'rx', "/(?=([.\\[]))/");
                                    }
                                    /*
                                     * End rule: ../(?=([.\[]))/
                                     */
                                    if (!$valid) {
                                        $this->parser->matchError($error29, 'SequenceElement', $error);
                                        $error = $error29;
                                        break;
                                    }
                                    $error = array();
                                    /*
                                     * Start rule: Arrayelement
                                     *       min: 1 max: 1
                                     */
                                    if ($trace) {
                                        $traceObj->addBacktrace(array('Arrayelement', ''));
                                    }
                                    $matchRes = $this->parser->matchRule($nodeRes, 'Arrayelement', $error);
                                    if ($trace) {
                                        $remove = $traceObj->popBacktrace();
                                    }
                                    if ($matchRes) {
                                        if ($trace) {
                                            $traceObj->successNode(array('Arrayelement',  $matchRes['_text']));
                                        }
                                        $nodeRes['_text'] .= $matchRes['_text'];
                                        if(!isset($nodeRes['Arrayelement'])) {
                                            $nodeRes['Arrayelement'] = $matchRes;
                                        } else {
                                            if (!is_array($nodeRes['Arrayelement'])) {
                                                $nodeRes['Arrayelement'] = array($nodeRes['Arrayelement']);
                                            }
                                            $nodeRes['Arrayelement'][] = $matchRes;
                                        }
                                        $valid = true;
                                    } else {
                                        $valid = false;
                                        if ($trace) {
                                            $traceObj->failNode($remove);
                                        }
                                    }
                                    /*
                                     * End rule: Arrayelement
                                     */
                                    if (!$valid) {
                                        $this->parser->matchError($error29, 'SequenceElement', $error);
                                        $error = $error29;
                                        break;
                                    }
                                    break;
                                } while (true);
                                if (!$valid) {
                                    if ($trace) {
                                        $traceObj->failNode();
                                    }
                                    $this->parser->pos = $pos29;
                                    $this->parser->line = $line29;
                                    $nodeRes = $backup29;
                                } elseif ($trace) {
                                    $traceObj->successNode();
                                }
                                $error = $error29;
                                unset($backup29);
                                // end sequence
                                /*
                                 * End rule: (../(?=([.\[]))/ Arrayelement)
                                 */
                                if ($valid) {
                                    if ($trace) {
                                        $traceObj->successNode();
                                    }
                                    $error = $error27;
                                    break;
                                } else {
                                    $this->parser->logOption($errorOption27, 'Sequence', $error);
                                }
                                $error = array();
                                if ($trace) {
                                    $traceObj->popBacktrace();
                                    $traceObj->addBacktrace(array('_o27:2_', ''));
                                }
                                /*
                                 * Start rule: (&'->' Object)
                                 *       min: 1 max: 1
                                 */
                                // start sequence
                                $backup34 = $nodeRes;
                                $pos34 = $this->parser->pos;
                                $line34 = $this->parser->line;
                                $error34 = $error;
                                if ($trace) {
                                    $traceObj->addBacktrace(array('_s34_', ''));
                                }
                                do {
                                    $error = array();
                                    /*
                                     * Start rule: &'->'
                                     *       min: 1 max: 1
                                     *       look ahead: 'positive'
                                     */
                                    $backup35 = $nodeRes;
                                    $pos35 = $this->parser->pos;
                                    $line35 = $this->parser->line;
                                    if ('->' == substr($this->parser->source, $this->parser->pos, 2)) {
                                        $this->parser->pos += 2;
                                        if ($trace) {
                                            $traceObj->successNode(array('\'->\'', '->'));
                                        }
                                        $valid = true;
                                    } else {
                                        $this->parser->matchError($error, 'literal', '->');
                                        if ($trace) {
                                            $traceObj->failNode(array('\'->\'',  ''));
                                        }
                                        $valid = false;
                                    }
                                    $this->parser->pos = $pos35;
                                    $this->parser->line = $line35;
                                    $nodeRes = $backup35;
                                    unset($backup35);
                                    /*
                                     * End rule: &'->'
                                     */
                                    if (!$valid) {
                                        $this->parser->matchError($error34, 'SequenceElement', $error);
                                        $error = $error34;
                                        break;
                                    }
                                    $error = array();
                                    /*
                                     * Start rule: Object
                                     *       min: 1 max: 1
                                     */
                                    if ($trace) {
                                        $traceObj->addBacktrace(array('Object', ''));
                                    }
                                    $matchRes = $this->parser->matchRule($nodeRes, 'Object', $error);
                                    if ($trace) {
                                        $remove = $traceObj->popBacktrace();
                                    }
                                    if ($matchRes) {
                                        if ($trace) {
                                            $traceObj->successNode(array('Object',  $matchRes['_text']));
                                        }
                                        $nodeRes['_text'] .= $matchRes['_text'];
                                        if(!isset($nodeRes['Object'])) {
                                            $nodeRes['Object'] = $matchRes;
                                        } else {
                                            if (!is_array($nodeRes['Object'])) {
                                                $nodeRes['Object'] = array($nodeRes['Object']);
                                            }
                                            $nodeRes['Object'][] = $matchRes;
                                        }
                                        $valid = true;
                                    } else {
                                        $valid = false;
                                        if ($trace) {
                                            $traceObj->failNode($remove);
                                        }
                                    }
                                    /*
                                     * End rule: Object
                                     */
                                    if (!$valid) {
                                        $this->parser->matchError($error34, 'SequenceElement', $error);
                                        $error = $error34;
                                        break;
                                    }
                                    break;
                                } while (true);
                                if (!$valid) {
                                    if ($trace) {
                                        $traceObj->failNode();
                                    }
                                    $this->parser->pos = $pos34;
                                    $this->parser->line = $line34;
                                    $nodeRes = $backup34;
                                } elseif ($trace) {
                                    $traceObj->successNode();
                                }
                                $error = $error34;
                                unset($backup34);
                                // end sequence
                                /*
                                 * End rule: (&'->' Object)
                                 */
                                if ($valid) {
                                    if ($trace) {
                                        $traceObj->successNode();
                                    }
                                    $error = $error27;
                                    break;
                                } else {
                                    $this->parser->logOption($errorOption27, 'Sequence', $error);
                                }
                                $error = $error27;
                                if ($trace) {
                                    $traceObj->popBacktrace();
                                }
                                break;
                            } while (true);
                            // end option
                            $iteration26 = $valid ? ($iteration26 + 1) : $iteration26;
                            if (!$valid && $iteration26 >= 0) {
                                $valid = true;
                                break;
                            }
                            if (!$valid) break;
                        } while (true);
                        /*
                         * End rule: ((../(?=([.\[]))/ Arrayelement) | (&'->' Object))*
                         */
                        if (!$valid) {
                            $this->parser->matchError($error21, 'SequenceElement', $error);
                            $error = $error21;
                            break;
                        }
                        break;
                    } while (true);
                    if (!$valid) {
                        if ($trace) {
                            $traceObj->failNode();
                        }
                        $this->parser->pos = $pos21;
                        $this->parser->line = $line21;
                        $nodeRes = $backup21;
                    } elseif ($trace) {
                        $traceObj->successNode();
                    }
                    $error = $error21;
                    unset($backup21);
                    // end sequence
                    /*
                     * End rule: (('@' property:Id)? ((../(?=([.\[]))/ Arrayelement) | (&'->' Object))*)
                     */
                    if (!$valid) {
                        $this->parser->matchError($error17, 'SequenceElement', $error);
                        $error = $error17;
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    if ($trace) {
                        $traceObj->failNode();
                    }
                    $this->parser->pos = $pos17;
                    $this->parser->line = $line17;
                    $nodeRes = $backup17;
                } elseif ($trace) {
                    $traceObj->successNode();
                }
                $error = $error17;
                unset($backup17);
                // end sequence
                if (!$valid) {
                    $this->parser->logOption($errorResult, 'Sequence', $error);
                }
                $valid = true;
                /*
                 * End rule: (../(?=([@.\[]|(->)))/ (('@' property:Id)? ((../(?=([.\[]))/ Arrayelement) | (&'->' Object))*))?
                 */
                if (!$valid) {
                    $this->parser->matchError($error7, 'SequenceElement', $error);
                    $error = $error7;
                    break;
                }
                break;
            } while (true);
            if (!$valid) {
                if ($trace) {
                    $traceObj->failNode();
                }
                $this->parser->pos = $pos7;
                $this->parser->line = $line7;
                $nodeRes = $backup7;
            } elseif ($trace) {
                $traceObj->successNode();
            }
            $error = $error7;
            unset($backup7);
            // end sequence
            /*
             * End rule: (/(?<isvar>[$])(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/ ('{' var:Variable /(\})(?<id>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*))?/)* (../(?=([@.\[]|(->)))/ (('@' property:Id)? ((../(?=([.\[]))/ Arrayelement) | (&'->' Object))*))?)
             */
            if ($valid) {
                if ($trace) {
                    $traceObj->successNode();
                }
                $error = $error0;
                break;
            } else {
                $this->parser->logOption($errorOption0, 'Sequence', $error);
            }
            $error = $error0;
            if ($trace) {
                $traceObj->popBacktrace();
            }
            break;
        } while (true);
        // end option
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
            $this->Variable_FINISH($nodeRes);
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Variable');
        }
        $this->parser->packCache[$pos0]['Variable'] = $nodeRes;
        $this->parser->errorCache[$pos0]['Variable'] = $error;
        return $nodeRes;
    }
    public function Variable_START (&$nodeRes, $previous)
    {
        $i = 1;
    }

    public function Variable_MATCH_special (&$nodeRes, $matchRes)
    {
        $nodeRes['node'] = $matchRes['node'];
    }

    public function Variable_MATCH_isvar (&$nodeRes, $matchRes)
    {
        $nodeRes['node'] = new Variable($this->parser);
    }

    public function Variable_MATCH_id (&$nodeRes, $matchRes)
    {
        $node = new String($this->parser);
        $nodeRes['node']->addSubTree($node->setValue($matchRes['_pregMatch']['id'], true)->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']), 'name', true);
    }

    public function Variable_MATCH_var (&$nodeRes, $matchRes)
    {
        $nodeRes['node']->addSubTree($matchRes['node'], 'name', true);
    }

    public function Variable_MATCH_property (&$nodeRes, $matchRes)
    {
        $nodeRes['node']->addSubTree($matchRes['_text'], 'property');
    }

    public function Variable_FINISH (&$nodeRes)
    {
        $nodeRes['node']->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
    }

    /**
     *
     * Parser rules and actions for node 'Arrayelement'
     *
     *  Rule:
     * <node Arrayelement>
     *             <rule>(('.' ( iv:Id | value:Value)) | ('['  value:Expr ']'))+</rule>
     *             <action _start>
     *             {
     *                 $nodeRes['node'] = $previous['node'];
     *             }
     *             </action>
     *             <action value>
     *             {
     *                 $nodeRes['node']->addSubTree(array('type' => 'arrayelement', 'node' => $matchRes['node']) , 'suffix', true);
     *             }
     *             </action>
     *             <action iv>
     *             {
     *                 $node = new String($this->parser);
     *                 $nodeRes['node']->addSubTree(array('type' => 'arrayelement', 'node' => $node->setValue($matchRes['_text'], true)->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']) , 'suffix', true));
     *             }
     *             </action>
     *         </node>
     * 
     *
    */
    public function matchNodeArrayelement($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->Arrayelement_START($nodeRes, $previous);
        /*
         * Start rule: (('.' (iv:Id | value:Value)) | ('[' value:Expr ']'))+
         *       min: 1 max: null
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
                 * Start rule: ('.' (iv:Id | value:Value))
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
                     * Start rule: '.'
                     *       min: 1 max: 1
                     */
                    if ('.' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $nodeRes['_text'] .= '.';
                        if ($trace) {
                            $traceObj->successNode(array('\'.\'', '.'));
                        }
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', '.');
                        if ($trace) {
                            $traceObj->failNode(array('\'.\'',  ''));
                        }
                        $valid = false;
                    }
                    /*
                     * End rule: '.'
                     */
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: (iv:Id | value:Value)
                     *       min: 1 max: 1
                     */
                    // start option
                    $error6 = $error;
                    $errorOption6 =array();
                    if ($trace) {
                        $traceObj->addBacktrace(array('_o6_', ''));
                    }
                    do {
                        $error = array();
                        if ($trace) {
                            $traceObj->popBacktrace();
                            $traceObj->addBacktrace(array('_o6:1_', ''));
                        }
                        /*
                         * Start rule: iv:Id
                         *       tag: 'iv'
                         *       min: 1 max: 1
                         */
                        if ($trace) {
                            $traceObj->addBacktrace(array('Id', ''));
                        }
                        $matchRes = $this->parser->matchRule($nodeRes, 'Id', $error);
                        if ($trace) {
                            $remove = $traceObj->popBacktrace();
                        }
                        if ($matchRes) {
                            if ($trace) {
                                $traceObj->successNode(array('Id',  $matchRes['_text']));
                            }
                            $nodeRes['_text'] .= $matchRes['_text'];
                            $this->Arrayelement_MATCH_iv($nodeRes, $matchRes);
                            $valid = true;
                        } else {
                            $valid = false;
                            if ($trace) {
                                $traceObj->failNode($remove);
                            }
                        }
                        /*
                         * End rule: iv:Id
                         */
                        if ($valid) {
                            if ($trace) {
                                $traceObj->successNode();
                            }
                            $error = $error6;
                            break;
                        } else {
                            $this->parser->logOption($errorOption6, 'Id', $error);
                        }
                        $error = array();
                        if ($trace) {
                            $traceObj->popBacktrace();
                            $traceObj->addBacktrace(array('_o6:2_', ''));
                        }
                        /*
                         * Start rule: value:Value
                         *       tag: 'value'
                         *       min: 1 max: 1
                         */
                        if ($trace) {
                            $traceObj->addBacktrace(array('Value', ''));
                        }
                        $matchRes = $this->parser->matchRule($nodeRes, 'Value', $error);
                        if ($trace) {
                            $remove = $traceObj->popBacktrace();
                        }
                        if ($matchRes) {
                            if ($trace) {
                                $traceObj->successNode(array('Value',  $matchRes['_text']));
                            }
                            $nodeRes['_text'] .= $matchRes['_text'];
                            $this->Arrayelement_MATCH_value($nodeRes, $matchRes);
                            $valid = true;
                        } else {
                            $valid = false;
                            if ($trace) {
                                $traceObj->failNode($remove);
                            }
                        }
                        /*
                         * End rule: value:Value
                         */
                        if ($valid) {
                            if ($trace) {
                                $traceObj->successNode();
                            }
                            $error = $error6;
                            break;
                        } else {
                            $this->parser->logOption($errorOption6, 'Value', $error);
                        }
                        $error = $error6;
                        if ($trace) {
                            $traceObj->popBacktrace();
                        }
                        break;
                    } while (true);
                    // end option
                    /*
                     * End rule: (iv:Id | value:Value)
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
                 * End rule: ('.' (iv:Id | value:Value))
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
                 * Start rule: ('[' value:Expr ']')
                 *       min: 1 max: 1
                 */
                // start sequence
                $backup10 = $nodeRes;
                $pos10 = $this->parser->pos;
                $line10 = $this->parser->line;
                $error10 = $error;
                if ($trace) {
                    $traceObj->addBacktrace(array('_s10_', ''));
                }
                do {
                    $error = array();
                    /*
                     * Start rule: '['
                     *       min: 1 max: 1
                     */
                    if ('[' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $nodeRes['_text'] .= '[';
                        if ($trace) {
                            $traceObj->successNode(array('\'[\'', '['));
                        }
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', '[');
                        if ($trace) {
                            $traceObj->failNode(array('\'[\'',  ''));
                        }
                        $valid = false;
                    }
                    /*
                     * End rule: '['
                     */
                    if (!$valid) {
                        $this->parser->matchError($error10, 'SequenceElement', $error);
                        $error = $error10;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: value:Expr
                     *       tag: 'value'
                     *       min: 1 max: 1
                     */
                    if ($trace) {
                        $traceObj->addBacktrace(array('Expr', ''));
                    }
                    $matchRes = $this->parser->matchRule($nodeRes, 'Expr', $error);
                    if ($trace) {
                        $remove = $traceObj->popBacktrace();
                    }
                    if ($matchRes) {
                        if ($trace) {
                            $traceObj->successNode(array('Expr',  $matchRes['_text']));
                        }
                        $nodeRes['_text'] .= $matchRes['_text'];
                        $this->Arrayelement_MATCH_value($nodeRes, $matchRes);
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $traceObj->failNode($remove);
                        }
                    }
                    /*
                     * End rule: value:Expr
                     */
                    if (!$valid) {
                        $this->parser->matchError($error10, 'SequenceElement', $error);
                        $error = $error10;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: ']'
                     *       min: 1 max: 1
                     */
                    if (']' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $nodeRes['_text'] .= ']';
                        if ($trace) {
                            $traceObj->successNode(array('\']\'', ']'));
                        }
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', ']');
                        if ($trace) {
                            $traceObj->failNode(array('\']\'',  ''));
                        }
                        $valid = false;
                    }
                    /*
                     * End rule: ']'
                     */
                    if (!$valid) {
                        $this->parser->matchError($error10, 'SequenceElement', $error);
                        $error = $error10;
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    if ($trace) {
                        $traceObj->failNode();
                    }
                    $this->parser->pos = $pos10;
                    $this->parser->line = $line10;
                    $nodeRes = $backup10;
                } elseif ($trace) {
                    $traceObj->successNode();
                }
                $error = $error10;
                unset($backup10);
                // end sequence
                /*
                 * End rule: ('[' value:Expr ']')
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
                $error = $error1;
                if ($trace) {
                    $traceObj->popBacktrace();
                }
                break;
            } while (true);
            // end option
            $iteration0 = $valid ? ($iteration0 + 1) : $iteration0;
            if (!$valid && $iteration0 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        /*
         * End rule: (('.' (iv:Id | value:Value)) | ('[' value:Expr ']'))+
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Arrayelement');
        }
        return $nodeRes;
    }
    public function Arrayelement_START (&$nodeRes, $previous)
    {
        $nodeRes['node'] = $previous['node'];
    }

    public function Arrayelement_MATCH_value (&$nodeRes, $matchRes)
    {
        $nodeRes['node']->addSubTree(array('type' => 'arrayelement', 'node' => $matchRes['node']) , 'suffix', true);
    }

    public function Arrayelement_MATCH_iv (&$nodeRes, $matchRes)
    {
        $node = new String($this->parser);
        $nodeRes['node']->addSubTree(array('type' => 'arrayelement', 'node' => $node->setValue($matchRes['_text'], true)->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']) , 'suffix', true));
    }

    /**
     *
     * Parser rules and actions for node 'Object'
     *
     *  Rule:
     * <token Object>
     *             <rule>(addsuffix:('->' ( .iv:Id | .var:Variable) method:Parameter?))+</rule>
     *             <action _start>
     *             {
     *                 $nodeRes['node'] = $previous['node'];
     *             }
     *             </action>
     *             <action iv>
     *             {
     *                 $node = new String($this->parser);
     *                 $node->setValue($matchRes['_text'], true)->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
     *                 $nodeRes['name'] = $node;
     *             }
     *             </action>
     *             <action var>
     *             {
     *                 $nodeRes['name'] = $matchRes['node'];
     *             }
     *             </action>
     *             <action method>
     *             {
     *                 $nodeRes['method'] = $matchRes['param'];
     *             }
     *             </action>
     *             <action addsuffix>
     *             {
     *                 $nodeRes['node']->addSubTree(array('type' => 'object', 'name' => $matchRes['name'], 'method' => isset($matchRes['method']) ? $matchRes['method'] : null) , 'suffix', true);
     *             }
     *             </action>
     *         </token>
     * 
     *
    */
    public function matchNodeObject($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->Object_START($nodeRes, $previous);
        /*
         * Start rule: (addsuffix:('->' (.iv:Id | .var:Variable) method:Parameter?))+
         *       min: 1 max: null
         */
        $iteration0 = 0;
        do {
            /*
             * Start rule: addsuffix:('->' (.iv:Id | .var:Variable) method:Parameter?)
             *       tag: 'addsuffix'
             *       min: 1 max: 1
             */
            // start sequence
            $backup2 = $nodeRes;
            $pos2 = $this->parser->pos;
            $line2 = $this->parser->line;
            $error2 = $error;
            if ($trace) {
                $traceObj->addBacktrace(array('_s2_', ''));
            }
            do {
                $error = array();
                /*
                 * Start rule: '->'
                 *       min: 1 max: 1
                 */
                if ('->' == substr($this->parser->source, $this->parser->pos, 2)) {
                    $this->parser->pos += 2;
                    $nodeRes['_text'] .= '->';
                    if ($trace) {
                        $traceObj->successNode(array('\'->\'', '->'));
                    }
                    $valid = true;
                } else {
                    $this->parser->matchError($error, 'literal', '->');
                    if ($trace) {
                        $traceObj->failNode(array('\'->\'',  ''));
                    }
                    $valid = false;
                }
                /*
                 * End rule: '->'
                 */
                if (!$valid) {
                    $this->parser->matchError($error2, 'SequenceElement', $error);
                    $error = $error2;
                    break;
                }
                $error = array();
                /*
                 * Start rule: (.iv:Id | .var:Variable)
                 *       min: 1 max: 1
                 */
                // start option
                $error5 = $error;
                $errorOption5 =array();
                if ($trace) {
                    $traceObj->addBacktrace(array('_o5_', ''));
                }
                do {
                    $error = array();
                    if ($trace) {
                        $traceObj->popBacktrace();
                        $traceObj->addBacktrace(array('_o5:1_', ''));
                    }
                    /*
                     * Start rule: .iv:Id
                     *       tag: 'iv'
                     *       min: 1 max: 1
                     */
                    if ($trace) {
                        $traceObj->addBacktrace(array('Id', ''));
                    }
                    $matchRes = $this->parser->matchRule($nodeRes, 'Id', $error);
                    if ($trace) {
                        $remove = $traceObj->popBacktrace();
                    }
                    if ($matchRes) {
                        if ($trace) {
                            $traceObj->successNode(array('Id',  $matchRes['_text']));
                        }
                        $this->Object_MATCH_iv($nodeRes, $matchRes);
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $traceObj->failNode($remove);
                        }
                    }
                    /*
                     * End rule: .iv:Id
                     */
                    if ($valid) {
                        if ($trace) {
                            $traceObj->successNode();
                        }
                        $error = $error5;
                        break;
                    } else {
                        $this->parser->logOption($errorOption5, 'Id', $error);
                    }
                    $error = array();
                    if ($trace) {
                        $traceObj->popBacktrace();
                        $traceObj->addBacktrace(array('_o5:2_', ''));
                    }
                    /*
                     * Start rule: .var:Variable
                     *       tag: 'var'
                     *       min: 1 max: 1
                     */
                    if ($trace) {
                        $traceObj->addBacktrace(array('Variable', ''));
                    }
                    $matchRes = $this->parser->matchRule($nodeRes, 'Variable', $error);
                    if ($trace) {
                        $remove = $traceObj->popBacktrace();
                    }
                    if ($matchRes) {
                        if ($trace) {
                            $traceObj->successNode(array('Variable',  $matchRes['_text']));
                        }
                        $this->Object_MATCH_var($nodeRes, $matchRes);
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $traceObj->failNode($remove);
                        }
                    }
                    /*
                     * End rule: .var:Variable
                     */
                    if ($valid) {
                        if ($trace) {
                            $traceObj->successNode();
                        }
                        $error = $error5;
                        break;
                    } else {
                        $this->parser->logOption($errorOption5, 'Variable', $error);
                    }
                    $error = $error5;
                    if ($trace) {
                        $traceObj->popBacktrace();
                    }
                    break;
                } while (true);
                // end option
                /*
                 * End rule: (.iv:Id | .var:Variable)
                 */
                if (!$valid) {
                    $this->parser->matchError($error2, 'SequenceElement', $error);
                    $error = $error2;
                    break;
                }
                $error = array();
                /*
                 * Start rule: method:Parameter?
                 *       tag: 'method'
                 *       min: 0 max: 1
                 */
                $error = array();
                if ($trace) {
                    $traceObj->addBacktrace(array('Parameter', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'Parameter', $error);
                if ($trace) {
                    $remove = $traceObj->popBacktrace();
                }
                if ($matchRes) {
                    if ($trace) {
                        $traceObj->successNode(array('Parameter',  $matchRes['_text']));
                    }
                    $nodeRes['_text'] .= $matchRes['_text'];
                    $this->Object_MATCH_method($nodeRes, $matchRes);
                    $valid = true;
                } else {
                    $valid = false;
                    if ($trace) {
                        $traceObj->failNode($remove);
                    }
                }
                if (!$valid) {
                    $this->parser->logOption($errorResult, 'Parameter', $error);
                }
                $valid = true;
                /*
                 * End rule: method:Parameter?
                 */
                if (!$valid) {
                    $this->parser->matchError($error2, 'SequenceElement', $error);
                    $error = $error2;
                    break;
                }
                break;
            } while (true);
            if (!$valid) {
                if ($trace) {
                    $traceObj->failNode();
                }
                $this->parser->pos = $pos2;
                $this->parser->line = $line2;
                $nodeRes = $backup2;
            } elseif ($trace) {
                $traceObj->successNode();
            }
            $error = $error2;
            if ($valid) {
                $backup2['_text'] .= $nodeRes['_text'];
                $this->Object_MATCH_addsuffix($backup2, $nodeRes);
            }
            $nodeRes = $backup2;
            unset($backup2);
            // end sequence
            /*
             * End rule: addsuffix:('->' (.iv:Id | .var:Variable) method:Parameter?)
             */
            $iteration0 = $valid ? ($iteration0 + 1) : $iteration0;
            if (!$valid && $iteration0 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        /*
         * End rule: (addsuffix:('->' (.iv:Id | .var:Variable) method:Parameter?))+
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Object');
        }
        return $nodeRes;
    }
    public function Object_START (&$nodeRes, $previous)
    {
        $nodeRes['node'] = $previous['node'];
    }

    public function Object_MATCH_iv (&$nodeRes, $matchRes)
    {
        $node = new String($this->parser);
        $node->setValue($matchRes['_text'], true)->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
        $nodeRes['name'] = $node;
    }

    public function Object_MATCH_var (&$nodeRes, $matchRes)
    {
        $nodeRes['name'] = $matchRes['node'];
    }

    public function Object_MATCH_method (&$nodeRes, $matchRes)
    {
        $nodeRes['method'] = $matchRes['param'];
    }

    public function Object_MATCH_addsuffix (&$nodeRes, $matchRes)
    {
        $nodeRes['node']->addSubTree(array('type' => 'object', 'name' => $matchRes['name'], 'method' => isset($matchRes['method']) ? $matchRes['method'] : null) , 'suffix', true);
    }


}
