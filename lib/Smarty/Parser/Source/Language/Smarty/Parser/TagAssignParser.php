<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\PegParser;

/**
 * Class TagAssignParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagAssignParser extends PegParser
{

    /**
     * Parser generated on 2014-08-10 18:55:25
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/TagAssign.peg.inc' dated 2014-07-08 03:12:19

     */

    /**
     * Flag that compiled Peg Parser class is valid
     * @var bool
     */
    public $valid = true;

    /**
     * Array of match method names for rules of this Peg Parser
     *
     * @var array
     */
    public $matchMethods = array(
        "TagAssign" => "matchNodeTagAssign"
    );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
        "TagAssign" => array(
            "_nodetype"  => "node",
            "attributes" => array(
                "required" => array(
                    "var"   => true,
                    "value" => true
                )
            ),
            "options"    => array(
                "nocache"    => true,
                "cachevalue" => true
            )
        )
    );

    /**
     * Parser rules and action for node 'TagAssign'
     *  Rule:
     * <node TagAssign>
     * <attribute>attributes=(required=(var,value)),options=(nocache,cachevalue)</attribute>
     * <rule>Ldel 'assign' SmartyTagAttributes SmartyTagOptions Rdel</rule>
     * <action _start>
     * {
     * $result['node'] = $previous['node'];
     * }
     * </action>
     * </node>


     */
    public function matchNodeTagAssign($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->TagAssign___START($result, $previous);
        // Start 'TagAssign' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        $error1 = $error;
        $this->parser->addBacktrace(array('_s1_', ''));
        do {
            $error = array();
            // Start 'Ldel' min '1' max '1'
            $this->parser->addBacktrace(array('Ldel', ''));
            $subres = $this->parser->matchRule($result, 'Ldel', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Ldel', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Ldel'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start ''assign'' min '1' max '1'
            if ('assign' == substr($this->parser->source, $this->parser->pos, 6)) {
                $this->parser->pos += 6;
                $result['_text'] .= 'assign';
                $this->parser->successNode(array('\'assign\'', 'assign'));
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', 'assign');
                $this->parser->failNode(array('\'assign\'', ''));
                $valid = false;
            }
            // End ''assign''
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'SmartyTagAttributes' min '1' max '1'
            $this->parser->addBacktrace(array('SmartyTagAttributes', ''));
            $subres = $this->parser->matchRule($result, 'SmartyTagAttributes', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('SmartyTagAttributes', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'SmartyTagAttributes'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'SmartyTagOptions' min '1' max '1'
            $this->parser->addBacktrace(array('SmartyTagOptions', ''));
            $subres = $this->parser->matchRule($result, 'SmartyTagOptions', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('SmartyTagOptions', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'SmartyTagOptions'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'Rdel' min '1' max '1'
            $this->parser->addBacktrace(array('Rdel', ''));
            $subres = $this->parser->matchRule($result, 'Rdel', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Rdel', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Rdel'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            break;
        } while (true);
        $remove = array_pop($this->parser->backtrace);
        if (!$valid) {
            $this->parser->failNode($remove);
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        } else {
            $this->parser->successNode($remove);
        }
        $error = $error1;
        unset($backup1);
        // end sequence
        // End 'TagAssign'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'TagAssign');
        }
        return $result;
    }

    public function TagAssign___START(&$result, $previous)
    {
        $result['node'] = $previous['node'];
    }
}

