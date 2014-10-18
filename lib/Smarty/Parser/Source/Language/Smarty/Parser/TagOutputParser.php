<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Tag\TagOutput;
use Smarty\Parser\Peg\RuleRoot;

/**
 * Class TagOutputParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagOutputParser extends RuleRoot
{
   
    /**
     *
     * Parser generated on 2014-09-04 02:35:36
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/TagOutput.peg.inc' dated 2014-09-03 23:21:05
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
            "TagOutput" => "matchNodeTagOutput"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array();
    /**
     *
     * Parser rules and actions for node 'TagOutput'
     *
     *  Rule:
     * 
     *              <node TagOutput>
     *                  <rule>Ldel _? (value:ModifierValue Rdel) | (value:Expr Rdel)</rule>
     *                  <action value>
     *                  {
     *                      $nodeRes['node'] = new TagOutput($this->parser);
     *                      $nodeRes['node']->addSubTree($matchRes['node'], 'value');
     *                      $nodeRes['node']->setTraceInfo($nodeRes['_lineno'], '', $nodeRes['_startpos'], $nodeRes['_endpos']);
     *                  }
     *                  </action>
     *              </node>
     * 
     *
    */
    public function matchNodeTagOutput($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        // start sequence
        $backup0 = $nodeRes;
        $pos0 = $this->parser->pos;
        $line0 = $this->parser->line;
        $error0 = $error;
        if ($trace) {
            $traceObj->addBacktrace(array('_s0_', ''));
        }
        do {
            $error = array();
            /*
             * Start rule: Ldel
             *       min: 1 max: 1
             */
            if ($trace) {
                $traceObj->addBacktrace(array('Ldel', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'Ldel', $error);
            if ($trace) {
                $remove = $traceObj->popBacktrace();
            }
            if ($matchRes) {
                if ($trace) {
                    $traceObj->successNode(array('Ldel',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                if(!isset($nodeRes['Ldel'])) {
                    $nodeRes['Ldel'] = $matchRes;
                } else {
                    if (!is_array($nodeRes['Ldel'])) {
                        $nodeRes['Ldel'] = array($nodeRes['Ldel']);
                    }
                    $nodeRes['Ldel'][] = $matchRes;
                }
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $traceObj->failNode($remove);
                }
            }
            /*
             * End rule: Ldel
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: _?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                    $nodeRes['_text'] .= ' ';
                }
            }
            if ($trace) {
                $traceObj->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: _?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            // start option
            $error3 = $error;
            $errorOption3 =array();
            if ($trace) {
                $traceObj->addBacktrace(array('_o3_', ''));
            }
            do {
                $error = array();
                if ($trace) {
                    $traceObj->popBacktrace();
                    $traceObj->addBacktrace(array('_o3:1_', ''));
                }
                /*
                 * Start rule: (value:ModifierValue Rdel)
                 *       min: 1 max: 1
                 */
                // start sequence
                $backup5 = $nodeRes;
                $pos5 = $this->parser->pos;
                $line5 = $this->parser->line;
                $error5 = $error;
                if ($trace) {
                    $traceObj->addBacktrace(array('_s5_', ''));
                }
                do {
                    $error = array();
                    /*
                     * Start rule: value:ModifierValue
                     *       tag: 'value'
                     *       min: 1 max: 1
                     */
                    if ($trace) {
                        $traceObj->addBacktrace(array('ModifierValue', ''));
                    }
                    $matchRes = $this->parser->matchRule($nodeRes, 'ModifierValue', $error);
                    if ($trace) {
                        $remove = $traceObj->popBacktrace();
                    }
                    if ($matchRes) {
                        if ($trace) {
                            $traceObj->successNode(array('ModifierValue',  $matchRes['_text']));
                        }
                        $nodeRes['_text'] .= $matchRes['_text'];
                        $this->TagOutput_MATCH_value($nodeRes, $matchRes);
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $traceObj->failNode($remove);
                        }
                    }
                    /*
                     * End rule: value:ModifierValue
                     */
                    if (!$valid) {
                        $this->parser->matchError($error5, 'SequenceElement', $error);
                        $error = $error5;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: Rdel
                     *       min: 1 max: 1
                     */
                    if ($trace) {
                        $traceObj->addBacktrace(array('Rdel', ''));
                    }
                    $matchRes = $this->parser->matchRule($nodeRes, 'Rdel', $error);
                    if ($trace) {
                        $remove = $traceObj->popBacktrace();
                    }
                    if ($matchRes) {
                        if ($trace) {
                            $traceObj->successNode(array('Rdel',  $matchRes['_text']));
                        }
                        $nodeRes['_text'] .= $matchRes['_text'];
                        if(!isset($nodeRes['Rdel'])) {
                            $nodeRes['Rdel'] = $matchRes;
                        } else {
                            if (!is_array($nodeRes['Rdel'])) {
                                $nodeRes['Rdel'] = array($nodeRes['Rdel']);
                            }
                            $nodeRes['Rdel'][] = $matchRes;
                        }
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $traceObj->failNode($remove);
                        }
                    }
                    /*
                     * End rule: Rdel
                     */
                    if (!$valid) {
                        $this->parser->matchError($error5, 'SequenceElement', $error);
                        $error = $error5;
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    if ($trace) {
                        $traceObj->failNode();
                    }
                    $this->parser->pos = $pos5;
                    $this->parser->line = $line5;
                    $nodeRes = $backup5;
                } elseif ($trace) {
                    $traceObj->successNode();
                }
                $error = $error5;
                unset($backup5);
                // end sequence
                /*
                 * End rule: (value:ModifierValue Rdel)
                 */
                if ($valid) {
                    if ($trace) {
                        $traceObj->successNode();
                    }
                    $error = $error3;
                    break;
                } else {
                    $this->parser->logOption($errorOption3, 'Sequence', $error);
                }
                $error = array();
                if ($trace) {
                    $traceObj->popBacktrace();
                    $traceObj->addBacktrace(array('_o3:2_', ''));
                }
                /*
                 * Start rule: (value:Expr Rdel)
                 *       min: 1 max: 1
                 */
                // start sequence
                $backup9 = $nodeRes;
                $pos9 = $this->parser->pos;
                $line9 = $this->parser->line;
                $error9 = $error;
                if ($trace) {
                    $traceObj->addBacktrace(array('_s9_', ''));
                }
                do {
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
                        $this->TagOutput_MATCH_value($nodeRes, $matchRes);
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
                        $this->parser->matchError($error9, 'SequenceElement', $error);
                        $error = $error9;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: Rdel
                     *       min: 1 max: 1
                     */
                    if ($trace) {
                        $traceObj->addBacktrace(array('Rdel', ''));
                    }
                    $matchRes = $this->parser->matchRule($nodeRes, 'Rdel', $error);
                    if ($trace) {
                        $remove = $traceObj->popBacktrace();
                    }
                    if ($matchRes) {
                        if ($trace) {
                            $traceObj->successNode(array('Rdel',  $matchRes['_text']));
                        }
                        $nodeRes['_text'] .= $matchRes['_text'];
                        if(!isset($nodeRes['Rdel'])) {
                            $nodeRes['Rdel'] = $matchRes;
                        } else {
                            if (!is_array($nodeRes['Rdel'])) {
                                $nodeRes['Rdel'] = array($nodeRes['Rdel']);
                            }
                            $nodeRes['Rdel'][] = $matchRes;
                        }
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $traceObj->failNode($remove);
                        }
                    }
                    /*
                     * End rule: Rdel
                     */
                    if (!$valid) {
                        $this->parser->matchError($error9, 'SequenceElement', $error);
                        $error = $error9;
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    if ($trace) {
                        $traceObj->failNode();
                    }
                    $this->parser->pos = $pos9;
                    $this->parser->line = $line9;
                    $nodeRes = $backup9;
                } elseif ($trace) {
                    $traceObj->successNode();
                }
                $error = $error9;
                unset($backup9);
                // end sequence
                /*
                 * End rule: (value:Expr Rdel)
                 */
                if ($valid) {
                    if ($trace) {
                        $traceObj->successNode();
                    }
                    $error = $error3;
                    break;
                } else {
                    $this->parser->logOption($errorOption3, 'Sequence', $error);
                }
                $error = $error3;
                if ($trace) {
                    $traceObj->popBacktrace();
                }
                break;
            } while (true);
            // end option
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            if ($trace) {
                $traceObj->failNode();
            }
            $this->parser->pos = $pos0;
            $this->parser->line = $line0;
            $nodeRes = $backup0;
        } elseif ($trace) {
            $traceObj->successNode();
        }
        $error = $error0;
        unset($backup0);
        // end sequence
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'TagOutput');
        }
        return $nodeRes;
    }
    public function TagOutput_MATCH_value (&$nodeRes, $matchRes)
    {
        $nodeRes['node'] = new TagOutput($this->parser);
        $nodeRes['node']->addSubTree($matchRes['node'], 'value');
        $nodeRes['node']->setTraceInfo($nodeRes['_lineno'], '', $nodeRes['_startpos'], $nodeRes['_endpos']);
    }


}

