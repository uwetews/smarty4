<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\Node;
use Smarty\PegParser;

/**
 * Class VariableParser
 *
 * @package Smarty\Compiler\Source\Language\Smarty\Parser
 */
class VariableParser  extends PegParser
{
   
    /**
     *
     * Parser generated on 2014-06-29 20:28:30
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/Variable.peg.inc' dated 2014-06-28 02:53:31
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
                    "_nodetype" => "node",
                    "hash" => true
                ),
            "Arrayelement" => array(
                    "_nodetype" => "node"
                ),
            "Object" => array(
                    "_nodetype" => "token"
                )
        );
    /**
     *
     * Parser rules and action for node 'Variable'
     *
     *  Rule:
    
    #
    # Template variable
    #
    #                -> name can be nested variable                    -> array access     -> property or method
        <node Variable>
            <attribute>hash</attribute>
            <rule> isvar:'$' ((id:Id | ('{' var:Variable '}'))+ ('@' property:Id)? (Arrayelement | Object)*) | Unexpected </rule>
            <action _start>
            {
                $i = 1;
            }
            </action>
            <action isvar>
            {
                $result['node'] = new Node($this->parser, 'Variable');
            }
            </action>
            <action id>
            {
                $node = new Node\Value\String($this->parser);
                $result['node']->addSubTree($node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']), 'name', true);
            }
            </action>
            <action var>
            {
                $result['node']->addSubTree($subres['node'], 'name', true);
            }
            </action>
            <action property>
            {
                $result['node']->addSubTree($subres['_text'], 'property');
            }
            </action>
            <action _finish>
            {
                    $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

     *
    */
    public function matchNodeVariable($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        if (isset($this->parser->packCache[$this->parser->pos]['Variable'])) {
            $result = $this->parser->packCache[$this->parser->pos]['Variable'];
            if ($result) {
                $this->parser->pos = $result['_endpos'];
                $this->parser->line = $result['_endline'];
            }
            return $result;
        }
        $this->Variable___START($result, $previous);
        // Start 'Variable' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'isvar:'$'' tag 'isvar' min '1' max '1'
            if ('$' == substr($this->parser->source, $this->parser->pos, 1)) {
                $this->parser->pos += 1;
                $result['_text'] .= '$';
                $this->Variable_isvar($result, null);
                $this->parser->successLiteral('$');
                $valid = true;
            } else {
                $this->parser->failLiteral('$');
                $valid = false;
            }
            // End 'isvar:'$''
            if (!$valid) {
                break;
            }
            // Start 'Variable' min '1' max '1'
            // start option
            do {
                // Start '( ( id:Id | ( '{' var:Variable '}'))+ ( '@' property:Id)? ( Arrayelement | Object)*)' min '1' max '1'
                // start sequence
                $backup5 = $result;
                $pos5 = $this->parser->pos;
                $line5 = $this->parser->line;
                do {
                    // Start '( id:Id | ( '{' var:Variable '}'))+' min '1' max 'null'
                    $iteration6 = 0;
                    do {
                        // start option
                        do {
                            // Start 'id:Id' tag 'id' min '1' max '1'
                            $this->parser->addBacktrace(array('Id', $result));
                            $subres = $this->parser->matchRule($result, 'Id');
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('Id',  $subres));
                                $result['_text'] .= $subres['_text'];
                                $this->Variable_id($result, $subres);
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            // End 'id:Id'
                            if ($valid) {
                                break;
                            }
                            // Start '( '{' var:Variable '}')' min '1' max '1'
                            // start sequence
                            $backup9 = $result;
                            $pos9 = $this->parser->pos;
                            $line9 = $this->parser->line;
                            do {
                                // Start ''{'' min '1' max '1'
                                if ('{' == substr($this->parser->source, $this->parser->pos, 1)) {
                                    $this->parser->pos += 1;
                                    $result['_text'] .= '{';
                                    $this->parser->successLiteral('{');
                                    $valid = true;
                                } else {
                                    $this->parser->failLiteral('{');
                                    $valid = false;
                                }
                                // End ''{''
                                if (!$valid) {
                                    break;
                                }
                                // Start 'var:Variable' tag 'var' min '1' max '1'
                                $this->parser->addBacktrace(array('Variable', $result));
                                $subres = $this->parser->matchRule($result, 'Variable');
                                $remove = array_pop($this->parser->backtrace);
                                if ($subres) {
                                    $this->parser->successNode(array('Variable',  $subres));
                                    $result['_text'] .= $subres['_text'];
                                    $this->Variable_var($result, $subres);
                                    $valid = true;
                                } else {
                                    $valid = false;
                                    $this->parser->failNode($remove);
                                }
                                // End 'var:Variable'
                                if (!$valid) {
                                    break;
                                }
                                // Start ''}'' min '1' max '1'
                                if ('}' == substr($this->parser->source, $this->parser->pos, 1)) {
                                    $this->parser->pos += 1;
                                    $result['_text'] .= '}';
                                    $this->parser->successLiteral('}');
                                    $valid = true;
                                } else {
                                    $this->parser->failLiteral('}');
                                    $valid = false;
                                }
                                // End ''}''
                                if (!$valid) {
                                    break;
                                }
                                break;
                            } while (true);
                            if (!$valid) {
                                $this->parser->pos = $pos9;
                                $this->parser->line = $line9;
                                $result = $backup9;
                            }
                            unset($backup9);
                            // end sequence
                            // End '( '{' var:Variable '}')'
                            if ($valid) {
                                break;
                            }
                            break;
                        } while (true);
                        // end option
                        $iteration6 = $valid ? ($iteration6 + 1) : $iteration6;
                        if (!$valid && $iteration6 >= 1) {
                            $valid = true;
                            break;
                        }
                        if (!$valid) break;
                    } while (true);
                    // End '( id:Id | ( '{' var:Variable '}'))+'
                    if (!$valid) {
                        break;
                    }
                    // Start '( '@' property:Id)?' min '0' max '1'
                    // start sequence
                    $backup14 = $result;
                    $pos14 = $this->parser->pos;
                    $line14 = $this->parser->line;
                    do {
                        // Start ''@'' min '1' max '1'
                        if ('@' == substr($this->parser->source, $this->parser->pos, 1)) {
                            $this->parser->pos += 1;
                            $result['_text'] .= '@';
                            $this->parser->successLiteral('@');
                            $valid = true;
                        } else {
                            $this->parser->failLiteral('@');
                            $valid = false;
                        }
                        // End ''@''
                        if (!$valid) {
                            break;
                        }
                        // Start 'property:Id' tag 'property' min '1' max '1'
                        $this->parser->addBacktrace(array('Id', $result));
                        $subres = $this->parser->matchRule($result, 'Id');
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('Id',  $subres));
                            $result['_text'] .= $subres['_text'];
                            $this->Variable_property($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'property:Id'
                        if (!$valid) {
                            break;
                        }
                        break;
                    } while (true);
                    if (!$valid) {
                        $this->parser->pos = $pos14;
                        $this->parser->line = $line14;
                        $result = $backup14;
                    }
                    unset($backup14);
                    // end sequence
                    $valid = true;
                    // End '( '@' property:Id)?'
                    if (!$valid) {
                        break;
                    }
                    // Start '( Arrayelement | Object)*' min '0' max 'null'
                    $iteration17 = 0;
                    do {
                        // start option
                        do {
                            // Start 'Arrayelement' min '1' max '1'
                            $this->parser->addBacktrace(array('Arrayelement', $result));
                            $subres = $this->parser->matchRule($result, 'Arrayelement');
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('Arrayelement',  $subres));
                                $result['_text'] .= $subres['_text'];
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            // End 'Arrayelement'
                            if ($valid) {
                                break;
                            }
                            // Start 'Object' min '1' max '1'
                            $this->parser->addBacktrace(array('Object', $result));
                            $subres = $this->parser->matchRule($result, 'Object');
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('Object',  $subres));
                                $result['_text'] .= $subres['_text'];
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            // End 'Object'
                            if ($valid) {
                                break;
                            }
                            break;
                        } while (true);
                        // end option
                        $iteration17 = $valid ? ($iteration17 + 1) : $iteration17;
                        if (!$valid && $iteration17 >= 0) {
                            $valid = true;
                            break;
                        }
                        if (!$valid) break;
                    } while (true);
                    // End '( Arrayelement | Object)*'
                    if (!$valid) {
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos5;
                    $this->parser->line = $line5;
                    $result = $backup5;
                }
                unset($backup5);
                // end sequence
                // End '( ( id:Id | ( '{' var:Variable '}'))+ ( '@' property:Id)? ( Arrayelement | Object)*)'
                if ($valid) {
                    break;
                }
                // Start 'Unexpected' min '1' max '1'
                $this->parser->addBacktrace(array('Unexpected', $result));
                $subres = $this->parser->matchRule($result, 'Unexpected');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Unexpected',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'Unexpected'
                if ($valid) {
                    break;
                }
                break;
            } while (true);
            // end option
            // End 'Variable'
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
        // End 'Variable'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Variable___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        $this->parser->packCache[$pos0]['Variable'] = $result;
        return $result;
    }

    public function Variable___START (&$result, $previous) {
        $i = 1;
    }


    public function Variable_isvar (&$result, $subres) {
        $result['node'] = new Node($this->parser, 'Variable');
    }


    public function Variable_id (&$result, $subres) {
        $node = new Node\Value\String($this->parser);
        $result['node']->addSubTree($node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']), 'name', true);
    }


    public function Variable_var (&$result, $subres) {
        $result['node']->addSubTree($subres['node'], 'name', true);
    }


    public function Variable_property (&$result, $subres) {
        $result['node']->addSubTree($subres['_text'], 'property');
    }


    public function Variable___FINISH (&$result) {
        $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }


    /**
     *
     * Parser rules and action for node 'Arrayelement'
     *
     *  Rule:
    <node Arrayelement>
            <rule>(('.' ( iv:Id | value:Value)) | ('['  value:Expr ']'))+</rule>
            <action _start>
            {
                $result['node'] = $previous['node'];
            }
            </action>
            <action value>
            {
                $result['node']->addSubTree(array('type' => 'arrayelement', 'node' => $subres['node']) , 'suffix', true);
            }
            </action>
            <action iv>
            {
                $node = new Node\Value\String($this->parser);
                $result['node']->addSubTree(array('type' => 'arrayelement', 'node' => $node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']) , 'suffix', true));
            }
            </action>
        </node>

     *
    */
    public function matchNodeArrayelement($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->Arrayelement___START($result, $previous);
        // Start '( ( '.' ( iv:Id | value:Value)) | ( '[' value:Expr ']'))+' min '1' max 'null'
        $iteration0 = 0;
        do {
            // start option
            do {
                // Start '( '.' ( iv:Id | value:Value))' min '1' max '1'
                // start sequence
                $backup2 = $result;
                $pos2 = $this->parser->pos;
                $line2 = $this->parser->line;
                do {
                    // Start ''.'' min '1' max '1'
                    if ('.' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= '.';
                        $this->parser->successLiteral('.');
                        $valid = true;
                    } else {
                        $this->parser->failLiteral('.');
                        $valid = false;
                    }
                    // End ''.''
                    if (!$valid) {
                        break;
                    }
                    // Start '( iv:Id | value:Value)' min '1' max '1'
                    // start option
                    do {
                        // Start 'iv:Id' tag 'iv' min '1' max '1'
                        $this->parser->addBacktrace(array('Id', $result));
                        $subres = $this->parser->matchRule($result, 'Id');
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('Id',  $subres));
                            $result['_text'] .= $subres['_text'];
                            $this->Arrayelement_iv($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'iv:Id'
                        if ($valid) {
                            break;
                        }
                        // Start 'value:Value' tag 'value' min '1' max '1'
                        $this->parser->addBacktrace(array('Value', $result));
                        $subres = $this->parser->matchRule($result, 'Value');
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('Value',  $subres));
                            $result['_text'] .= $subres['_text'];
                            $this->Arrayelement_value($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'value:Value'
                        if ($valid) {
                            break;
                        }
                        break;
                    } while (true);
                    // end option
                    // End '( iv:Id | value:Value)'
                    if (!$valid) {
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos2;
                    $this->parser->line = $line2;
                    $result = $backup2;
                }
                unset($backup2);
                // end sequence
                // End '( '.' ( iv:Id | value:Value))'
                if ($valid) {
                    break;
                }
                // Start '( '[' value:Expr ']')' min '1' max '1'
                // start sequence
                $backup8 = $result;
                $pos8 = $this->parser->pos;
                $line8 = $this->parser->line;
                do {
                    // Start ''['' min '1' max '1'
                    if ('[' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= '[';
                        $this->parser->successLiteral('[');
                        $valid = true;
                    } else {
                        $this->parser->failLiteral('[');
                        $valid = false;
                    }
                    // End ''[''
                    if (!$valid) {
                        break;
                    }
                    // Start 'value:Expr' tag 'value' min '1' max '1'
                    $this->parser->addBacktrace(array('Expr', $result));
                    $subres = $this->parser->matchRule($result, 'Expr');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Expr',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->Arrayelement_value($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'value:Expr'
                    if (!$valid) {
                        break;
                    }
                    // Start '']'' min '1' max '1'
                    if (']' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= ']';
                        $this->parser->successLiteral(']');
                        $valid = true;
                    } else {
                        $this->parser->failLiteral(']');
                        $valid = false;
                    }
                    // End '']''
                    if (!$valid) {
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos8;
                    $this->parser->line = $line8;
                    $result = $backup8;
                }
                unset($backup8);
                // end sequence
                // End '( '[' value:Expr ']')'
                if ($valid) {
                    break;
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
        // End '( ( '.' ( iv:Id | value:Value)) | ( '[' value:Expr ']'))+'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Arrayelement___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function Arrayelement_value (&$result, $subres) {
        $result['node']->addSubTree(array('type'=> 'arrayelement', 'node'=> $subres['node']) , 'suffix', true);
    }


    public function Arrayelement_iv (&$result, $subres) {
        $node = new Node\Value\String($this->parser);
        $result['node']->addSubTree(array('type'=> 'arrayelement', 'node'=> $node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']) , 'suffix', true));
    }


    /**
     *
     * Parser rules and action for node 'Object'
     *
     *  Rule:
    <token Object>
            <rule>(addsuffix:('->' ( .iv:Id | .var:Variable) method:Parameter?))+</rule>
            <action _start>
            {
                $result['node'] = $previous['node'];
            }
            </action>
            <action iv>
            {
                $node = new Node\Value\String($this->parser);
                $node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
                $result['name'] = $node;
            }
            </action>
            <action var>
            {
                $result['name'] = $subres['node'];
            }
            </action>
            <action method>
            {
                $result['method'] = $subres['node'];
            }
            </action>
            <action addsuffix>
            {
                $result['node']->addSubTree(array('type' => 'object', 'name' => $subres['name'], 'method' => isset($subres['method']) ? $subres['method'] : null) , 'suffix', true);
            }
            </action>
        </token>

     *
    */
    public function matchNodeObject($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->Object___START($result, $previous);
        // Start '( addsuffix:( '->' ( .iv:Id | .var:Variable) method:Parameter?))+' tag 'addsuffix' min '1' max 'null'
        $iteration0 = 0;
        do {
            // start sequence
            $backup1 = $result;
            $pos1 = $this->parser->pos;
            $line1 = $this->parser->line;
            do {
                // Start ''->'' min '1' max '1'
                if ('->' == substr($this->parser->source, $this->parser->pos, 2)) {
                    $this->parser->pos += 2;
                    $result['_text'] .= '->';
                    $this->parser->successLiteral('->');
                    $valid = true;
                } else {
                    $this->parser->failLiteral('->');
                    $valid = false;
                }
                // End ''->''
                if (!$valid) {
                    break;
                }
                // Start '( .iv:Id | .var:Variable)' min '1' max '1'
                // start option
                do {
                    // Start '.iv:Id' tag 'iv' min '1' max '1'
                    $this->parser->addBacktrace(array('Id', $result));
                    $subres = $this->parser->matchRule($result, 'Id');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Id',  $subres));
                        $this->Object_iv($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End '.iv:Id'
                    if ($valid) {
                        break;
                    }
                    // Start '.var:Variable' tag 'var' min '1' max '1'
                    $this->parser->addBacktrace(array('Variable', $result));
                    $subres = $this->parser->matchRule($result, 'Variable');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Variable',  $subres));
                        $this->Object_var($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End '.var:Variable'
                    if ($valid) {
                        break;
                    }
                    break;
                } while (true);
                // end option
                // End '( .iv:Id | .var:Variable)'
                if (!$valid) {
                    break;
                }
                // Start 'method:Parameter?' tag 'method' min '0' max '1'
                $this->parser->addBacktrace(array('Parameter', $result));
                $subres = $this->parser->matchRule($result, 'Parameter');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Parameter',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Object_method($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                $valid = true;
                // End 'method:Parameter?'
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
            if ($valid) {
                $backup1['_text'] .= $result['_text'];
                $this->Object_addsuffix($backup1, $result);
            }
            $result = $backup1;
            unset($backup1);
            // end sequence
            $iteration0 = $valid ? ($iteration0 + 1) : $iteration0;
            if (!$valid && $iteration0 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) break;
        } while (true);
        // End '( addsuffix:( '->' ( .iv:Id | .var:Variable) method:Parameter?))+'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Object___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function Object_iv (&$result, $subres) {
        $node = new Node\Value\String($this->parser);
        $node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
        $result['name'] = $node;
    }


    public function Object_var (&$result, $subres) {
        $result['name'] = $subres['node'];
    }


    public function Object_method (&$result, $subres) {
        $result['method'] = $subres['node'];
    }


    public function Object_addsuffix (&$result, $subres) {
        $result['node']->addSubTree(array('type'=> 'object', 'name'=> $subres['name'], 'method'=> isset($subres['method']) ? $subres['method'] : null) , 'suffix', true);
    }



}
