<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\PegParser;

/**
 * Class TagIfParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class TagIfParser extends PegParser
{

    /**
     * Parser generated on 2014-08-15 04:06:53
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/TagIf.peg.inc' dated 2014-07-11 02:12:51

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
        "TagIf"       => "matchNodeTagIf",
        "elseifTagif" => "matchNodeelseifTagif",
        "elseTagif"   => "matchNodeelseTagif"
    );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
        "TagIf"       => array(
            "_nodetype"  => "node",
            "attributes" => array(
                "subtags" => array(
                    "elseif" => true,
                    "else"   => true
                )
            ),
            "options"    => "nocache"
        ),
        "elseifTagif" => array(
            "_nodetype" => "token"
        ),
        "elseTagif"   => array(
            "_nodetype" => "token"
        )
    );

    /**
     * Parser rules and action for node 'TagIf'
     *  Rule:
     * <node TagIf>
     * <attribute>attributes=(subtags=(elseif,else)),options=nocache</attribute>
     * <rule>Ldel 'if' _ condition:( Unilog? Statement) | condition:Logexpr SmartyTagOptions Rdel body:Body? (!SmartyBlockCloseTag elseifTagif)* (!SmartyBlockCloseTag elseTagif)? close:SmartyBlockCloseTag</rule>
     * <action _start>
     * {
     * $result['node'] = $previous['node'];
     * }
     * </action>
     * <action condition>
     * {
     * $result['condition'] = $subres['node'];
     * }
     * </action>
     * <action body>
     * {
     * $result['body'] = $subres['node'];
     * }
     * </action>
     * <action _finish>
     * {
     * $result['node']->addSubTree(array('condition' => $result['condition'], 'body' => isset($result['body']) ? $result['body'] : false),'if');
     * }
     * </action>
     * </node>


     */
    public function matchNodeTagIf($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->TagIf___START($result, $previous);
        // Start 'TagIf' min '1' max '1'
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
            // Start ''if'' min '1' max '1'
            if ('if' == substr($this->parser->source, $this->parser->pos, 2)) {
                $this->parser->pos += 2;
                $result['_text'] .= 'if';
                $this->parser->successNode(array('\'if\'', 'if'));
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', 'if');
                $this->parser->failNode(array('\'if\'', ''));
                $valid = false;
            }
            // End ''if''
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start '_' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                if (!empty($match[0])) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                    $result['_text'] .= ' ';
                    $valid = true;
                } else {
                    $valid = false;
                }
            } else {
                $valid = false;
            }
            if ($valid) {
                $this->parser->successNode(array("' '", ' '));
            } else {
                $this->parser->failNode(array("' '", ''));
            }
            // End '_'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'TagIf' min '1' max '1'
            // start option
            $error6 = $error;
            $errorOption6 = array();
            $this->parser->addBacktrace(array('_o6_', ''));
            do {
                $error = array();
                array_pop($this->parser->backtrace);
                $this->parser->addBacktrace(array('_o6:1_', ''));
                // Start 'condition:( Unilog? Statement)' tag 'condition' min '1' max '1'
                // start sequence
                $backup8 = $result;
                $pos8 = $this->parser->pos;
                $line8 = $this->parser->line;
                $error8 = $error;
                $this->parser->addBacktrace(array('_s8_', ''));
                do {
                    $error = array();
                    // Start 'Unilog?' min '0' max '1'
                    $error = array();
                    $this->parser->addBacktrace(array('Unilog', ''));
                    $subres = $this->parser->matchRule($result, 'Unilog', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Unilog', $subres['_text']));
                        $result['_text'] .= $subres['_text'];
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    if (!$valid) {
                        $this->parser->logOption($errorResult, 'TagIf', $error);
                    }
                    $valid = true;
                    // End 'Unilog?'
                    if (!$valid) {
                        $this->parser->matchError($error8, 'SequenceElement', $error);
                        $error = $error8;
                        break;
                    }
                    $error = array();
                    // Start 'Statement' min '1' max '1'
                    $this->parser->addBacktrace(array('Statement', ''));
                    $subres = $this->parser->matchRule($result, 'Statement', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Statement', $subres['_text']));
                        $result['_text'] .= $subres['_text'];
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'Statement'
                    if (!$valid) {
                        $this->parser->matchError($error8, 'SequenceElement', $error);
                        $error = $error8;
                        break;
                    }
                    break;
                } while (true);
                $remove = array_pop($this->parser->backtrace);
                if (!$valid) {
                    $this->parser->failNode($remove);
                    $this->parser->pos = $pos8;
                    $this->parser->line = $line8;
                    $result = $backup8;
                } else {
                    $this->parser->successNode($remove);
                }
                $error = $error8;
                if ($valid) {
                    $backup8['_text'] .= $result['_text'];
                    $this->TagIf_condition($backup8, $result);
                }
                $result = $backup8;
                unset($backup8);
                // end sequence
                // End 'condition:( Unilog? Statement)'
                if ($valid) {
                    $this->parser->successNode(array_pop($this->parser->backtrace));
                    $error = $error6;
                    break;
                } else {
                    $this->parser->logOption($errorOption6, 'TagIf', $error);
                }
                $error = array();
                array_pop($this->parser->backtrace);
                $this->parser->addBacktrace(array('_o6:2_', ''));
                // Start 'condition:Logexpr' tag 'condition' min '1' max '1'
                $this->parser->addBacktrace(array('Logexpr', ''));
                $subres = $this->parser->matchRule($result, 'Logexpr', $error);
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Logexpr', $subres['_text']));
                    $result['_text'] .= $subres['_text'];
                    $this->TagIf_condition($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'condition:Logexpr'
                if ($valid) {
                    $this->parser->successNode(array_pop($this->parser->backtrace));
                    $error = $error6;
                    break;
                } else {
                    $this->parser->logOption($errorOption6, 'TagIf', $error);
                }
                $error = $error6;
                array_pop($this->parser->backtrace);
                break;
            } while (true);
            // end option
            // End 'TagIf'
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
            $error = array();
            // Start 'body:Body?' tag 'body' min '0' max '1'
            $error = array();
            $this->parser->addBacktrace(array('Body', ''));
            $subres = $this->parser->matchRule($result, 'Body', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Body', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $this->TagIf_body($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, 'TagIf', $error);
            }
            $valid = true;
            // End 'body:Body?'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start '( !SmartyBlockCloseTag elseifTagif)*' min '0' max 'null'
            $iteration15 = 0;
            do {
                // start sequence
                $backup16 = $result;
                $pos16 = $this->parser->pos;
                $line16 = $this->parser->line;
                $error16 = $error;
                $this->parser->addBacktrace(array('_s16_', ''));
                do {
                    $error = array();
                    // Start '!SmartyBlockCloseTag' min '1' max '1' negative lookahead
                    $backup17 = $result;
                    $pos17 = $this->parser->pos;
                    $line17 = $this->parser->line;
                    $this->parser->addBacktrace(array('SmartyBlockCloseTag', ''));
                    $subres = $this->parser->matchRule($result, 'SmartyBlockCloseTag', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('SmartyBlockCloseTag', $subres['_text']));
                        $result['_text'] .= $subres['_text'];
                        $valid = false;
                    } else {
                        $valid = true;
                        $this->parser->failNode($remove);
                    }
                    $this->parser->pos = $pos17;
                    $this->parser->line = $line17;
                    $result = $backup17;
                    unset($backup17);
                    // End '!SmartyBlockCloseTag'
                    if (!$valid) {
                        $this->parser->matchError($error16, 'SequenceElement', $error);
                        $error = $error16;
                        break;
                    }
                    $error = array();
                    // Start 'elseifTagif' min '1' max '1'
                    $this->parser->addBacktrace(array('elseifTagif', ''));
                    $subres = $this->parser->matchRule($result, 'elseifTagif', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('elseifTagif', $subres['_text']));
                        $result['_text'] .= $subres['_text'];
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'elseifTagif'
                    if (!$valid) {
                        $this->parser->matchError($error16, 'SequenceElement', $error);
                        $error = $error16;
                        break;
                    }
                    break;
                } while (true);
                $remove = array_pop($this->parser->backtrace);
                if (!$valid) {
                    $this->parser->failNode($remove);
                    $this->parser->pos = $pos16;
                    $this->parser->line = $line16;
                    $result = $backup16;
                } else {
                    $this->parser->successNode($remove);
                }
                $error = $error16;
                unset($backup16);
                // end sequence
                $iteration15 = $valid ? ($iteration15 + 1) : $iteration15;
                if (!$valid && $iteration15 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) {
                    break;
                }
            } while (true);
            // End '( !SmartyBlockCloseTag elseifTagif)*'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start '( !SmartyBlockCloseTag elseTagif)?' min '0' max '1'
            $error = array();
            // start sequence
            $backup20 = $result;
            $pos20 = $this->parser->pos;
            $line20 = $this->parser->line;
            $error20 = $error;
            $this->parser->addBacktrace(array('_s20_', ''));
            do {
                $error = array();
                // Start '!SmartyBlockCloseTag' min '1' max '1' negative lookahead
                $backup21 = $result;
                $pos21 = $this->parser->pos;
                $line21 = $this->parser->line;
                $this->parser->addBacktrace(array('SmartyBlockCloseTag', ''));
                $subres = $this->parser->matchRule($result, 'SmartyBlockCloseTag', $error);
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('SmartyBlockCloseTag', $subres['_text']));
                    $result['_text'] .= $subres['_text'];
                    $valid = false;
                } else {
                    $valid = true;
                    $this->parser->failNode($remove);
                }
                $this->parser->pos = $pos21;
                $this->parser->line = $line21;
                $result = $backup21;
                unset($backup21);
                // End '!SmartyBlockCloseTag'
                if (!$valid) {
                    $this->parser->matchError($error20, 'SequenceElement', $error);
                    $error = $error20;
                    break;
                }
                $error = array();
                // Start 'elseTagif' min '1' max '1'
                $this->parser->addBacktrace(array('elseTagif', ''));
                $subres = $this->parser->matchRule($result, 'elseTagif', $error);
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('elseTagif', $subres['_text']));
                    $result['_text'] .= $subres['_text'];
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'elseTagif'
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
                $this->parser->logOption($errorResult, 'TagIf', $error);
            }
            $valid = true;
            // End '( !SmartyBlockCloseTag elseTagif)?'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'close:SmartyBlockCloseTag' tag 'close' min '1' max '1'
            $this->parser->addBacktrace(array('SmartyBlockCloseTag', ''));
            $subres = $this->parser->matchRule($result, 'SmartyBlockCloseTag', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('SmartyBlockCloseTag', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                if (!isset($result['close'])) {
                    $result['close'] = $subres;
                } else {
                    if (!is_array($result['close'])) {
                        $result['close'] = array($result['close']);
                    }
                    $result['close'][] = $subres;
                }
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'close:SmartyBlockCloseTag'
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
        // End 'TagIf'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->TagIf___FINISH($result);
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'TagIf');
        }
        return $result;
    }

    public function TagIf___START(&$result, $previous)
    {
        $result['node'] = $previous['node'];
    }

    public function TagIf_condition(&$result, $subres)
    {
        $result['condition'] = $subres['node'];
    }

    public function TagIf_body(&$result, $subres)
    {
        $result['body'] = $subres['node'];
    }

    public function TagIf___FINISH(&$result)
    {
        $result['node']->addSubTree(array('condition' => $result['condition'], 'body' => isset($result['body']) ? $result['body'] : false), 'if');
    }

    /**
     * Parser rules and action for node 'elseifTagif'
     *  Rule:
     * <token elseifTagif>
     * <rule>Ldel 'elseif' _ condition:( Unilog? Statement) | condition:Logexpr Rdel body:Body?</rule>
     * <action _start>
     * {
     * $result['node'] = $previous['node'];
     * }
     * </action>
     * <action condition>
     * {
     * $result['condition'] = $subres['node'];
     * }
     * </action>
     * <action body>
     * {
     * $result['body'] = $subres['node'];
     * }
     * </action>
     * <action _finish>
     * {
     * $result['node']->addSubTree(array('condition' => $result['condition'], 'body' => isset($result['body']) ? $result['body'] : false),'elseif', true);
     * }
     * </action>
     * </token>


     */
    public function matchNodeelseifTagif($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->elseifTagif___START($result, $previous);
        // Start 'elseifTagif' min '1' max '1'
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
            // Start ''elseif'' min '1' max '1'
            if ('elseif' == substr($this->parser->source, $this->parser->pos, 6)) {
                $this->parser->pos += 6;
                $result['_text'] .= 'elseif';
                $this->parser->successNode(array('\'elseif\'', 'elseif'));
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', 'elseif');
                $this->parser->failNode(array('\'elseif\'', ''));
                $valid = false;
            }
            // End ''elseif''
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start '_' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                if (!empty($match[0])) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                    $result['_text'] .= ' ';
                    $valid = true;
                } else {
                    $valid = false;
                }
            } else {
                $valid = false;
            }
            if ($valid) {
                $this->parser->successNode(array("' '", ' '));
            } else {
                $this->parser->failNode(array("' '", ''));
            }
            // End '_'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'elseifTagif' min '1' max '1'
            // start option
            $error6 = $error;
            $errorOption6 = array();
            $this->parser->addBacktrace(array('_o6_', ''));
            do {
                $error = array();
                array_pop($this->parser->backtrace);
                $this->parser->addBacktrace(array('_o6:1_', ''));
                // Start 'condition:( Unilog? Statement)' tag 'condition' min '1' max '1'
                // start sequence
                $backup8 = $result;
                $pos8 = $this->parser->pos;
                $line8 = $this->parser->line;
                $error8 = $error;
                $this->parser->addBacktrace(array('_s8_', ''));
                do {
                    $error = array();
                    // Start 'Unilog?' min '0' max '1'
                    $error = array();
                    $this->parser->addBacktrace(array('Unilog', ''));
                    $subres = $this->parser->matchRule($result, 'Unilog', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Unilog', $subres['_text']));
                        $result['_text'] .= $subres['_text'];
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    if (!$valid) {
                        $this->parser->logOption($errorResult, 'elseifTagif', $error);
                    }
                    $valid = true;
                    // End 'Unilog?'
                    if (!$valid) {
                        $this->parser->matchError($error8, 'SequenceElement', $error);
                        $error = $error8;
                        break;
                    }
                    $error = array();
                    // Start 'Statement' min '1' max '1'
                    $this->parser->addBacktrace(array('Statement', ''));
                    $subres = $this->parser->matchRule($result, 'Statement', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Statement', $subres['_text']));
                        $result['_text'] .= $subres['_text'];
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'Statement'
                    if (!$valid) {
                        $this->parser->matchError($error8, 'SequenceElement', $error);
                        $error = $error8;
                        break;
                    }
                    break;
                } while (true);
                $remove = array_pop($this->parser->backtrace);
                if (!$valid) {
                    $this->parser->failNode($remove);
                    $this->parser->pos = $pos8;
                    $this->parser->line = $line8;
                    $result = $backup8;
                } else {
                    $this->parser->successNode($remove);
                }
                $error = $error8;
                if ($valid) {
                    $backup8['_text'] .= $result['_text'];
                    $this->elseifTagif_condition($backup8, $result);
                }
                $result = $backup8;
                unset($backup8);
                // end sequence
                // End 'condition:( Unilog? Statement)'
                if ($valid) {
                    $this->parser->successNode(array_pop($this->parser->backtrace));
                    $error = $error6;
                    break;
                } else {
                    $this->parser->logOption($errorOption6, 'elseifTagif', $error);
                }
                $error = array();
                array_pop($this->parser->backtrace);
                $this->parser->addBacktrace(array('_o6:2_', ''));
                // Start 'condition:Logexpr' tag 'condition' min '1' max '1'
                $this->parser->addBacktrace(array('Logexpr', ''));
                $subres = $this->parser->matchRule($result, 'Logexpr', $error);
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Logexpr', $subres['_text']));
                    $result['_text'] .= $subres['_text'];
                    $this->elseifTagif_condition($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'condition:Logexpr'
                if ($valid) {
                    $this->parser->successNode(array_pop($this->parser->backtrace));
                    $error = $error6;
                    break;
                } else {
                    $this->parser->logOption($errorOption6, 'elseifTagif', $error);
                }
                $error = $error6;
                array_pop($this->parser->backtrace);
                break;
            } while (true);
            // end option
            // End 'elseifTagif'
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
            $error = array();
            // Start 'body:Body?' tag 'body' min '0' max '1'
            $error = array();
            $this->parser->addBacktrace(array('Body', ''));
            $subres = $this->parser->matchRule($result, 'Body', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Body', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $this->elseifTagif_body($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, 'elseifTagif', $error);
            }
            $valid = true;
            // End 'body:Body?'
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
        // End 'elseifTagif'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->elseifTagif___FINISH($result);
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'elseifTagif');
        }
        return $result;
    }

    public function elseifTagif___START(&$result, $previous)
    {
        $result['node'] = $previous['node'];
    }

    public function elseifTagif_condition(&$result, $subres)
    {
        $result['condition'] = $subres['node'];
    }

    public function elseifTagif_body(&$result, $subres)
    {
        $result['body'] = $subres['node'];
    }

    public function elseifTagif___FINISH(&$result)
    {
        $result['node']->addSubTree(array('condition' => $result['condition'], 'body' => isset($result['body']) ? $result['body'] : false), 'elseif', true);
    }

    /**
     * Parser rules and action for node 'elseTagif'
     *  Rule:
     * <token elseTagif>
     * <rule>Ldel 'else'  Rdel body:Body?</rule>
     * <action _start>
     * {
     * $result['node'] = $previous['node'];
     * }
     * </action>
     * <action body>
     * {
     * $result['body'] = $subres['node'];
     * }
     * </action>
     * <action _finish>
     * {
     * $result['node']->addSubTree(array('body' => isset($result['body']) ? $result['body'] : false),'else');
     * }
     * </action>
     * </token>


     */
    public function matchNodeelseTagif($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->elseTagif___START($result, $previous);
        // Start 'elseTagif' min '1' max '1'
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
            // Start ''else'' min '1' max '1'
            if ('else' == substr($this->parser->source, $this->parser->pos, 4)) {
                $this->parser->pos += 4;
                $result['_text'] .= 'else';
                $this->parser->successNode(array('\'else\'', 'else'));
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', 'else');
                $this->parser->failNode(array('\'else\'', ''));
                $valid = false;
            }
            // End ''else''
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
            $error = array();
            // Start 'body:Body?' tag 'body' min '0' max '1'
            $error = array();
            $this->parser->addBacktrace(array('Body', ''));
            $subres = $this->parser->matchRule($result, 'Body', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Body', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $this->elseTagif_body($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, 'elseTagif', $error);
            }
            $valid = true;
            // End 'body:Body?'
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
        // End 'elseTagif'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->elseTagif___FINISH($result);
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'elseTagif');
        }
        return $result;
    }

    public function elseTagif___START(&$result, $previous)
    {
        $result['node'] = $previous['node'];
    }

    public function elseTagif_body(&$result, $subres)
    {
        $result['body'] = $subres['node'];
    }

    public function elseTagif___FINISH(&$result)
    {
        $result['node']->addSubTree(array('body' => isset($result['body']) ? $result['body'] : false), 'else');
    }
}

