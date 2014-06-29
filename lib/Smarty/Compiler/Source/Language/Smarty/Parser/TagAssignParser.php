<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;
use Smarty\PegParser;

/**
 * Class TagAssignParser
 *
 * @package Smarty\Compiler\Source\Language\Smarty\Parser
 */
class TagAssignParser extends PegParser
{
    
    /**
     *
     * Parser generated on 2014-06-29 20:26:56
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/TagAssign.peg.inc' dated 2014-06-29 20:26:52
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
            "TagAssign" => "matchNodeTagAssign"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "TagAssign" => array(
                    "_nodetype" => "node",
                    "attributes" => array(
                            "required" => array(
                                    "name" => true,
                                    "value" => true
                                )
                        ),
                    "options" => "nocache"
                )
        );
    /**
     *
     * Parser rules and action for node 'TagAssign'
     *
     *  Rule:
    

            <node TagAssign>
                <attribute>attributes=(required=(name,value)),options=nocache</attribute>
                <rule>Ldel 'assign' SmartyTagAttributes SmartyTagScopes SmartyTagOptions </rule>
                <action _start>
                {
                    $result['node'] = $previous['node'];
                }
                </action>
            </node>

     *
    */
    public function matchNodeTagAssign($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->TagAssign___START($result, $previous);
        // Start 'TagAssign' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Ldel' min '1' max '1'
            $this->parser->addBacktrace(array('Ldel', $result));
            $subres = $this->parser->matchRule($result, 'Ldel');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Ldel',  $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Ldel'
            if (!$valid) {
                break;
            }
            // Start ''assign'' min '1' max '1'
            if ('assign' == substr($this->parser->source, $this->parser->pos, 6)) {
                $this->parser->pos += 6;
                $result['_text'] .= 'assign';
                $this->parser->successLiteral('assign');
                $valid = true;
            } else {
                $this->parser->failLiteral('assign');
                $valid = false;
            }
            // End ''assign''
            if (!$valid) {
                break;
            }
            // Start 'SmartyTagAttributes' min '1' max '1'
            $this->parser->addBacktrace(array('SmartyTagAttributes', $result));
            $subres = $this->parser->matchRule($result, 'SmartyTagAttributes');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('SmartyTagAttributes',  $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'SmartyTagAttributes'
            if (!$valid) {
                break;
            }
            // Start 'SmartyTagScopes' min '1' max '1'
            $this->parser->addBacktrace(array('SmartyTagScopes', $result));
            $subres = $this->parser->matchRule($result, 'SmartyTagScopes');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('SmartyTagScopes',  $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'SmartyTagScopes'
            if (!$valid) {
                break;
            }
            // Start 'SmartyTagOptions' min '1' max '1'
            $this->parser->addBacktrace(array('SmartyTagOptions', $result));
            $subres = $this->parser->matchRule($result, 'SmartyTagOptions');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('SmartyTagOptions',  $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'SmartyTagOptions'
            if (!$valid) {
                break;
            }
            break;
        } while (true);
        if (!$valid) {
            $this->parser->pos = $pos1;
            $this->parser->line = $line1;
            $result = $backup1;
        }
        unset($backup1);
        // end sequence
        // End 'TagAssign'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function TagAssign___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }



}

