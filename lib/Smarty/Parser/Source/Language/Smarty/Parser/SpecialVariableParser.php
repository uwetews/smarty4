<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Value\String;
use Smarty\Parser\Peg\RuleRoot;
use Smarty\Node;

/**
 * Class SpecialVariableParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class SpecialVariableParser extends RuleRoot
{
   
    /**
     *
     * Parser generated on 2014-09-03 21:11:07
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/SpecialVariable.peg.inc' dated 2014-08-17 03:32:57
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
            "SpecialVariable" => "matchNodeSpecialVariable"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "SpecialVariable" => array(
                    "hash" => true
                )
        );
    /**
     *
     * Parser rules and actions for node 'SpecialVariable'
     *
     *  Rule:
     * 
     *     #
     *     #  Special Smarty variable starting with  $smarty.
     *     #
     *     #
     *         <node SpecialVariable>
     *             <attribute>hash</attribute>
     *             <rule>'$smarty.' </rule>
     *             <action _start>
     *             {
     *                 $i = 1;
     *             }
     *             </action>
     *         </node>
     * 
     *
    */
    public function matchNodeSpecialVariable($previous, &$errorResult){
        $trace = $this->parser->trace;
        if ($trace) {
            $traceObj = $this->parser->getTraceObj();
        }
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        if (isset($this->parser->packCache[$this->parser->pos]['SpecialVariable'])) {
            $nodeRes = $this->parser->packCache[$this->parser->pos]['SpecialVariable'];
            $error = $this->parser->errorCache[$this->parser->pos]['SpecialVariable'];
            if ($nodeRes) {
                $this->parser->pos = $nodeRes['_endpos'];
                $this->parser->line = $nodeRes['_endline'];
            } else {
                $this->parser->matchError($errorResult, 'token', $error, 'SpecialVariable');
            }
            return $nodeRes;
        }
        $this->SpecialVariable_START($nodeRes, $previous);
        /*
         * Start rule: '$smarty.'
         *       min: 1 max: 1
         */
        if ('$smarty.' == substr($this->parser->source, $this->parser->pos, 8)) {
            $this->parser->pos += 8;
            $nodeRes['_text'] .= '$smarty.';
            if ($trace) {
                $traceObj->successNode(array('\'$smarty.\'', '$smarty.'));
            }
            $valid = true;
        } else {
            $this->parser->matchError($error, 'literal', '$smarty.');
            if ($trace) {
                $traceObj->failNode(array('\'$smarty.\'',  ''));
            }
            $valid = false;
        }
        /*
         * End rule: '$smarty.'
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'SpecialVariable');
        }
        $this->parser->packCache[$pos0]['SpecialVariable'] = $nodeRes;
        $this->parser->errorCache[$pos0]['SpecialVariable'] = $error;
        return $nodeRes;
    }
    public function SpecialVariable_START (&$nodeRes, $previous)
    {
        $i = 1;
    }


}
