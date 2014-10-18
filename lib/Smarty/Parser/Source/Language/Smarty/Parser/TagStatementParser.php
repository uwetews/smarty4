<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Peg\RuleRoot;

/**
 * Class TagStatementParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagStatementParser extends RuleRoot
{
   
    /**
     *
     * Parser generated on 2014-09-04 02:35:35
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/TagStatement.peg.inc' dated 2014-08-22 04:53:53
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
            "TagStatement" => "matchNodeTagStatement"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "TagStatement" => array(
                    "attributes" => array(
                            "required" => array(
                                    "variable" => true,
                                    "value" => true
                                ),
                            "optional" => array(
                                    "append" => true,
                                    "istag" => true
                                )
                        ),
                    "options" => array(
                            "nocache" => true,
                            "cachevalue" => true
                        )
                )
        );
    /**
     *
     * Parser rules and actions for node 'TagStatement'
     *
     *  Rule:
     * 
     *              <node TagStatement>
     *                 <attribute>attributes=(required=(variable,value),optional=(append,istag)),options=(nocache,cachevalue)</attribute>
     *                  <rule>Ldel statement:Statement SmartyTagAttributes SmartyTagOptions Rdel</rule>
     *                  <action statement>
     *                  {
     *                      $nodeRes['node'] = $matchRes['node'];
     *                      $nodeRes['node']->setTagAttribute(array('istag', true));
     *                  }
     *                  </action>
     *              </node>
     * 
     *
    */
    public function matchNodeTagStatement($previous, &$errorResult){
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
             * Start rule: statement:Statement
             *       tag: 'statement'
             *       min: 1 max: 1
             */
            if ($trace) {
                $traceObj->addBacktrace(array('Statement', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'Statement', $error);
            if ($trace) {
                $remove = $traceObj->popBacktrace();
            }
            if ($matchRes) {
                if ($trace) {
                    $traceObj->successNode(array('Statement',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                $this->TagStatement_MATCH_statement($nodeRes, $matchRes);
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $traceObj->failNode($remove);
                }
            }
            /*
             * End rule: statement:Statement
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: SmartyTagAttributes
             *       min: 1 max: 1
             */
            if ($trace) {
                $traceObj->addBacktrace(array('SmartyTagAttributes', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'SmartyTagAttributes', $error);
            if ($trace) {
                $remove = $traceObj->popBacktrace();
            }
            if ($matchRes) {
                if ($trace) {
                    $traceObj->successNode(array('SmartyTagAttributes',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                if(!isset($nodeRes['SmartyTagAttributes'])) {
                    $nodeRes['SmartyTagAttributes'] = $matchRes;
                } else {
                    if (!is_array($nodeRes['SmartyTagAttributes'])) {
                        $nodeRes['SmartyTagAttributes'] = array($nodeRes['SmartyTagAttributes']);
                    }
                    $nodeRes['SmartyTagAttributes'][] = $matchRes;
                }
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $traceObj->failNode($remove);
                }
            }
            /*
             * End rule: SmartyTagAttributes
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
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
            $this->parser->matchError($errorResult, 'token', $error, 'TagStatement');
        }
        return $nodeRes;
    }
    public function TagStatement_MATCH_statement (&$nodeRes, $matchRes)
    {
        $nodeRes['node'] = $matchRes['node'];
        $nodeRes['node']->setTagAttribute(array('istag', true));
    }


}

