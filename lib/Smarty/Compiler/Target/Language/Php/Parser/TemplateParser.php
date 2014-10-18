<?php
namespace Smarty\Compiler\Target\Language\Php\Parser;

use Smarty\Node;
use Smarty\Parser\Peg\RuleRoot;

/**
 * Class TemplateParser
 *
 * @package Smarty\Compiler\Target\Language\Php\Parser
 */
class TemplateParser extends RuleRoot
{
   
    /**
     *
     * Parser generated on 2014-09-04 02:35:35
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Target/Language/Php/Parser/Template.peg.inc' dated 2014-08-22 04:53:52
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
            "Template" => "matchNodeTemplate",
            "Bom" => "matchNodeBom"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array();
    /**
     *
     * Parser rules and actions for node 'Template'
     *
     *  Rule:
     * 
     *              <node Template>
     *                  <rule>.Bom? nodes:Body?  Unexpected?</rule>
     *                  <action _start>
     *                  {
     *                      $nodeRes['node'] = new Node\Template($this->parser, $nodeRes);
     *                  }
     *                 </action>
     *                  <action nodes>
     *                  {
     *                      $nodeRes['node']->templateBodyNode = $matchRes['node'];
     *                      $nodeRes['node']->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
     *                      $nodeRes['node']->templateBodyNode->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
     *                  }
     *                 </action>
     *              </node>
     * 
     *
    */
    public function matchNodeTemplate($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->Template_START($nodeRes, $previous);
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
             * Start rule: .Bom?
             *       min: 0 max: 1
             */
            $error = array();
            if ($trace) {
                $traceObj->addBacktrace(array('Bom', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'Bom', $error);
            if ($trace) {
                $remove = $traceObj->popBacktrace();
            }
            if ($matchRes) {
                if ($trace) {
                    $traceObj->successNode(array('Bom',  $matchRes['_text']));
                }
                if(!isset($nodeRes['Bom'])) {
                    $nodeRes['Bom'] = $matchRes;
                } else {
                    if (!is_array($nodeRes['Bom'])) {
                        $nodeRes['Bom'] = array($nodeRes['Bom']);
                    }
                    $nodeRes['Bom'][] = $matchRes;
                }
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $traceObj->failNode($remove);
                }
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, 'Bom', $error);
            }
            $valid = true;
            /*
             * End rule: .Bom?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: nodes:Body?
             *       tag: 'nodes'
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
                $this->Template_MATCH_nodes($nodeRes, $matchRes);
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
             * End rule: nodes:Body?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: Unexpected?
             *       min: 0 max: 1
             */
            $error = array();
            if ($trace) {
                $traceObj->addBacktrace(array('Unexpected', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'Unexpected', $error);
            if ($trace) {
                $remove = $traceObj->popBacktrace();
            }
            if ($matchRes) {
                if ($trace) {
                    $traceObj->successNode(array('Unexpected',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                if(!isset($nodeRes['Unexpected'])) {
                    $nodeRes['Unexpected'] = $matchRes;
                } else {
                    if (!is_array($nodeRes['Unexpected'])) {
                        $nodeRes['Unexpected'] = array($nodeRes['Unexpected']);
                    }
                    $nodeRes['Unexpected'][] = $matchRes;
                }
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $traceObj->failNode($remove);
                }
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, 'Unexpected', $error);
            }
            $valid = true;
            /*
             * End rule: Unexpected?
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
            $this->parser->matchError($errorResult, 'token', $error, 'Template');
        }
        return $nodeRes;
    }
    public function Template_START (&$nodeRes, $previous)
    {
        $nodeRes['node'] = new Node\Template($this->parser, $nodeRes);
    }

    public function Template_MATCH_nodes (&$nodeRes, $matchRes)
    {
        $nodeRes['node']->templateBodyNode = $matchRes['node'];
        $nodeRes['node']->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
        $nodeRes['node']->templateBodyNode->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
    }

    /**
     *
     * Parser rules and actions for node 'Bom'
     *
     *  Rule:
     * <node Bom>
     *                  <rule>/^(\xEF\xBB\xBF)|(\xFE\xFF)|(\xFF\xFE)/</rule>
     *              </node>
     * 
     *
    */
    public function matchNodeBom($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        /*
         * Start rule: /^(\xEF\xBB\xBF)|(\xFE\xFF)|(\xFF\xFE)/
         *       min: 1 max: 1
         */
        $regexp = "/^(\\xEF\\xBB\\xBF)|(\\xFE\\xFF)|(\\xFF\\xFE)/";
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
            $nodeRes['_text'] .= $matchRes['_text'];
            $valid = true;
        } else {
            $valid = false;
        }
        if (!$valid) {
            $this->parser->matchError($error, 'rx', "/^(\\xEF\\xBB\\xBF)|(\\xFE\\xFF)|(\\xFF\\xFE)/");
        }
        /*
         * End rule: /^(\xEF\xBB\xBF)|(\xFE\xFF)|(\xFF\xFE)/
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Bom');
        }
        return $nodeRes;
    }

}

