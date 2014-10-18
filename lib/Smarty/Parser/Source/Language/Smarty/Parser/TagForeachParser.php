<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Peg\RuleRoot;

/**
 * Class RuleRoot;
 *
 * @package Smarty\Source\Smarty\Nodes\foreachTag
 */
class TagForeachParser extends RuleRoot
{
   
    /**
     *
     * Parser generated on 2014-09-04 02:35:36
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/TagForeach.peg.inc' dated 2014-08-22 04:53:54
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
            "TagForeach" => "matchNodeTagForeach",
            "elseTagforeach" => "matchNodeelseTagforeach"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "TagForeach" => array(
                    "attributes" => array(
                            "required" => array(
                                    "from" => true,
                                    "item" => true
                                ),
                            "optional" => array(
                                    "key" => true
                                ),
                            "subtags" => array(
                                    "foreachelse" => true
                                )
                        ),
                    "options" => "nocache"
                )
        );
    /**
     *
     * Parser rules and actions for node 'TagForeach'
     *
     *  Rule:
     * 
     * 
     *             <node TagForeach>
     *                 <attribute>attributes=(required=(from,item),optional=(key),subtags=(foreachelse)),options=nocache</attribute>
     *                 <rule>tag:(Ldel 'foreach' _  from:Value _ 'as' _ (key:Variable _? '=>' _?)? item:Variable (!Rdel SmartyTagOptions)? Rdel) | ..Smarty_Tag_Default body:Body? (!LdelSlash ..elseTagforeach)? close:SmartyBlockCloseTag</rule>
     *                 <action _start>
     *                 {
     *                     $nodeRes['node'] = $previous['node'];
     *                 }
     *                 </action>
     *                 <action from>
     *                 {
     *                     $nodeRes['node']->setTagAttribute(array('from', $matchRes['node']));
     *                 }
     *                 </action>
     *                 <action key>
     *                 {
     *                     $nodeRes['key'] = $matchRes['node'];
     *                 }
     *                 </action>
     *                 <action item>
     *                 {
     *                     $nodeRes['node']->setTagAttribute(array('item', $matchRes['node']));
     *                 }
     *                 </action>
     *                 <action _finish>
     *                 {
     *                     if (isset($nodeRes['key'])) {
     *                         $nodeRes['node']->setTagAttribute(array('key', $nodeRes['key']));
     *                     }
     *                 }
     *                 </action>
     *                 <action body>
     *                 {
     *                     $nodeRes['node']->addSubTree($matchRes['node'],'foreach');
     *                 }
     *                 </action>
     *             </node>
     * 
     *
    */
    public function matchNodeTagForeach($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->TagForeach_START($nodeRes, $previous);
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
                 * Start rule: tag:(Ldel 'foreach' _ from:Value _ 'as' _ (key:Variable _? '=>' _?)? item:Variable (!Rdel SmartyTagOptions)? Rdel)
                 *       tag: 'tag'
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
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: 'foreach'
                     *       min: 1 max: 1
                     */
                    if ('foreach' == substr($this->parser->source, $this->parser->pos, 7)) {
                        $this->parser->pos += 7;
                        $nodeRes['_text'] .= 'foreach';
                        if ($trace) {
                            $traceObj->successNode(array('\'foreach\'', 'foreach'));
                        }
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', 'foreach');
                        if ($trace) {
                            $traceObj->failNode(array('\'foreach\'',  ''));
                        }
                        $valid = false;
                    }
                    /*
                     * End rule: 'foreach'
                     */
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: _
                     *       min: 1 max: 1
                     */
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                        if (!empty($pregMatch[0])) {
                            $this->parser->pos += strlen($pregMatch[0]);
                            $this->parser->line += substr_count($pregMatch[0], "\n");
                            $nodeRes['_text'] .= ' ';
                            $valid = true;
                        } else {
                            $valid = false;
                        }
                    } else {
                        $valid = false;
                    }
                    if ($valid) {
                        if ($trace) {
                            $traceObj->successNode(array("' '",  ' '));
                        }
                    } else {
                        if ($trace) {
                            $traceObj->failNode(array("' '",  ''));
                        }
                    }
                    /*
                     * End rule: _
                     */
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: from:Value
                     *       tag: 'from'
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
                        $this->TagForeach_MATCH_from($nodeRes, $matchRes);
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $traceObj->failNode($remove);
                        }
                    }
                    /*
                     * End rule: from:Value
                     */
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: _
                     *       min: 1 max: 1
                     */
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                        if (!empty($pregMatch[0])) {
                            $this->parser->pos += strlen($pregMatch[0]);
                            $this->parser->line += substr_count($pregMatch[0], "\n");
                            $nodeRes['_text'] .= ' ';
                            $valid = true;
                        } else {
                            $valid = false;
                        }
                    } else {
                        $valid = false;
                    }
                    if ($valid) {
                        if ($trace) {
                            $traceObj->successNode(array("' '",  ' '));
                        }
                    } else {
                        if ($trace) {
                            $traceObj->failNode(array("' '",  ''));
                        }
                    }
                    /*
                     * End rule: _
                     */
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: 'as'
                     *       min: 1 max: 1
                     */
                    if ('as' == substr($this->parser->source, $this->parser->pos, 2)) {
                        $this->parser->pos += 2;
                        $nodeRes['_text'] .= 'as';
                        if ($trace) {
                            $traceObj->successNode(array('\'as\'', 'as'));
                        }
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', 'as');
                        if ($trace) {
                            $traceObj->failNode(array('\'as\'',  ''));
                        }
                        $valid = false;
                    }
                    /*
                     * End rule: 'as'
                     */
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: _
                     *       min: 1 max: 1
                     */
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                        if (!empty($pregMatch[0])) {
                            $this->parser->pos += strlen($pregMatch[0]);
                            $this->parser->line += substr_count($pregMatch[0], "\n");
                            $nodeRes['_text'] .= ' ';
                            $valid = true;
                        } else {
                            $valid = false;
                        }
                    } else {
                        $valid = false;
                    }
                    if ($valid) {
                        if ($trace) {
                            $traceObj->successNode(array("' '",  ' '));
                        }
                    } else {
                        if ($trace) {
                            $traceObj->failNode(array("' '",  ''));
                        }
                    }
                    /*
                     * End rule: _
                     */
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: (key:Variable _? '=>' _?)?
                     *       min: 0 max: 1
                     */
                    $error = array();
                    // start sequence
                    $backup12 = $nodeRes;
                    $pos12 = $this->parser->pos;
                    $line12 = $this->parser->line;
                    $error12 = $error;
                    if ($trace) {
                        $traceObj->addBacktrace(array('_s12_', ''));
                    }
                    do {
                        $error = array();
                        /*
                         * Start rule: key:Variable
                         *       tag: 'key'
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
                            $this->TagForeach_MATCH_key($nodeRes, $matchRes);
                            $valid = true;
                        } else {
                            $valid = false;
                            if ($trace) {
                                $traceObj->failNode($remove);
                            }
                        }
                        /*
                         * End rule: key:Variable
                         */
                        if (!$valid) {
                            $this->parser->matchError($error12, 'SequenceElement', $error);
                            $error = $error12;
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
                            $this->parser->matchError($error12, 'SequenceElement', $error);
                            $error = $error12;
                            break;
                        }
                        $error = array();
                        /*
                         * Start rule: '=>'
                         *       min: 1 max: 1
                         */
                        if ('=>' == substr($this->parser->source, $this->parser->pos, 2)) {
                            $this->parser->pos += 2;
                            $nodeRes['_text'] .= '=>';
                            if ($trace) {
                                $traceObj->successNode(array('\'=>\'', '=>'));
                            }
                            $valid = true;
                        } else {
                            $this->parser->matchError($error, 'literal', '=>');
                            if ($trace) {
                                $traceObj->failNode(array('\'=>\'',  ''));
                            }
                            $valid = false;
                        }
                        /*
                         * End rule: '=>'
                         */
                        if (!$valid) {
                            $this->parser->matchError($error12, 'SequenceElement', $error);
                            $error = $error12;
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
                            $this->parser->matchError($error12, 'SequenceElement', $error);
                            $error = $error12;
                            break;
                        }
                        break;
                    } while (true);
                    if (!$valid) {
                        if ($trace) {
                            $traceObj->failNode();
                        }
                        $this->parser->pos = $pos12;
                        $this->parser->line = $line12;
                        $nodeRes = $backup12;
                    } elseif ($trace) {
                        $traceObj->successNode();
                    }
                    $error = $error12;
                    unset($backup12);
                    // end sequence
                    if (!$valid) {
                        $this->parser->logOption($errorResult, 'Sequence', $error);
                    }
                    $valid = true;
                    /*
                     * End rule: (key:Variable _? '=>' _?)?
                     */
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: item:Variable
                     *       tag: 'item'
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
                        $this->TagForeach_MATCH_item($nodeRes, $matchRes);
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $traceObj->failNode($remove);
                        }
                    }
                    /*
                     * End rule: item:Variable
                     */
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: (!Rdel SmartyTagOptions)?
                     *       min: 0 max: 1
                     */
                    $error = array();
                    // start sequence
                    $backup19 = $nodeRes;
                    $pos19 = $this->parser->pos;
                    $line19 = $this->parser->line;
                    $error19 = $error;
                    if ($trace) {
                        $traceObj->addBacktrace(array('_s19_', ''));
                    }
                    do {
                        $error = array();
                        /*
                         * Start rule: !Rdel
                         *       min: 1 max: 1
                         *       look ahead: 'negative'
                         */
                        $backup20 = $nodeRes;
                        $pos20 = $this->parser->pos;
                        $line20 = $this->parser->line;
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
                            if(!isset($nodeRes['Rdel'])) {
                                $nodeRes['Rdel'] = $matchRes;
                            } else {
                                if (!is_array($nodeRes['Rdel'])) {
                                    $nodeRes['Rdel'] = array($nodeRes['Rdel']);
                                }
                                $nodeRes['Rdel'][] = $matchRes;
                            }
                            $valid = false;
                        } else {
                            $valid = true;
                            if ($trace) {
                                $traceObj->failNode($remove);
                            }
                        }
                        $this->parser->pos = $pos20;
                        $this->parser->line = $line20;
                        $nodeRes = $backup20;
                        unset($backup20);
                        /*
                         * End rule: !Rdel
                         */
                        if (!$valid) {
                            $this->parser->matchError($error19, 'SequenceElement', $error);
                            $error = $error19;
                            break;
                        }
                        $error = array();
                        /*
                         * Start rule: SmartyTagOptions
                         *       min: 1 max: 1
                         */
                        if ($trace) {
                            $traceObj->addBacktrace(array('SmartyTagOptions', ''));
                        }
                        $matchRes = $this->parser->matchRule($nodeRes, 'SmartyTagOptions', $error);
                        if ($trace) {
                            $remove = $traceObj->popBacktrace();
                        }
                        if ($matchRes) {
                            if ($trace) {
                                $traceObj->successNode(array('SmartyTagOptions',  $matchRes['_text']));
                            }
                            $nodeRes['_text'] .= $matchRes['_text'];
                            if(!isset($nodeRes['SmartyTagOptions'])) {
                                $nodeRes['SmartyTagOptions'] = $matchRes;
                            } else {
                                if (!is_array($nodeRes['SmartyTagOptions'])) {
                                    $nodeRes['SmartyTagOptions'] = array($nodeRes['SmartyTagOptions']);
                                }
                                $nodeRes['SmartyTagOptions'][] = $matchRes;
                            }
                            $valid = true;
                        } else {
                            $valid = false;
                            if ($trace) {
                                $traceObj->failNode($remove);
                            }
                        }
                        /*
                         * End rule: SmartyTagOptions
                         */
                        if (!$valid) {
                            $this->parser->matchError($error19, 'SequenceElement', $error);
                            $error = $error19;
                            break;
                        }
                        break;
                    } while (true);
                    if (!$valid) {
                        if ($trace) {
                            $traceObj->failNode();
                        }
                        $this->parser->pos = $pos19;
                        $this->parser->line = $line19;
                        $nodeRes = $backup19;
                    } elseif ($trace) {
                        $traceObj->successNode();
                    }
                    $error = $error19;
                    unset($backup19);
                    // end sequence
                    if (!$valid) {
                        $this->parser->logOption($errorResult, 'Sequence', $error);
                    }
                    $valid = true;
                    /*
                     * End rule: (!Rdel SmartyTagOptions)?
                     */
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
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
                if ($valid) {
                    $backup3['_text'] .= $nodeRes['_text'];
                    if(!isset($backup3['tag'])) {
                        $backup3['tag'] = $nodeRes;
                    } else {
                        if (!is_array($backup3['tag'])) {
                            $backup3['tag'] = array($backup3['tag']);
                        }
                        $backup3['tag'][] = $nodeRes;
                    }
                }
                $nodeRes = $backup3;
                unset($backup3);
                // end sequence
                /*
                 * End rule: tag:(Ldel 'foreach' _ from:Value _ 'as' _ (key:Variable _? '=>' _?)? item:Variable (!Rdel SmartyTagOptions)? Rdel)
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
                 * Start rule: ..Smarty_Tag_Default
                 *       min: 1 max: 1
                 */
                if ($trace) {
                    $traceObj->addBacktrace(array('Smarty_Tag_Default', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'Smarty_Tag_Default', $error);
                if ($trace) {
                    $remove = $traceObj->popBacktrace();
                }
                if ($matchRes) {
                    if ($trace) {
                        $traceObj->successNode(array('Smarty_Tag_Default',  $matchRes['_text']));
                    }
                    if(!isset($nodeRes['Smarty_Tag_Default'])) {
                        $nodeRes['Smarty_Tag_Default'] = $matchRes;
                    } else {
                        if (!is_array($nodeRes['Smarty_Tag_Default'])) {
                            $nodeRes['Smarty_Tag_Default'] = array($nodeRes['Smarty_Tag_Default']);
                        }
                        $nodeRes['Smarty_Tag_Default'][] = $matchRes;
                    }
                    $valid = true;
                } else {
                    $valid = false;
                    if ($trace) {
                        $traceObj->failNode($remove);
                    }
                }
                /*
                 * End rule: ..Smarty_Tag_Default
                 */
                if ($valid) {
                    if ($trace) {
                        $traceObj->successNode();
                    }
                    $error = $error1;
                    break;
                } else {
                    $this->parser->logOption($errorOption1, 'Smarty_Tag_Default', $error);
                }
                $error = $error1;
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
            $error = array();
            /*
             * Start rule: body:Body?
             *       tag: 'body'
             *       min: 0 max: 1
             */
            $error = array();
            if ($trace) {
                $traceObj->addBacktrace(array('Body', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'Body', $error);
            if ($trace) {
                $remove = $traceObj->popBacktrace();
            }
            if ($matchRes) {
                if ($trace) {
                    $traceObj->successNode(array('Body',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                $this->TagForeach_MATCH_body($nodeRes, $matchRes);
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $traceObj->failNode($remove);
                }
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, 'Body', $error);
            }
            $valid = true;
            /*
             * End rule: body:Body?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: (!LdelSlash ..elseTagforeach)?
             *       min: 0 max: 1
             */
            $error = array();
            // start sequence
            $backup26 = $nodeRes;
            $pos26 = $this->parser->pos;
            $line26 = $this->parser->line;
            $error26 = $error;
            if ($trace) {
                $traceObj->addBacktrace(array('_s26_', ''));
            }
            do {
                $error = array();
                /*
                 * Start rule: !LdelSlash
                 *       min: 1 max: 1
                 *       look ahead: 'negative'
                 */
                $backup27 = $nodeRes;
                $pos27 = $this->parser->pos;
                $line27 = $this->parser->line;
                if ($trace) {
                    $traceObj->addBacktrace(array('LdelSlash', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'LdelSlash', $error);
                if ($trace) {
                    $remove = $traceObj->popBacktrace();
                }
                if ($matchRes) {
                    if ($trace) {
                        $traceObj->successNode(array('LdelSlash',  $matchRes['_text']));
                    }
                    if(!isset($nodeRes['LdelSlash'])) {
                        $nodeRes['LdelSlash'] = $matchRes;
                    } else {
                        if (!is_array($nodeRes['LdelSlash'])) {
                            $nodeRes['LdelSlash'] = array($nodeRes['LdelSlash']);
                        }
                        $nodeRes['LdelSlash'][] = $matchRes;
                    }
                    $valid = false;
                } else {
                    $valid = true;
                    if ($trace) {
                        $traceObj->failNode($remove);
                    }
                }
                $this->parser->pos = $pos27;
                $this->parser->line = $line27;
                $nodeRes = $backup27;
                unset($backup27);
                /*
                 * End rule: !LdelSlash
                 */
                if (!$valid) {
                    $this->parser->matchError($error26, 'SequenceElement', $error);
                    $error = $error26;
                    break;
                }
                $error = array();
                /*
                 * Start rule: ..elseTagforeach
                 *       min: 1 max: 1
                 */
                if ($trace) {
                    $traceObj->addBacktrace(array('elseTagforeach', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'elseTagforeach', $error);
                if ($trace) {
                    $remove = $traceObj->popBacktrace();
                }
                if ($matchRes) {
                    if ($trace) {
                        $traceObj->successNode(array('elseTagforeach',  $matchRes['_text']));
                    }
                    if(!isset($nodeRes['elseTagforeach'])) {
                        $nodeRes['elseTagforeach'] = $matchRes;
                    } else {
                        if (!is_array($nodeRes['elseTagforeach'])) {
                            $nodeRes['elseTagforeach'] = array($nodeRes['elseTagforeach']);
                        }
                        $nodeRes['elseTagforeach'][] = $matchRes;
                    }
                    $valid = true;
                } else {
                    $valid = false;
                    if ($trace) {
                        $traceObj->failNode($remove);
                    }
                }
                /*
                 * End rule: ..elseTagforeach
                 */
                if (!$valid) {
                    $this->parser->matchError($error26, 'SequenceElement', $error);
                    $error = $error26;
                    break;
                }
                break;
            } while (true);
            if (!$valid) {
                if ($trace) {
                    $traceObj->failNode();
                }
                $this->parser->pos = $pos26;
                $this->parser->line = $line26;
                $nodeRes = $backup26;
            } elseif ($trace) {
                $traceObj->successNode();
            }
            $error = $error26;
            unset($backup26);
            // end sequence
            if (!$valid) {
                $this->parser->logOption($errorResult, 'Sequence', $error);
            }
            $valid = true;
            /*
             * End rule: (!LdelSlash ..elseTagforeach)?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: close:SmartyBlockCloseTag
             *       tag: 'close'
             *       min: 1 max: 1
             */
            if ($trace) {
                $traceObj->addBacktrace(array('SmartyBlockCloseTag', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'SmartyBlockCloseTag', $error);
            if ($trace) {
                $remove = $traceObj->popBacktrace();
            }
            if ($matchRes) {
                if ($trace) {
                    $traceObj->successNode(array('SmartyBlockCloseTag',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                if(!isset($nodeRes['close'])) {
                    $nodeRes['close'] = $matchRes;
                } else {
                    if (!is_array($nodeRes['close'])) {
                        $nodeRes['close'] = array($nodeRes['close']);
                    }
                    $nodeRes['close'][] = $matchRes;
                }
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $traceObj->failNode($remove);
                }
            }
            /*
             * End rule: close:SmartyBlockCloseTag
             */
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
            $this->TagForeach_FINISH($nodeRes);
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'TagForeach');
        }
        return $nodeRes;
    }
    public function TagForeach_START (&$nodeRes, $previous)
    {
        $nodeRes['node'] = $previous['node'];
    }

    public function TagForeach_MATCH_from (&$nodeRes, $matchRes)
    {
        $nodeRes['node']->setTagAttribute(array('from', $matchRes['node']));
    }

    public function TagForeach_MATCH_key (&$nodeRes, $matchRes)
    {
        $nodeRes['key'] = $matchRes['node'];
    }

    public function TagForeach_MATCH_item (&$nodeRes, $matchRes)
    {
        $nodeRes['node']->setTagAttribute(array('item', $matchRes['node']));
    }

    public function TagForeach_MATCH_body (&$nodeRes, $matchRes)
    {
        $nodeRes['node']->addSubTree($matchRes['node'],'foreach');
    }

    public function TagForeach_FINISH (&$nodeRes)
    {
        if (isset($nodeRes['key']))        {
            $nodeRes['node']->setTagAttribute(array('key', $nodeRes['key']));
        }
    }

    /**
     *
     * Parser rules and actions for node 'elseTagforeach'
     *
     *  Rule:
     * <token elseTagforeach>
     *                 <rule>Ldel 'foreachelse'  Rdel body:Body?</rule>
     *                 <action _start>
     *                  {
     *                     $nodeRes['node'] = $previous['node'];
     *                  }
     *                 </action>
     *                 <action body>
     *                 {
     *                     $nodeRes['node']->addSubTree($matchRes['node'],'foreachelse');
     *                 }
     *                 </action>
     *             </token>
     * 
     *
    */
    public function matchNodeelseTagforeach($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->elseTagforeach_START($nodeRes, $previous);
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
             * Start rule: 'foreachelse'
             *       min: 1 max: 1
             */
            if ('foreachelse' == substr($this->parser->source, $this->parser->pos, 11)) {
                $this->parser->pos += 11;
                $nodeRes['_text'] .= 'foreachelse';
                if ($trace) {
                    $traceObj->successNode(array('\'foreachelse\'', 'foreachelse'));
                }
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', 'foreachelse');
                if ($trace) {
                    $traceObj->failNode(array('\'foreachelse\'',  ''));
                }
                $valid = false;
            }
            /*
             * End rule: 'foreachelse'
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
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
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: body:Body?
             *       tag: 'body'
             *       min: 0 max: 1
             */
            $error = array();
            if ($trace) {
                $traceObj->addBacktrace(array('Body', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'Body', $error);
            if ($trace) {
                $remove = $traceObj->popBacktrace();
            }
            if ($matchRes) {
                if ($trace) {
                    $traceObj->successNode(array('Body',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                $this->elseTagforeach_MATCH_body($nodeRes, $matchRes);
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $traceObj->failNode($remove);
                }
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, 'Body', $error);
            }
            $valid = true;
            /*
             * End rule: body:Body?
             */
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
            $this->parser->matchError($errorResult, 'token', $error, 'elseTagforeach');
        }
        return $nodeRes;
    }
    public function elseTagforeach_START (&$nodeRes, $previous)
    {
        $nodeRes['node'] = $previous['node'];
    }

    public function elseTagforeach_MATCH_body (&$nodeRes, $matchRes)
    {
        $nodeRes['node']->addSubTree($matchRes['node'],'foreachelse');
    }


}

