<?php
namespace Smarty\Parser\Source\Language\Smarty\Parser;

use Smarty\PegParser;
use Smarty\Node;

/**
 * Class CoreTagParser
 *
 * @package Smarty\Parser\Source\Language\Smarty\Parser
 */
class CoreTagParser extends PegParser
{

    /**
     * Parser generated on 2014-08-11 03:30:47
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Parser/Source/Language/Smarty/Parser/CoreTag.peg.inc' dated 2014-08-11 03:28:54

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
        "CoreTag"                  => "matchNodeCoreTag",
        "SmartyTagAttributes"      => "matchNodeSmartyTagAttributes",
        "SmartyTagOptions"         => "matchNodeSmartyTagOptions",
        "SmartyTagScopes"          => "matchNodeSmartyTagScopes",
        "Smarty_Tag_Default"       => "matchNodeSmarty_Tag_Default",
        "Smarty_Tag_Block_Default" => "matchNodeSmarty_Tag_Block_Default",
        "SmartyBlockCloseTag"      => "matchNodeSmartyBlockCloseTag",
        "SmartyTagPrefix"          => "matchNodeSmartyTagPrefix"
    );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
        "CoreTag"                  => array(
            "_nodetype" => "token"
        ),
        "SmartyTagAttributes"      => array(
            "_nodetype" => "token"
        ),
        "SmartyTagOptions"         => array(
            "_nodetype" => "token"
        ),
        "SmartyTagScopes"          => array(
            "_nodetype" => "token",
            "expected"  => array(
                "literal" => array(
                    "parent" => true,
                    "root"   => true,
                    "global" => true
                )
            )
        ),
        "Smarty_Tag_Default"       => array(
            "_nodetype" => "node"
        ),
        "Smarty_Tag_Block_Default" => array(
            "_nodetype" => "node"
        ),
        "SmartyBlockCloseTag"      => array(
            "_nodetype" => "token",
            "matchall"  => true
        ),
        "SmartyTagPrefix"          => array(
            "_nodetype" => "token",
            "matchall"  => true
        )
    );

    /**
     * Parser rules and action for node 'CoreTag'
     *  Rule:
     * #
     * #   Tag parsing
     * #   ###########
     * #
     * #   Except for the output tag a tag dispatcher is called.
     * #
     * #   The tag dispatcher scans for registered tags, plugins, template functions,
     * #   core language tags and calls the corresponding parser.
     * #
     * #
     * <token CoreTag>
     * <rule> ( tagname:SmartyTagPrefix tag:$SmartyTag) | ( !SmartyTagPrefix ( tag:TagOutput | tag:TagStatement )) </rule>
     * <action _start>
     * {
     * $i = 1;
     * }
     * </action>
     * <action _expression(SmartyTag)>
     * {
     * $result['_text'] = '';
     * return $this->parser->tagDispatcher($result);
     * }
     * </action>
     * <action tag>
     * {
     * $result['node'] = $subres['node'];
     * }
     * </action>
     * <action tagname>
     * {
     * $result['tagname'] = $subres['_matchres']['tagname'];
     * $result['savedstartpos'] = $subres['_startpos'];
     * $result['savedline'] = $subres['_lineno'];
     * }
     * </action>
     * </token>


     */
    public function matchNodeCoreTag($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->CoreTag___START($result, $previous);
        // Start 'CoreTag' min '1' max '1'
        // start option
        $error1 = $error;
        $errorOption1 = array();
        $this->parser->addBacktrace(array('_o1_', ''));
        do {
            $error = array();
            array_pop($this->parser->backtrace);
            $this->parser->addBacktrace(array('_o1:1_', ''));
            // Start '( tagname:SmartyTagPrefix tag:$SmartyTag)' min '1' max '1'
            // start sequence
            $backup3 = $result;
            $pos3 = $this->parser->pos;
            $line3 = $this->parser->line;
            $error3 = $error;
            $this->parser->addBacktrace(array('_s3_', ''));
            do {
                $error = array();
                // Start 'tagname:SmartyTagPrefix' tag 'tagname' min '1' max '1'
                $this->parser->addBacktrace(array('SmartyTagPrefix', ''));
                $subres = $this->parser->matchRule($result, 'SmartyTagPrefix', $error);
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('SmartyTagPrefix', $subres['_text']));
                    $result['_text'] .= $subres['_text'];
                    $this->CoreTag_tagname($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'tagname:SmartyTagPrefix'
                if (!$valid) {
                    $this->parser->matchError($error3, 'SequenceElement', $error);
                    $error = $error3;
                    break;
                }
                $error = array();
                // Start 'tag:$SmartyTag' tag 'tag' min '1' max '1'
                $subres = $result;
                $this->parser->addBacktrace(array('CoreTag', ''));
                $valid = false;
                $method = 'CoreTag_EXP_SmartyTag';
                $valid = $this->$method($subres);
                $remove = array_pop($this->parser->backtrace);
                if ($valid) {
                    $this->parser->successNode($remove);
                    $result['_text'] .= $subres['_text'];
                    $this->CoreTag_tag($result, $subres);
                } else {
                    $this->parser->matchError($error, 'expression', 'CoreTag');
                    $this->parser->failNode($remove);
                }
                // End 'tag:$SmartyTag'
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
            // End '( tagname:SmartyTagPrefix tag:$SmartyTag)'
            if ($valid) {
                $this->parser->successNode(array_pop($this->parser->backtrace));
                $error = $error1;
                break;
            } else {
                $this->parser->logOption($errorOption1, 'CoreTag', $error);
            }
            $error = array();
            array_pop($this->parser->backtrace);
            $this->parser->addBacktrace(array('_o1:2_', ''));
            // Start '( !SmartyTagPrefix ( tag:TagOutput | tag:TagStatement))' min '1' max '1'
            // start sequence
            $backup7 = $result;
            $pos7 = $this->parser->pos;
            $line7 = $this->parser->line;
            $error7 = $error;
            $this->parser->addBacktrace(array('_s7_', ''));
            do {
                $error = array();
                // Start '!SmartyTagPrefix' min '1' max '1' negative lookahead
                $backup8 = $result;
                $pos8 = $this->parser->pos;
                $line8 = $this->parser->line;
                $this->parser->addBacktrace(array('SmartyTagPrefix', ''));
                $subres = $this->parser->matchRule($result, 'SmartyTagPrefix', $error);
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('SmartyTagPrefix', $subres['_text']));
                    $result['_text'] .= $subres['_text'];
                    $valid = false;
                } else {
                    $valid = true;
                    $this->parser->failNode($remove);
                }
                $this->parser->pos = $pos8;
                $this->parser->line = $line8;
                $result = $backup8;
                unset($backup8);
                // End '!SmartyTagPrefix'
                if (!$valid) {
                    $this->parser->matchError($error7, 'SequenceElement', $error);
                    $error = $error7;
                    break;
                }
                $error = array();
                // Start '( tag:TagOutput | tag:TagStatement)' min '1' max '1'
                // start option
                $error10 = $error;
                $errorOption10 = array();
                $this->parser->addBacktrace(array('_o10_', ''));
                do {
                    $error = array();
                    array_pop($this->parser->backtrace);
                    $this->parser->addBacktrace(array('_o10:1_', ''));
                    // Start 'tag:TagOutput' tag 'tag' min '1' max '1'
                    $this->parser->addBacktrace(array('TagOutput', ''));
                    $subres = $this->parser->matchRule($result, 'TagOutput', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('TagOutput', $subres['_text']));
                        $result['_text'] .= $subres['_text'];
                        $this->CoreTag_tag($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'tag:TagOutput'
                    if ($valid) {
                        $this->parser->successNode(array_pop($this->parser->backtrace));
                        $error = $error10;
                        break;
                    } else {
                        $this->parser->logOption($errorOption10, 'CoreTag', $error);
                    }
                    $error = array();
                    array_pop($this->parser->backtrace);
                    $this->parser->addBacktrace(array('_o10:2_', ''));
                    // Start 'tag:TagStatement' tag 'tag' min '1' max '1'
                    $this->parser->addBacktrace(array('TagStatement', ''));
                    $subres = $this->parser->matchRule($result, 'TagStatement', $error);
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('TagStatement', $subres['_text']));
                        $result['_text'] .= $subres['_text'];
                        $this->CoreTag_tag($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'tag:TagStatement'
                    if ($valid) {
                        $this->parser->successNode(array_pop($this->parser->backtrace));
                        $error = $error10;
                        break;
                    } else {
                        $this->parser->logOption($errorOption10, 'CoreTag', $error);
                    }
                    $error = $error10;
                    array_pop($this->parser->backtrace);
                    break;
                } while (true);
                // end option
                // End '( tag:TagOutput | tag:TagStatement)'
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
            // End '( !SmartyTagPrefix ( tag:TagOutput | tag:TagStatement))'
            if ($valid) {
                $this->parser->successNode(array_pop($this->parser->backtrace));
                $error = $error1;
                break;
            } else {
                $this->parser->logOption($errorOption1, 'CoreTag', $error);
            }
            $error = $error1;
            array_pop($this->parser->backtrace);
            break;
        } while (true);
        // end option
        // End 'CoreTag'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'CoreTag');
        }
        return $result;
    }

