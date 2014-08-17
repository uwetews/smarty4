<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Value\String;
use Smarty\PegParser;
use Smarty\Node;

/**
 * Class VariableParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class VariableParser extends PegParser
{

    /**
     * Parser generated on 2014-08-10 18:55:25
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/Variable.peg.inc' dated 2014-07-13 09:03:35

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
        "Variable"     => "matchNodeVariable",
        "Arrayelement" => "matchNodeArrayelement",
        "Object"       => "matchNodeObject"
    );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
        "Variable"     => array(
            "_nodetype" => "node",
            "hash"      => true
        ),
        "Arrayelement" => array(
            "_nodetype" => "node"
        ),
        "Object"       => array(
            "_nodetype" => "token"
        )
    );

    /**
     * Parser rules and action for node 'Variable'
     *  Rule:
     * #
     * # Template variable
     * #
     * #                -> name can be nested variable                    -> array access     -> property or method
     * <node Variable>
     * <attribute>hash</attribute>
     * <rule>  (&'$smarty.' special:SpecialVariable) | (isvar:'$' ((id:Id | ('{' var:Variable '}'))+ ('@' property:Id)? ( (&/\.|\[/ Arrayelement) | ( &'->' Object))*)) </rule>
     * <action _start>
     * {
     * $i = 1;
     * }
     * </action>
     * <action special>
     * {
     * $result['node'] = $subres['node'];
     * }
     * </action>
     * <action isvar>
     * {
     * $result['node'] = new Node($this->parser, 'Variable');
     * }
     * </action>
     * <action id>
     * {
     * $node = new String($this->parser);
     * $result['node']->addSubTree($node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']), 'name', true);
     * }
     * </action>
     * <action var>
     * {
     * $result['node']->addSubTree($subres['node'], 'name', true);
     * }
     * </action>
     * <action property>
     * {
     * $result['node']->addSubTree($subres['_text'], 'property');
     * }
     * </action>
     * <action _finish>
     * {
     * $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
     * }
     * </action>
     * </node>


     */
    public function matchNodeVariable($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        if (isset($this->parser->packCache[$this->parser->pos]['Variable'])) {
            $result = $this->parser->packCache[$this->parser->pos]['Variable'];
            $error = $this->parser->errorCache[$this->parser->pos]['Variable'];
            if ($result) {
                $this->parser->pos = $result['_endpos'];
                $this->parser->line = $result['_endline'];
            } else {
                $this->parser->matchError($errorResult, 'token', $error, 'Variable');
            }
            return $result;
        }
        $this->Variable___START($result, $previous);
        // Start 'Variable' min '1' max '1'
        // start option
        $error1 = $error;
        $errorOption1 = array();
        $this->parser->addBacktrace(array('_o1_', ''));
        do {
            $error = array();
            array_pop($this->parser->backtrace);
            $this->parser->addBacktrace(array('_o1:1_', ''));
            // Start '( &'$smarty.' special:SpecialVariable)' min '1' max '1'
            // start sequence
            $backup3 = $result;
            $pos3 = $this->parser->pos;
            $line3 = $this->parser->line;
            $error3 = $error;
            $this->parser->addBacktrace(array('_s3_', ''));
            do {
                $error = array();
                // Start '&'$smarty.'' min '1' max '1' positive lookahead
                $backup4 = $result;
                $pos4 = $this->parser->pos;
                $line4 = $this->parser->line;
                if ('$smarty.' == substr($this->parser->source, $this->parser->pos, 8)) {
                    $this->parser->pos += 8;
                    $result['_text'] .= '$smarty.';
                    $this->parser->successNode(array('\'$smarty.\'', '$smarty.'));
                    $valid = true;
                } else {
                    $this->parser->matchError($error, 'literal', '$smarty.');
                    $this->parser->failNode(array('\'$smarty.\'', ''));
                    $valid = false;
                }
                $this->parser->pos = $pos4;
                $this->parser->line = $line4;
                $result = $backup4;
                unset($backup4);
                // End '&'$smarty.''
                if (!$valid) {
                    $this->parser->matchError($error3, 'SequenceElement', $error);
                    $error = $error3;
                    break;
                }
                $error = array();
                // Start 'special:SpecialVariable' tag 'special' min '1' max '1'
                $this->parser->addBacktrace(array('SpecialVariable', ''));
                $subres = $this->parser->matchRule($result, 'SpecialVariable', $error);
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('SpecialVariable', $subres['_text']));
                    $result['_text'] .= $subres['_text'];
                    $this->Variable_special($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'special:SpecialVariable'
                if (!$valid) {
                    $this->parser->matchError($error3, 'SequenceElement', $error);
                    $error = $error3;
                    break;
                }
                break;
            } while (true);
            $remove = array_pop($this->parser->backtrace);
            if (!$valid) {
                $this->parser->failNode($remove);
                $this->parser->pos = $pos3;
                $this->parser->line = $line3;
                $result = $backup3;
            } else {
                $this->parser->successNode($remove);
            }
            $error = $error3;
            unset($backup3);
            // end sequence
            // End '( &'$smarty.' special:SpecialVariable)'
            if ($valid) {
                $this->parser->successNode(array_pop($this->parser->backtrace));
                $error = $error1;
                break;
            } else {
                $this->parser->logOption($errorOption1, 'Variable', $error);
            }
            $error = array();
            array_pop($this->parser->backtrace);
            $this->parser->addBacktrace(array('_o1:2_', ''));
            // Start '( isvar:'$' ( ( id:Id | ( '{' var:Variable '}'))+ ( '@' property:Id)? ( ( &/\.|\[/ Arrayelement) | ( &'->' Object))*))' min '1' max '1'
            // start sequence
            $backup7 = $result;
            $pos7 = $this->parser->pos;
            $line7 = $this->parser->line;
            $error7 = $error;
            $this->parser->addBacktrace(array('_s7_', ''));
            do {
                $error = array();
                // Start 'isvar:'$'' tag 'isvar' min '1' max '1'
                if ('$' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= '$';
                    $this->Variable_isvar($result, null);
                    $this->parser->successNode(array('\'$\'', '$'));
                    $valid = true;
                } else {
                    $this->parser->matchError($error, 'literal', '$');
                    $this->parser->failNode(array('\'$\'', ''));
                    $valid = false;
                }
                // End 'isvar:'$''
                if (!$valid) {
                    $this->parser->matchError($error7, 'SequenceElement', $error);
                    $error = $error7;
                    break;
                }
                $error = array();
                // Start '( ( id:Id | ( '{' var:Variable '}'))+ ( '@' property:Id)? ( ( &/\.|\[/ Arrayelement) | ( &'->' Object))*)' min '1' max '1'
                // start sequence
                $backup10 = $result;
                $pos10 = $this->parser->pos;
                $line10 = $this->parser->line;
                $error10 = $error;
                $this->parser->addBacktrace(array('_s10_', ''));
                do {
                    $error = array();
                    // Start '( id:Id | ( '{' var:Variable '}'))+' min '1' max 'null'
                    $iteration11 = 0;
                    do {
                        // start option
                        $error12 = $error;
                        $errorOption12 = array();
                        $this->parser->addBacktrace(array('_o12_', ''));
                        do {
                            $error = array();
                            array_pop($this->parser->backtrace);
                            $this->parser->addBacktrace(array('_o12:1_', ''));
                            // Start 'id:Id' tag 'id' min '1' max '1'
                            $this->parser->addBacktrace(array('Id', ''));
                            $subres = $this->parser->matchRule($result, 'Id', $error);
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('Id', $subres['_text']));
                                $result['_text'] .= $subres['_text'];
                                $this->Variable_id($result, $subres);
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            // End 'id:Id'
                            if ($valid) {
                                $this->parser->successNode(array_pop($this->parser->backtrace));
                                $error = $error12;
                                break;
                            } else {
                                $this->parser->logOption($errorOption12, 'Variable', $error);
                            }
                            $error = array();
                            array_pop($this->parser->backtrace);
                            $this->parser->addBacktrace(array('_o12:2_', ''));
                            // Start '( '{' var:Variable '}')' min '1' max '1'
                            // start sequence
                            $backup15 = $result;
                            $pos15 = $this->parser->pos;
                            $line15 = $this->parser->line;
                            $error15 = $error;
                            $this->parser->addBacktrace(array('_s15_', ''));
                            do {
                                $error = array();
                                // Start ''{'' min '1' max '1'
                                if ('{' == substr($this->parser->source, $this->parser->pos, 1)) {
                                    $this->parser->pos += 1;
                                    $result['_text'] .= '{';
                                    $this->parser->successNode(array('\'{\'', '{'));
                                    $valid = true;
                                } else {
                                    $this->parser->matchError($error, 'literal', '{');
                                    $this->parser->failNode(array('\'{\'', ''));
                                    $valid = false;
                                }
                                // End ''{''
                                if (!$valid) {
                                    $this->parser->matchError($error15, 'SequenceElement', $error);
                                    $error = $error15;
                                    break;
                                }
                                $error = array();
                                // Start 'var:Variable' tag 'var' min '1' max '1'
                                $this->parser->addBacktrace(array('Variable', ''));
                                $subres = $this->parser->matchRule($result, 'Variable', $error);
                                $remove = array_pop($this->parser->backtrace);
                                if ($subres) {
                                    $this->parser->successNode(array('Variable', $subres['_text']));
                                    $result['_text'] .= $subres['_text'];
                                    $this->Variable_var($result, $subres);
                                    $valid = true;
                                } else {
                                    $valid = false;
                                    $this->parser->failNode($remove);
                                }
                                // End 'var:Variable'
                                if (!$valid) {
                                    $this->parser->matchError($error15, 'SequenceElement', $error);
                                    $error = $error15;
                                    break;
                                }
                                $error = array();
                                // Start ''}'' min '1' max '1'
                                if ('}' == substr($this->parser->source, $this->parser->pos, 1)) {
                                    $this->parser->pos += 1;
                                    $result['_text'] .= '}';
                                    $this->parser->successNode(array('\'}\'', '}'));
                                    $valid = true;
                                } else {
                                    $this->parser->matchError($error, 'literal', '}');
                                    $this->parser->failNode(array('\'}\'', ''));
                                    $valid = false;
                                }
                                // End ''}''
                                if (!$valid) {
                                    $this->parser->matchError($error15, 'SequenceElement', $error);
                                    $error = $error15;
                                    break;
                                }
                                break;
                            } while (true);
                            $remove = array_pop($this->parser->backtrace);
                            if (!$valid) {
                                $this->parser->failNode($remove);
                                $this->parser->pos = $pos15;
                                $this->parser->line = $line15;
                                $result = $backup15;
                            } else {
                                $this->parser->successNode($remove);
                            }
                            $error = $error15;
                            unset($backup15);
                            // end sequence
                            // End '( '{' var:Variable '}')'
                            if ($valid) {
                                $this->parser->successNode(array_pop($this->parser->backtrace));
                                $error = $error12;
                                break;
                            } else {
                                $this->parser->logOption($errorOption12, 'Variable', $error);
                            }
                            $error = $error12;
                            array_pop($this->parser->backtrace);
                            break;
                        } while (true);
                        // end option
                        $iteration11 = $valid ? ($iteration11 + 1) : $iteration11;
                        if (!$valid && $iteration11 >= 1) {
                            $valid = true;
                            break;
                        }
                        if (!$valid) {
                            break;
                        }
                    } while (true);
                    // End '( id:Id | ( '{' var:Variable '}'))+'
                    if (!$valid) {
                        $this->parser->matchError($error10, 'SequenceElement', $error);
                        $error = $error10;
                        break;
                    }
                    $error = array();
                    // Start '( '@' property:Id)?' min '0' max '1'
                    $error = array();
                    // start sequence
                    $backup20 = $result;
                    $pos20 = $this->parser->pos;
                    $line20 = $this->parser->line;
                    $error20 = $error;
                    $this->parser->addBacktrace(array('_s20_', ''));
                    do {
                        $error = array();
                        // Start ''@'' min '1' max '1'
                        if ('@' == substr($this->parser->source, $this->parser->pos, 1)) {
                            $this->parser->pos += 1;
                            $result['_text'] .= '@';
                            $this->parser->successNode(array('\'@\'', '@'));
                            $valid = true;
                        } else {
                            $this->parser->matchError($error, 'literal', '@');
                            $this->parser->failNode(array('\'@\'', ''));
                            $valid = false;
                        }
                        // End ''@''
                        if (!$valid) {
                            $this->parser->matchError($error20, 'SequenceElement', $error);
                            $error = $error20;
                            break;
                        }
                        $error = array();
                        // Start 'property:Id' tag 'property' min '1' max '1'
                        $this->parser->addBacktrace(array('Id', ''));
                        $subres = $this->parser->matchRule($result, 'Id', $error);
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('Id', $subres['_text']));
                            $result['_text'] .= $subres['_text'];
                            $this->Variable_property($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'property:Id'
                        if (!$valid) {
                            $this->parser->matchError($error20, 'SequenceElement', $error);
                            $error = $error20;
                            break;
                        }
                        break;
                    } while (true);
                    $remove = array_pop($this->parser->backtrace);
                    if (!$valid) {
                        $this->parser->failNode($remove);
                        $this->parser->pos = $pos20;
                        $this->parser->line = $line20;
                        $result = $backup20;
                    } else {
                        $this->parser->successNode($remove);
                    }
                    $error = $error20;
                    unset($backup20);
                    // end sequence
                    if (!$valid) {
                        $this->parser->logOption($errorResult, 'Variable', $error);
                    }
                    $valid = true;
                    // End '( '@' property:Id)?'
                    if (!$valid) {
                        $this->parser->matchError($error10, 'SequenceElement', $error);
                        $error = $error10;
                        break;
                    }
                    $error = array();
                    // Start '( ( &/\.|\[/ Arrayelement) | ( &'->' Object))*' min '0' max 'null'
                    $iteration23 = 0;
                    do {
                        // start option
                        $error24 = $error;
                        $errorOption24 = array();
                        $this->parser->addBacktrace(array('_o24_', ''));
                        do {
                            $error = array();
                            array_pop($this->parser->backtrace);
                            $this->parser->addBacktrace(array('_o24:1_', ''));
                            // Start '( &/\.|\[/ Arrayelement)' min '1' max '1'
                            // start sequence
                            $backup26 = $result;
                            $pos26 = $this->parser->pos;
                            $line26 = $this->parser->line;
                            $error26 = $error;
                            $this->parser->addBacktrace(array('_s26_', ''));
                            do {
                                $error = array();
                                // Start '&/\.|\[/' min '1' max '1' positive lookahead
                                $backup27 = $result;
                                $pos27 = $this->parser->pos;
                                $line27 = $this->parser->line;
                                $regexp = "/\\.|\\[/";
                                $pos = $this->parser->pos;
                                if (isset($this->parser->regexpCache['Variable29'][$pos])) {
                                    $subres = $this->parser->regexpCache['Variable29'][$pos];
                                } else {
                                    if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                                        $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                                        if ($subres['_startpos'] != $pos) {
                                            $this->parser->regexpCache['Variable29'][$subres['_startpos']] = $subres;
                                            $this->parser->regexpCache['Variable29'][$pos] = false;
                                            $subres = false;
                                        }
                                    } else {
                                        $this->parser->regexpCache['Variable29'][$pos] = false;
                                        $subres = false;
                                    }
                                }
                                if ($subres) {
                                    $subres['_lineno'] = $this->parser->line;
                                    $this->parser->pos = $subres['_endpos'];
                                    $this->parser->line += substr_count($subres['_text'], "\n");
                                    $subres['_tag'] = false;
                                    $subres['_name'] = 'Variable';
                                    $valid = true;
                                } else {
                                    $valid = false;
                                }
                                if ($valid) {
                                    $result['_text'] .= $subres['_text'];
                                } else {
                                    $this->parser->matchError($error, 'rx', "/\\.|\\[/");
                                }
                                $this->parser->pos = $pos27;
                                $this->parser->line = $line27;
                                $result = $backup27;
                                unset($backup27);
                                // End '&/\.|\[/'
                                if (!$valid) {
                                    $this->parser->matchError($error26, 'SequenceElement', $error);
                                    $error = $error26;
                                    break;
                                }
                                $error = array();
                                // Start 'Arrayelement' min '1' max '1'
                                $this->parser->addBacktrace(array('Arrayelement', ''));
                                $subres = $this->parser->matchRule($result, 'Arrayelement', $error);
                                $remove = array_pop($this->parser->backtrace);
                                if ($subres) {
                                    $this->parser->successNode(array('Arrayelement', $subres['_text']));
                                    $result['_text'] .= $subres['_text'];
                                    $valid = true;
                                } else {
                                    $valid = false;
                                    $this->parser->failNode($remove);
                                }
                                // End 'Arrayelement'
                                if (!$valid) {
                                    $this->parser->matchError($error26, 'SequenceElement', $error);
                                    $error = $error26;
                                    break;
                                }
                                break;
                            } while (true);
                            $remove = array_pop($this->parser->backtrace);
                            if (!$valid) {
                                $this->parser->failNode($remove);
                                $this->parser->pos = $pos26;
                                $this->parser->line = $line26;
                                $result = $backup26;
                            } else {
                                $this->parser->successNode($remove);
                            }
                            $error = $error26;
                            unset($backup26);
                            // end sequence
                            // End '( &/\.|\[/ Arrayelement)'
                            if ($valid) {
                                $this->parser->successNode(array_pop($this->parser->backtrace));
                                $error = $error24;
                                break;
                            } else {
                                $this->parser->logOption($errorOption24, 'Variable', $error);
                            }
                            $error = array();
                            array_pop($this->parser->backtrace);
                            $this->parser->addBacktrace(array('_o24:2_', ''));
                            // Start '( &'->' Object)' min '1' max '1'
                            // start sequence
                            $backup31 = $result;
                            $pos31 = $this->parser->pos;
                            $line31 = $this->parser->line;
                            $error31 = $error;
                            $this->parser->addBacktrace(array('_s31_', ''));
                            do {
                                $error = array();
                                // Start '&'->'' min '1' max '1' positive lookahead
                                $backup32 = $result;
                                $pos32 = $this->parser->pos;
                                $line32 = $this->parser->line;
                                if ('->' == substr($this->parser->source, $this->parser->pos, 2)) {
                                    $this->parser->pos += 2;
                                    $result['_text'] .= '->';
                                    $this->parser->successNode(array('\'->\'', '->'));
                                    $valid = true;
                                } else {
                                    $this->parser->matchError($error, 'literal', '->');
                                    $this->parser->failNode(array('\'->\'', ''));
                                    $valid = false;
                                }
                                $this->parser->pos = $pos32;
                                $this->parser->line = $line32;
                                $result = $backup32;
                                unset($backup32);
                                // End '&'->''
                                if (!$valid) {
                                    $this->parser->matchError($error31, 'SequenceElement', $error);
                                    $error = $error31;
                                    break;
                                }
                                $error = array();
                                // Start 'Object' min '1' max '1'
                                $this->parser->addBacktrace(array('Object', ''));
                                $subres = $this->parser->matchRule($result, 'Object', $error);
                                $remove = array_pop($this->parser->backtrace);
                                if ($subres) {
                                    $this->parser->successNode(array('Object', $subres['_text']));
                                    $result['_text'] .= $subres['_text'];
                                    $valid = true;
                                } else {
                                    $valid = false;
                                    $this->parser->failNode($remove);
                                }
                                // End 'Object'
                                if (!$valid) {
                                    $this->parser->matchError($error31, 'SequenceElement', $error);
                                    $error = $error31;
                                    break;
                                }
                                break;
                            } while (true);
                            $remove = array_pop($this->parser->backtrace);
                            if (!$valid) {
                                $this->parser->failNode($remove);
                                $this->parser->pos = $pos31;
                                $this->parser->line = $line31;
                                $result = $backup31;
                            } else {
                                $this->parser->successNode($remove);
                            }
                            $error = $error31;
                            unset($backup31);
                            // end sequence
                            // End '( &'->' Object)'
                            if ($valid) {
                                $this->parser->successNode(array_pop($this->parser->backtrace));
                                $error = $error24;
                                break;
                            } else {
                                $this->parser->logOption($errorOption24, 'Variable', $error);
                            }
                            $error = $error24;
                            array_pop($this->parser->backtrace);
                            break;
                        } while (true);
                        // end option
                        $iteration23 = $valid ? ($iteration23 + 1) : $iteration23;
                        if (!$valid && $iteration23 >= 0) {
                            $valid = true;
                            break;
                        }
                        if (!$valid) {
                            break;
                        }
                    } while (true);
                    // End '( ( &/\.|\[/ Arrayelement) | ( &'->' Object))*'
                    if (!$valid) {
                        $this->parser->matchError($error10, 'SequenceElement', $error);
                        $error = $error10;
                        break;
                    }
                    break;
                } while (true);
                $remove = array_pop($this->parser->backtrace);
                if (!$valid) {
                    $this->parser->failNode($remove);
                    $this->parser->pos = $pos10;
                    $this->parser->line = $line10;
                    $result = $backup10;
                } else {
                    $this->parser->successNode($remove);
                }
                $error = $error10;
                unset($backup10);
                // end sequence
                // End '( ( id:Id | ( '{' var:Variable '}'))+ ( '@' property:Id)? ( ( &/\.|\[/ Arrayelement) | ( &'->' Object))*)'
                if (!$valid) {
                    $this->parser->matchError($error7, 'SequenceElement', $error);
                    $error = $error7;
                    break;
                }
                break;
            } while (true);
            $remove = array_pop($this->parser->backtrace);
            if (!$valid) {
                $this->parser->failNode($remove);
                $this->parser->pos = $pos7;
                $this->parser->line = $line7;
                $result = $backup7;
            } else {
                $this->parser->successNode($remove);
            }
            $error = $error7;
            unset($backup7);
            // end sequence
            // End '( isvar:'$' ( ( id:Id | ( '{' var:Variable '}'))+ ( '@' property:Id)? ( ( &/\.|\[/ Arrayelement) | ( &'->' Object))*))'
            if ($valid) {
                $this->parser->successNode(array_pop($this->parser->backtrace));
                $error = $error1;
                break;
            } else {
                $this->parser->logOption($errorOption1, 'Variable', $error);
            }
            $error = $error1;
            array_pop($this->parser->backtrace);
            break;
        } while (true);
        // end option
        // End 'Variable'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Variable___FINISH($result);
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Variable');
        }
        $this->parser->packCache[$pos0]['Variable'] = $result;
        $this->parser->errorCache[$pos0]['Variable'] = $error;
        return $result;
    }

    public function Variable___START(&$result, $previous)
    {
        $i = 1;
    }

    public function Variable_special(&$result, $subres)
    {
        $result['node'] = $subres['node'];
    }

    public function Variable_isvar(&$result, $subres)
    {
        $result['node'] = new Node($this->parser, 'Variable');
    }

    public function Variable_id(&$result, $subres)
    {
        $node = new String($this->parser);
        $result['node']->addSubTree($node->setValue($subres['_text'], true)
                                         ->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']), 'name', true);
    }

    public function Variable_var(&$result, $subres)
    {
        $result['node']->addSubTree($subres['node'], 'name', true);
    }

    public function Variable_property(&$result, $subres)
    {
        $result['node']->addSubTree($subres['_text'], 'property');
    }

    public function Variable___FINISH(&$result)
    {
        $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
    }

    /**
     * Parser rules and action for node 'Arrayelement'
     *  Rule:
     * <node Arrayelement>
     * <rule>(('.' ( iv:Id | value:Value)) | ('['  value:Expr ']'))+</rule>
     * <action _start>
     * {
     * $result['node'] = $previous['node'];
     * }
     * </action>
     * <action value>
     * {
     * $result['node']->addSubTree(array('type' => 'arrayelement', 'node' => $subres['node']) , 'suffix', true);
     * }
     * </action>
     * <action iv>
     * {
     * $node = new String($this->parser);
     * $result['node']->addSubTree(array('type' => 'arrayelement', 'node' => $node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']) , 'suffix', true));
     * }
     * </action>
     * </node>


     */
    public function matchNodeArrayelement($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->Arrayelement___START($result, $previous);
        // Start '( ( '.' ( iv:Id | value:Value)) | ( '[' value:Expr ']'))+' min '1' max 'null'
        $iteration0 = 0;
        do {
            // start option
            $error1 = $error;
            $errorOption1 = array();
            $this->parser->addBacktrace(array('_o1_', ''));
            do {
                $error = array();
                array_pop($this->parser->backtrace);
                $this->parser->addBacktrace(array('_o1:1_', ''));
                // Start '( '.' ( iv:Id | value:Value))' min '1' max '1'
                // start sequence
                $backup3 = $result;
                $pos3 = $this->parser->pos;
                $line3 = $this->parser->line;
                $error3 = $error;
                $this->parser->addBacktrace(array('_s3_', ''));
                do {
                    $error = array();
                    // Start ''.'' min '1' max '1'
                    if ('.' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= '.';
                        $this->parser->successNode(array('\'.\'', '.'));
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', '.');
                        $this->parser->failNode(array('\'.\'', ''));
                        $valid = false;
                    }
                    // End ''.''
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    $error = array();
                    // Start '( iv:Id | value:Value)' min '1' max '1'
                    // start option
                    $error6 = $error;
                    $errorOption6 = array();
                    $this->parser->addBacktrace(array('_o6_', ''));
                    do {
                        $error = array();
                        array_pop($this->parser->backtrace);
                        $this->parser->addBacktrace(array('_o6:1_', ''));
                        // Start 'iv:Id' tag 'iv' min '1' max '1'
                        $this->parser->addBacktrace(array('Id', ''));
                        $subres = $this->parser->matchRule($result, 'Id', $error);
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('Id', $subres['_text']));
                            $result['_text'] .= $subres['_text'];
                            $this->Arrayelement_iv($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'iv:Id'
                        if ($valid) {
                            $this->parser->successNode(array_pop($this->parser->backtrace));
                            $error = $error6;
                            break;
                        } else {
                            $this->parser->logOption($errorOption6, 'Arrayelement', $error);
                        }
                        $error = array();
                        array_pop($this->parser->backtrace);
                        $this->parser->addBacktrace(array('_o6:2_', ''));
                        // Start 'value:Value' tag 'value' min '1' max '1'
                        $this->parser->addBacktrace(array('Value', ''));
                        $subres = $this->parser->matchRule($result, 'Value', $error);
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('Value', $subres['_text']));
                            $result['_text'] .= $subres['_text'];
                            $this->Arrayelement_value($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'value:Value'
                        if ($valid) {
                            $this->parser->successNode(array_pop($this->parser->backtrace));
                            $error = $error6;
                            break;
                        } else {
                            $this->parser->logOption($errorOption6, 'Arrayelement', $error);
                        }
                        $error = $error6;
                        array_pop($this->parser->backtrace);
                        break;
                    } while (true);
                    // end option
                    // End '( iv:Id | value:Value)'
                    if (!$valid) {
                        $this->parser->matchError($error3, 'SequenceElement', $error);
                        $error = $error3;
                        break;
                    }
                    break;
                } while (true);
                $remove = array_pop($this->parser->backtrace);
                if (!$valid) {
                    $this->parser->failNode($remove);
                    $this->parser->pos = $pos3;
                    $this->parser->line = $line3;
                    $result = $backup3;
                } else {
                    $this->parser->successNode($remove);
                }
                $error = $error3;
                unset($backup3);
                // end sequence
                // End '( '.' ( iv:Id | value:Value))'
                if ($valid) {
                    $this->parser->successNode(array_pop($this->parser->backtrace));
                    $error = $error1;
                    break;
                } else {
                    $this->parser->logOption($errorOption1, 'Arrayelement', $error);
                }
                $error = array();
                array_pop($this->parser->backtrace);
                $this->parser->addBacktrace(array('_o1:2_', ''));
                // Start '( '[' value:Expr ']')' min '1' max '1'
                // start sequence
                $backup10 = $result;
                $pos10 = $this->parser->pos;
                $line10 = $this->parser->line;
                $error10 = $error;
                $this->parser->addBacktrace(array('_s10_', ''));
                do {
                    $error = array();
                    // Start ''['' min '1' max '1'
                    if ('[' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= '[';
                        $this->parser->successNode(array('\'[\'', '['));
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', '[');
                        $this->parser->failNode(array('\'[\'', ''));
                        $valid = false;
                    }
                    // End ''[''
                    if (!$valid) {
                        $this->parser->matchError($error10, 'SequenceElement', $error);
                        $error = $error10;
                        break;
                    }
                    $error = array();
                    // Start 'value:Expr' tag 'value' min '1' max '1'
                    $this->parser->addBacktrace(array('Expr', ''));
                    $subres = $this->parser->matchRule($result, 'Expr', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Expr', $subres['_text']));
                        $result['_text'] .= $subres['_text'];
                        $this->Arrayelement_value($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'value:Expr'
                    if (!$valid) {
                        $this->parser->matchError($error10, 'SequenceElement', $error);
                        $error = $error10;
                        break;
                    }
                    $error = array();
                    // Start '']'' min '1' max '1'
                    if (']' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= ']';
                        $this->parser->successNode(array('\']\'', ']'));
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', ']');
                        $this->parser->failNode(array('\']\'', ''));
                        $valid = false;
                    }
                    // End '']''
                    if (!$valid) {
                        $this->parser->matchError($error10, 'SequenceElement', $error);
                        $error = $error10;
                        break;
                    }
                    break;
                } while (true);
                $remove = array_pop($this->parser->backtrace);
                if (!$valid) {
                    $this->parser->failNode($remove);
                    $this->parser->pos = $pos10;
                    $this->parser->line = $line10;
                    $result = $backup10;
                } else {
                    $this->parser->successNode($remove);
                }
                $error = $error10;
                unset($backup10);
                // end sequence
                // End '( '[' value:Expr ']')'
                if ($valid) {
                    $this->parser->successNode(array_pop($this->parser->backtrace));
                    $error = $error1;
                    break;
                } else {
                    $this->parser->logOption($errorOption1, 'Arrayelement', $error);
                }
                $error = $error1;
                array_pop($this->parser->backtrace);
                break;
            } while (true);
            // end option
            $iteration0 = $valid ? ($iteration0 + 1) : $iteration0;
            if (!$valid && $iteration0 >= 1) {
                $valid = true;
                break;
            }
            if (!$valid) {
                break;
            }
        } while (true);
        // End '( ( '.' ( iv:Id | value:Value)) | ( '[' value:Expr ']'))+'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Arrayelement');
        }
        return $result;
    }

    public function Arrayelement___START(&$result, $previous)
    {
        $result['node'] = $previous['node'];
    }

    public function Arrayelement_value(&$result, $subres)
    {
        $result['node']->addSubTree(array('type' => 'arrayelement', 'node' => $subres['node']), 'suffix', true);
    }

    public function Arrayelement_iv(&$result, $subres)
    {
        $node = new String($this->parser);
        $result['node']->addSubTree(array('type' => 'arrayelement', 'node' => $node->setValue($subres['_text'], true)
                                                                                   ->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']), 'suffix', true));
    }

    /**
     * Parser rules and action for node 'Object'
     *  Rule:
     * <token Object>
     * <rule>(addsuffix:('->' ( .iv:Id | .var:Variable) method:Parameter?))+</rule>
     * <action _start>
     * {
     * $result['node'] = $previous['node'];
     * }
     * </action>
     * <action iv>
     * {
     * $node = new String($this->parser);
     * $node->setValue($subres['_text'], true)->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
     * $result['name'] = $node;
     * }
     * </action>
     * <action var>
     * {
     * $result['name'] = $subres['node'];
     * }
     * </action>
     * <action method>
     * {
     * $result['method'] = $subres['node'];
     * }
     * </action>
     * <action addsuffix>
     * {
     * $result['node']->addSubTree(array('type' => 'object', 'name' => $subres['name'], 'method' => isset($subres['method']) ? $subres['method'] : null) , 'suffix', true);
     * }
     * </action>
     * </token>


     */
    public function matchNodeObject($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
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
            $error1 = $error;
            $this->parser->addBacktrace(array('_s1_', ''));
            do {
                $error = array();
                // Start ''->'' min '1' max '1'
                if ('->' == substr($this->parser->source, $this->parser->pos, 2)) {
                    $this->parser->pos += 2;
                    $result['_text'] .= '->';
                    $this->parser->successNode(array('\'->\'', '->'));
                    $valid = true;
                } else {
                    $this->parser->matchError($error, 'literal', '->');
                    $this->parser->failNode(array('\'->\'', ''));
                    $valid = false;
                }
                // End ''->''
                if (!$valid) {
                    $this->parser->matchError($error1, 'SequenceElement', $error);
                    $error = $error1;
                    break;
                }
                $error = array();
                // Start '( .iv:Id | .var:Variable)' min '1' max '1'
                // start option
                $error4 = $error;
                $errorOption4 = array();
                $this->parser->addBacktrace(array('_o4_', ''));
                do {
                    $error = array();
                    array_pop($this->parser->backtrace);
                    $this->parser->addBacktrace(array('_o4:1_', ''));
                    // Start '.iv:Id' tag 'iv' min '1' max '1'
                    $this->parser->addBacktrace(array('Id', ''));
                    $subres = $this->parser->matchRule($result, 'Id', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Id', $subres['_text']));
                        $this->Object_iv($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End '.iv:Id'
                    if ($valid) {
                        $this->parser->successNode(array_pop($this->parser->backtrace));
                        $error = $error4;
                        break;
                    } else {
                        $this->parser->logOption($errorOption4, 'Object', $error);
                    }
                    $error = array();
                    array_pop($this->parser->backtrace);
                    $this->parser->addBacktrace(array('_o4:2_', ''));
                    // Start '.var:Variable' tag 'var' min '1' max '1'
                    $this->parser->addBacktrace(array('Variable', ''));
                    $subres = $this->parser->matchRule($result, 'Variable', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Variable', $subres['_text']));
                        $this->Object_var($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End '.var:Variable'
                    if ($valid) {
                        $this->parser->successNode(array_pop($this->parser->backtrace));
                        $error = $error4;
                        break;
                    } else {
                        $this->parser->logOption($errorOption4, 'Object', $error);
                    }
                    $error = $error4;
                    array_pop($this->parser->backtrace);
                    break;
                } while (true);
                // end option
                // End '( .iv:Id | .var:Variable)'
                if (!$valid) {
                    $this->parser->matchError($error1, 'SequenceElement', $error);
                    $error = $error1;
                    break;
                }
                $error = array();
                // Start 'method:Parameter?' tag 'method' min '0' max '1'
                $error = array();
                $this->parser->addBacktrace(array('Parameter', ''));
                $subres = $this->parser->matchRule($result, 'Parameter', $error);
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Parameter', $subres['_text']));
                    $result['_text'] .= $subres['_text'];
                    $this->Object_method($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                if (!$valid) {
                    $this->parser->logOption($errorResult, 'Object', $error);
                }
                $valid = true;
                // End 'method:Parameter?'
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
            if (!$valid) {
                break;
            }
        } while (true);
        // End '( addsuffix:( '->' ( .iv:Id | .var:Variable) method:Parameter?))+'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Object');
        }
        return $result;
    }

    public function Object___START(&$result, $previous)
    {
        $result['node'] = $previous['node'];
    }

    public function Object_iv(&$result, $subres)
    {
        $node = new String($this->parser);
        $node->setValue($subres['_text'], true)
             ->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
        $result['name'] = $node;
    }

    public function Object_var(&$result, $subres)
    {
        $result['name'] = $subres['node'];
    }

    public function Object_method(&$result, $subres)
    {
        $result['method'] = $subres['node'];
    }

    public function Object_addsuffix(&$result, $subres)
    {
        $result['node']->addSubTree(array('type' => 'object', 'name' => $subres['name'], 'method' => isset($subres['method']) ? $subres['method'] : null), 'suffix', true);
    }
}
