<?php
namespace Smarty\Compiler\Target\Language\Php\Parser;

use Smarty\Nodes;
use Smarty\Parser\Peg\RuleRoot;

/**
 * Class ResourceParser
 *
 * @package Smarty\Compiler\Target\Language\Php\Parser
 */
class ResourceParser extends RuleRoot
{

   
    /**
     *
     * Parser generated on 2014-09-04 02:35:35
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Target/Language/Php/Parser/Resource.peg.inc' dated 2014-08-22 04:53:52
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
            "Resource" => "matchNodeResource"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array();
    /**
     *
     * Parser rules and actions for node 'Resource'
     *
     *  Rule:
     * 
     *             <node Resource>
     *                 <rule>main:Template</rule>
     *                 <action _start>
     *                 {
     *                     $nodeRes['node'] = $previous['node'];
     *                 }
     *                 </action>
     *                 <action main>
     *                 {
     *                     $nodeRes['node']->templateNode = $matchRes['node'];
     *                 }
     *                 </action>
     *             </node>
     * 
     *
    */
    public function matchNodeResource($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->Resource_START($nodeRes, $previous);
        /*
         * Start rule: main:Template
         *       tag: 'main'
         *       min: 1 max: 1
         */
        if ($trace) {
            $traceObj->addBacktrace(array('Template', ''));
        }
        $matchRes = $this->parser->matchRule($nodeRes, 'Template', $error);
        if ($trace) {
            $remove = $traceObj->popBacktrace();
        }
        if ($matchRes) {
            if ($trace) {
                $traceObj->successNode(array('Template',  $matchRes['_text']));
            }
            $nodeRes['_text'] .= $matchRes['_text'];
            $this->Resource_MATCH_main($nodeRes, $matchRes);
            $valid = true;
        } else {
            $valid = false;
            if ($trace) {
                $traceObj->failNode($remove);
            }
        }
        /*
         * End rule: main:Template
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Resource');
        }
        return $nodeRes;
    }
    public function Resource_START (&$nodeRes, $previous)
    {
        $nodeRes['node'] = $previous['node'];
    }

    public function Resource_MATCH_main (&$nodeRes, $matchRes)
    {
        $nodeRes['node']->templateNode = $matchRes['node'];
    }



}