    public function CoreTag___START(&$result, $previous)
    {
        $i = 1;
    }

    public function CoreTag_EXP_SmartyTag(&$result)
    {
        $result['_text'] = '';
        return $this->parser->tagDispatcher($result);
    }

    public function CoreTag_tag(&$result, $subres)
    {
        $result['node'] = $subres['node'];
    }

    public function CoreTag_tagname(&$result, $subres)
    {
        $result['tagname'] = $subres['_matchres']['tagname'];
        $result['savedstartpos'] = $subres['_startpos'];
        $result['savedline'] = $subres['_lineno'];
    }

    /**
     * Parser rules and action for node 'SmartyTagAttributes'
     *  Rule:
     * <token SmartyTagAttributes>
     * <rule>  ( _  (&'scope' scope:SmartyTagScopes) | (( name:Id _? '=' _?)? value:Expr))* </rule>
     * <action _start>
     * {
     * $result['node'] = $previous['node'];
     * }
     * </action>
     * <action name>
     * {
     * $result['name'] = strtolower($subres['_text']);
     * }
     * </action>
     * <action value>
     * {
     * $result['node']->setTagAttribute(array(isset($result['name']) ? $result['name'] : null, $subres['node']));
     * }
     * </action>
     * <action scope>
     * {
     * $result['node']->setTagAttribute(array('scope', $subres['node']));
     * }
     * </action>
     * <action _finish>
     * {
     * $i = 1;
     * }
     * </action>
     * </token>


     */
    public function matchNodeSmartyTagAttributes($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->SmartyTagAttributes___START($result, $previous);
        // Start '( _ ( &'scope' scope:SmartyTagScopes) | ( ( name:Id _? '=' _?)? value:Expr))*' min '0' max 'null'
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
                // Start 'SmartyTagAttributes' min '1' max '1'
                // start option
                $error4 = $error;
                $errorOption4 = array();
                $this->parser->addBacktrace(array('_o4_', ''));
                do {
                    $error = array();
                    array_pop($this->parser->backtrace);
                    $this->parser->addBacktrace(array('_o4:1_', ''));
                    // Start '( &'scope' scope:SmartyTagScopes)' min '1' max '1'
                    // start sequence
                    $backup6 = $result;
                    $pos6 = $this->parser->pos;
                    $line6 = $this->parser->line;
                    $error6 = $error;
                    $this->parser->addBacktrace(array('_s6_', ''));
                    do {
                        $error = array();
                        // Start '&'scope'' min '1' max '1' positive lookahead
                        $backup7 = $result;
                        $pos7 = $this->parser->pos;
                        $line7 = $this->parser->line;
                        if ('scope' == substr($this->parser->source, $this->parser->pos, 5)) {
                            $this->parser->pos += 5;
                            $result['_text'] .= 'scope';
                            $this->parser->successNode(array('\'scope\'', 'scope'));
                            $valid = true;
                        } else {
                            $this->parser->matchError($error, 'literal', 'scope');
                            $this->parser->failNode(array('\'scope\'', ''));
                            $valid = false;
                        }
                        $this->parser->pos = $pos7;
                        $this->parser->line = $line7;
                        $result = $backup7;
                        unset($backup7);
                        // End '&'scope''
                        if (!$valid) {
                            $this->parser->matchError($error6, 'SequenceElement', $error);
                            $error = $error6;
                            break;
                        }
                        $error = array();
                        // Start 'scope:SmartyTagScopes' tag 'scope' min '1' max '1'
                        $this->parser->addBacktrace(array('SmartyTagScopes', ''));
                        $subres = $this->parser->matchRule($result, 'SmartyTagScopes', $error);
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('SmartyTagScopes', $subres['_text']));
                            $result['_text'] .= $subres['_text'];
                            $this->SmartyTagAttributes_scope($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'scope:SmartyTagScopes'
                        if (!$valid) {
                            $this->parser->matchError($error6, 'SequenceElement', $error);
                            $error = $error6;
                            break;
                        }
                        break;
                    } while (true);
                    $remove = array_pop($this->parser->backtrace);
                    if (!$valid) {
                        $this->parser->failNode($remove);
                        $this->parser->pos = $pos6;
                        $this->parser->line = $line6;
                        $result = $backup6;
                    } else {
                        $this->parser->successNode($remove);
                    }
                    $error = $error6;
                    unset($backup6);
                    // end sequence
                    // End '( &'scope' scope:SmartyTagScopes)'
                    if ($valid) {
                        $this->parser->successNode(array_pop($this->parser->backtrace));
                        $error = $error4;
                        break;
                    } else {
                        $this->parser->logOption($errorOption4, 'SmartyTagAttributes', $error);
                    }
                    $error = array();
                    array_pop($this->parser->backtrace);
                    $this->parser->addBacktrace(array('_o4:2_', ''));
                    // Start '( ( name:Id _? '=' _?)? value:Expr)' min '0' max '1'
                    $error = array();
                    // start sequence
                    $backup10 = $result;
                    $pos10 = $this->parser->pos;
                    $line10 = $this->parser->line;
                    $error10 = $error;
                    $this->parser->addBacktrace(array('_s10_', ''));
                    do {
                        $error = array();
                        // Start 'name:Id' tag 'name' min '1' max '1'
                        $this->parser->addBacktrace(array('Id', ''));
                        $subres = $this->parser->matchRule($result, 'Id', $error);
                        $remove = array_pop($this->parser->backtrace);
                        if ($subres) {
                            $this->parser->successNode(array('Id', $subres['_text']));
                            $result['_text'] .= $subres['_text'];
                            $this->SmartyTagAttributes_name($result, $subres);
                            $valid = true;
                        } else {
                            $valid = false;
                            $this->parser->failNode($remove);
                        }
                        // End 'name:Id'
                        if (!$valid) {
                            $this->parser->matchError($error10, 'SequenceElement', $error);
                            $error = $error10;
                            break;
                        }
                        $error = array();
                        // Start '_?' min '1' max '1'
                        if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                            if (!empty($match[0])) {
                                $this->parser->pos += strlen($match[0]);
                                $this->parser->line += substr_count($match[0], "\n");
                                $result['_text'] .= ' ';
                            }
                        }
                        $this->parser->successNode(array("' '", $match[0]));
                        $valid = true;
                        // End '_?'
                        if (!$valid) {
                            $this->parser->matchError($error10, 'SequenceElement', $error);
                            $error = $error10;
                            break;
                        }
                        $error = array();
                        // Start ''='' min '1' max '1'
                        if ('=' == substr($this->parser->source, $this->parser->pos, 1)) {
                            $this->parser->pos += 1;
                            $result['_text'] .= '=';
                            $this->parser->successNode(array('\'=\'', '='));
                            $valid = true;
                        } else {
                            $this->parser->matchError($error, 'literal', '=');
                            $this->parser->failNode(array('\'=\'', ''));
                            $valid = false;
                        }
                        // End ''=''
                        if (!$valid) {
                            $this->parser->matchError($error10, 'SequenceElement', $error);
                            $error = $error10;
                            break;
                        }
                        $error = array();
                        // Start '_?' min '1' max '1'
                        if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                            if (!empty($match[0])) {
                                $this->parser->pos += strlen($match[0]);
                                $this->parser->line += substr_count($match[0], "\n");
                                $result['_text'] .= ' ';
                            }
                        }
                        $this->parser->successNode(array("' '", $match[0]));
                        $valid = true;
                        // End '_?'
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
                            $this->SmartyTagAttributes_value($result, $subres);
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
                    if (!$valid) {
                        $this->parser->logOption($errorResult, 'SmartyTagAttributes', $error);
                    }
                    $valid = true;
                    // End '( ( name:Id _? '=' _?)? value:Expr)'
                    if ($valid) {
                        $this->parser->successNode(array_pop($this->parser->backtrace));
                        $error = $error4;
                        break;
                    } else {
                        $this->parser->logOption($errorOption4, 'SmartyTagAttributes', $error);
                    }
                    $error = $error4;
                    array_pop($this->parser->backtrace);
                    break;
                } while (true);
                // end option
                // End 'SmartyTagAttributes'
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
            $iteration0 = $valid ? ($iteration0 + 1) : $iteration0;
            if (!$valid && $iteration0 >= 0) {
                $valid = true;
                break;
            }
            if (!$valid) {
                break;
            }
        } while (true);
        // End '( _ ( &'scope' scope:SmartyTagScopes) | ( ( name:Id _? '=' _?)? value:Expr))*'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->SmartyTagAttributes___FINISH($result);
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'SmartyTagAttributes');
        }
        return $result;
    }

    public function SmartyTagAttributes___START(&$result, $previous)
    {
        $result['node'] = $previous['node'];
    }

    public function SmartyTagAttributes_name(&$result, $subres)
    {
        $result['name'] = strtolower($subres['_text']);
    }

    public function SmartyTagAttributes_value(&$result, $subres)
    {
        $result['node']->setTagAttribute(array(isset($result['name']) ? $result['name'] : null, $subres['node']));
    }

    public function SmartyTagAttributes_scope(&$result, $subres)
    {
        $result['node']->setTagAttribute(array('scope', $subres['node']));
    }

    public function SmartyTagAttributes___FINISH(&$result)
    {
        $i = 1;
    }

    /**
     * Parser rules and action for node 'SmartyTagOptions'
     *  Rule:
     * <token SmartyTagOptions>
     * <rule>  ( _ option:Id)* </rule>
     * <action _start>
     * {
     * $result['node'] = $previous['node'];
     * }
     * </action>
     * <action option>
     * {
     * $result['node']->setTagOption(strtolower($subres['_text']));
     * }
     * </action>
     * </token>


     */
    public function matchNodeSmartyTagOptions($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->SmartyTagOptions___START($result, $previous);
        // Start '( _ option:Id)*' min '0' max 'null'
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
                // Start 'option:Id' tag 'option' min '1' max '1'
                $this->parser->addBacktrace(array('Id', ''));
                $subres = $this->parser->matchRule($result, 'Id', $error);
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Id', $subres['_text']));
                    $result['_text'] .= $subres['_text'];
                    $this->SmartyTagOptions_option($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'option:Id'
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
            $iteration0 = $valid ? ($iteration0 + 1) : $iteration0;
            if (!$valid && $iteration0 >= 0) {
                $valid = true;
                break;
            }
            if (!$valid) {
                break;
            }
        } while (true);
        // End '( _ option:Id)*'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'SmartyTagOptions');
        }
        return $result;
    }

    public function SmartyTagOptions___START(&$result, $previous)
    {
        $result['node'] = $previous['node'];
    }

    public function SmartyTagOptions_option(&$result, $subres)
    {
        $result['node']->setTagOption(strtolower($subres['_text']));
    }

    /**
     * Parser rules and action for node 'SmartyTagScopes'
     *  Rule:
     * <token SmartyTagScopes>
     * <attribute>expected=(literal=(parent,root,global))</attribute>
     * <rule> 'scope' _? '=' _? /(?<scope>(parent|root|global))/ | error:Unexpected </rule>
     * <action _start>
     * {
     * $result['node'] = new Node($this->parser, 'SmartyTagScopes');
     * }
     * </action>
     * <action scope>
     * {
     * $result['node']->setValue(strtolower($subres['_matchres']['scope']));
     * }
     * </action>
     * <action error>
     * {
     * $result['node']->addError($subres['error']);
     * }
     * </action>
     * </token>


     */
    public function matchNodeSmartyTagScopes($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->SmartyTagScopes___START($result, $previous);
        // Start 'SmartyTagScopes' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        $error1 = $error;
        $this->parser->addBacktrace(array('_s1_', ''));
        do {
            $error = array();
            // Start ''scope'' min '1' max '1'
            if ('scope' == substr($this->parser->source, $this->parser->pos, 5)) {
                $this->parser->pos += 5;
                $result['_text'] .= 'scope';
                $this->parser->successNode(array('\'scope\'', 'scope'));
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', 'scope');
                $this->parser->failNode(array('\'scope\'', ''));
                $valid = false;
            }
            // End ''scope''
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start '_?' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                if (!empty($match[0])) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                    $result['_text'] .= ' ';
                }
            }
            $this->parser->successNode(array("' '", $match[0]));
            $valid = true;
            // End '_?'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start ''='' min '1' max '1'
            if ('=' == substr($this->parser->source, $this->parser->pos, 1)) {
                $this->parser->pos += 1;
                $result['_text'] .= '=';
                $this->parser->successNode(array('\'=\'', '='));
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', '=');
                $this->parser->failNode(array('\'=\'', ''));
                $valid = false;
            }
            // End ''=''
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start '_?' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                if (!empty($match[0])) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                    $result['_text'] .= ' ';
                }
            }
            $this->parser->successNode(array("' '", $match[0]));
            $valid = true;
            // End '_?'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'SmartyTagScopes' min '1' max '1'
            // start option
            $error7 = $error;
            $errorOption7 = array();
            $this->parser->addBacktrace(array('_o7_', ''));
            do {
                $error = array();
                array_pop($this->parser->backtrace);
                $this->parser->addBacktrace(array('_o7:1_', ''));
                // Start '/(?<scope>(parent|root|global))/' min '1' max '1'
                $regexp = "/(?<scope>(parent|root|global))/";
                $pos = $this->parser->pos;
                if (isset($this->parser->regexpCache['SmartyTagScopes10'][$pos])) {
                    $subres = $this->parser->regexpCache['SmartyTagScopes10'][$pos];
                } else {
                    if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                        if (strlen($match[0][0]) != 0) {
                            $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                            foreach ($match as $n => $v) {
                                if (is_string($n) && !empty($v[0])) {
                                    $subres['_matchres'][$n] = $v[0];
                                }
                            }
                            if ($subres['_startpos'] != $pos) {
                                $this->parser->regexpCache['SmartyTagScopes10'][$subres['_startpos']] = $subres;
                                $this->parser->regexpCache['SmartyTagScopes10'][$pos] = false;
                                $subres = false;
                            }
                        } else {
                            $this->parser->regexpCache['SmartyTagScopes10'][$pos] = false;
                            $subres = false;
                        }
                    } else {
                        $this->parser->regexpCache['SmartyTagScopes10'][$pos] = false;
                        $subres = false;
                    }
                }
                if ($subres) {
                    $subres['_lineno'] = $this->parser->line;
                    $this->parser->pos = $subres['_endpos'];
                    $this->parser->line += substr_count($subres['_text'], "\n");
                    $subres['_tag'] = false;
                    $subres['_name'] = 'SmartyTagScopes';
                    if (isset($subres['_matchres']['scope'])) {
                        $this->SmartyTagScopes_scope($result, $subres);
                        unset($subres['_matchres']['scope']);
                    }
                    $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
                    $valid = true;
                } else {
                    $valid = false;
                }
                if ($valid) {
                    $result['_text'] .= $subres['_text'];
                } else {
                    $this->parser->matchError($error, 'rx', "/(?<scope>(parent|root|global))/");
                }
                // End '/(?<scope>(parent|root|global))/'
                if ($valid) {
                    $this->parser->successNode(array_pop($this->parser->backtrace));
                    $error = $error7;
                    break;
                } else {
                    $this->parser->logOption($errorOption7, 'SmartyTagScopes', $error);
                }
                $error = array();
                array_pop($this->parser->backtrace);
                $this->parser->addBacktrace(array('_o7:2_', ''));
                // Start 'error:Unexpected' tag 'error' min '1' max '1'
                $this->parser->addBacktrace(array('Unexpected', ''));
                $subres = $this->parser->matchRule($result, 'Unexpected', $error);
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Unexpected', $subres['_text']));
                    $result['_text'] .= $subres['_text'];
                    $this->SmartyTagScopes_error($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'error:Unexpected'
                if ($valid) {
                    $this->parser->successNode(array_pop($this->parser->backtrace));
                    $error = $error7;
                    break;
                } else {
                    $this->parser->logOption($errorOption7, 'SmartyTagScopes', $error);
                }
                $error = $error7;
                array_pop($this->parser->backtrace);
                break;
            } while (true);
            // end option
            // End 'SmartyTagScopes'
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
        // End 'SmartyTagScopes'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'SmartyTagScopes');
        }
        return $result;
    }

    public function SmartyTagScopes___START(&$result, $previous)
    {
        $result['node'] = new Node($this->parser, 'SmartyTagScopes');
    }

    public function SmartyTagScopes_scope(&$result, $subres)
    {
        $result['node']->setValue(strtolower($subres['_matchres']['scope']));
    }

    public function SmartyTagScopes_error(&$result, $subres)
    {
        $result['node']->addError($subres['error']);
    }

    /**
     * Parser rules and action for node 'Smarty_Tag_Default'
     *  Rule:
     * <node Smarty_Tag_Default>
     * <rule> Ldel Id SmartyTagAttributes SmartyTagOptions Rdel </rule>
     * <action _start>
     * {
     * $result['node'] = $previous['node'];
     * }
     * </action>
     * <action _finish>
     * {
     * $result['tagAttributes'] = array();
     * if (isset($result['attrib'])) {
     * $result['tagAttributes'] = $result['attrib']['attrib'];
     * unset($result['attrib']);
     * }
     * $result['tagOptions'] = array();
     * if (isset($result['options'])) {
     * $result['tagOptions'] = $result['options']['Options'];
     * unset($result['options']);
     * }
     * }
     * </action>
     * </node>


     */
    public function matchNodeSmarty_Tag_Default($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->Smarty_Tag_Default___START($result, $previous);
        // Start 'Smarty_Tag_Default' min '1' max '1'
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
            // Start 'Id' min '1' max '1'
            $this->parser->addBacktrace(array('Id', ''));
            $subres = $this->parser->matchRule($result, 'Id', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Id', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Id'
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
        // End 'Smarty_Tag_Default'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Smarty_Tag_Default___FINISH($result);
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Smarty_Tag_Default');
        }
        return $result;
    }

    public function Smarty_Tag_Default___START(&$result, $previous)
    {
        $result['node'] = $previous['node'];
    }

    public function Smarty_Tag_Default___FINISH(&$result)
    {
        $result['tagAttributes'] = array();
        if (isset($result['attrib'])) {
            $result['tagAttributes'] = $result['attrib']['attrib'];
            unset($result['attrib']);
        }
        $result['tagOptions'] = array();
        if (isset($result['options'])) {
            $result['tagOptions'] = $result['options']['Options'];
            unset($result['options']);
        }
    }

    /**
     * Parser rules and action for node 'Smarty_Tag_Block_Default'
     *  Rule:
     * <node Smarty_Tag_Block_Default>
     * <rule> Smarty_Tag_Default body:Body Smarty_Tag_Block_Close</rule>
     * </node>


     */
    public function matchNodeSmarty_Tag_Block_Default($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Smarty_Tag_Block_Default' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        $error1 = $error;
        $this->parser->addBacktrace(array('_s1_', ''));
        do {
            $error = array();
            // Start 'Smarty_Tag_Default' min '1' max '1'
            $this->parser->addBacktrace(array('Smarty_Tag_Default', ''));
            $subres = $this->parser->matchRule($result, 'Smarty_Tag_Default', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Smarty_Tag_Default', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Smarty_Tag_Default'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'body:Body' tag 'body' min '1' max '1'
            $this->parser->addBacktrace(array('Body', ''));
            $subres = $this->parser->matchRule($result, 'Body', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Body', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                if (!isset($result['body'])) {
                    $result['body'] = $subres;
                } else {
                    if (!is_array($result['body'])) {
                        $result['body'] = array($result['body']);
                    }
                    $result['body'][] = $subres;
                }
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'body:Body'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'Smarty_Tag_Block_Close' min '1' max '1'
            $this->parser->addBacktrace(array('Smarty_Tag_Block_Close', ''));
            $subres = $this->parser->matchRule($result, 'Smarty_Tag_Block_Close', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Smarty_Tag_Block_Close', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Smarty_Tag_Block_Close'
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
        // End 'Smarty_Tag_Block_Default'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Smarty_Tag_Block_Default');
        }
        return $result;
    }

    /**
     * Parser rules and action for node 'SmartyBlockCloseTag'
     *  Rule:
     * <token SmartyBlockCloseTag>
     * <attribute>matchall</attribute>
     * # do not change! real left delimiter regular expression will be obtained by parser
     * <rule>/{getLdel}\/(?<name>[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* ){getRdel}/</rule>
     * <action _init(getLdel)>
     * {
     * return $this->parser->Ldel;
     * }
     * </action>
     * <action _init(getRdel)>
     * {
     * return $this->parser->Rdel;
     * }
     * </action>
     * </token>


     */
    public function matchNodeSmartyBlockCloseTag($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/{getLdel}\/(?<name>[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* ){getRdel}/' min '1' max '1'
        $regexp = "/{getLdel}\\/(?<name>[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]* ){getRdel}/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['SmartyBlockCloseTag2'][$pos])) {
            $subres = $this->parser->regexpCache['SmartyBlockCloseTag2'][$pos];
        } else {
            if (isset($this->parser->rxCache['SmartyBlockCloseTag2'])) {
                $regexp = $this->parser->rxCache['SmartyBlockCloseTag2'];
            } else {
                $this->parser->rxCache['SmartyBlockCloseTag2'] = $regexp = $this->parser->initRxReplace('SmartyBlockCloseTag', $regexp);
            }
            if (empty($this->parser->regexpCache['SmartyBlockCloseTag2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE + PREG_SET_ORDER, $pos)) {
                $this->parser->regexpCache['SmartyBlockCloseTag2'][- 1] = true;
                foreach ($matches as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                    foreach ($match as $n => $v) {
                        if (is_string($n) && !empty($v[0])) {
                            $subres['_matchres'][$n] = $v[0];
                        }
                    }
                    $this->parser->regexpCache['SmartyBlockCloseTag2'][$match[0][1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['SmartyBlockCloseTag2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['SmartyBlockCloseTag2'][$pos])) {
            $subres = $this->parser->regexpCache['SmartyBlockCloseTag2'][$pos];
        } else {
            $this->parser->regexpCache['SmartyBlockCloseTag2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'SmartyBlockCloseTag';
            $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        } else {
            $this->parser->matchError($error, 'rx', "/{getLdel}\\/(?<name>[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]* ){getRdel}/");
        }
        // End '/{getLdel}\/(?<name>[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* ){getRdel}/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'SmartyBlockCloseTag');
        }
        return $result;
    }

    public function SmartyBlockCloseTag_INIT_getLdel(&$rule)
    {
        return $this->parser->Ldel;
    }

    public function SmartyBlockCloseTag_INIT_getRdel(&$rule)
    {
        return $this->parser->Rdel;
    }

    /**
     * Parser rules and action for node 'SmartyTagPrefix'
     *  Rule:
     * <token SmartyTagPrefix>
     * <attribute>matchall</attribute>
     * # do not change! real left delimiter regular expression will be obtained by parser
     * <rule>/({getLdel})(?<tagname>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* ))(?!(\s*\())/</rule>
     * <action _init(getLdel)>
     * {
     * return $this->parser->Ldel;
     * }
     * </action>
     * </token>


     */
    public function matchNodeSmartyTagPrefix($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/({getLdel})(?<tagname>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* ))(?!(\s*\())/' min '1' max '1'
        $regexp = "/({getLdel})(?<tagname>([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]* ))(?!(\\s*\\())/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['SmartyTagPrefix2'][$pos])) {
            $subres = $this->parser->regexpCache['SmartyTagPrefix2'][$pos];
        } else {
            if (isset($this->parser->rxCache['SmartyTagPrefix2'])) {
                $regexp = $this->parser->rxCache['SmartyTagPrefix2'];
            } else {
                $this->parser->rxCache['SmartyTagPrefix2'] = $regexp = $this->parser->initRxReplace('SmartyTagPrefix', $regexp);
            }
            if (empty($this->parser->regexpCache['SmartyTagPrefix2']) && preg_match_all($regexp . 'Sx', $this->parser->source, $matches, PREG_OFFSET_CAPTURE + PREG_SET_ORDER, $pos)) {
                $this->parser->regexpCache['SmartyTagPrefix2'][- 1] = true;
                foreach ($matches as $match) {
                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                    foreach ($match as $n => $v) {
                        if (is_string($n) && !empty($v[0])) {
                            $subres['_matchres'][$n] = $v[0];
                        }
                    }
                    $this->parser->regexpCache['SmartyTagPrefix2'][$match[0][1]] = $subres;
                }
            } else {
                $this->parser->regexpCache['SmartyTagPrefix2'][- 1] = false;
                $subres = false;
            }
        }
        if (isset($this->parser->regexpCache['SmartyTagPrefix2'][$pos])) {
            $subres = $this->parser->regexpCache['SmartyTagPrefix2'][$pos];
        } else {
            $this->parser->regexpCache['SmartyTagPrefix2'][$pos] = false;
            $subres = false;
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'SmartyTagPrefix';
            $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        } else {
            $this->parser->matchError($error, 'rx', "/({getLdel})(?<tagname>([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]* ))(?!(\\s*\\())/");
        }
        // End '/({getLdel})(?<tagname>([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* ))(?!(\s*\())/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'SmartyTagPrefix');
        }
        return $result;
    }

    public function SmartyTagPrefix_INIT_getLdel(&$rule)
    {
        return $this->parser->Ldel;
    }
}
