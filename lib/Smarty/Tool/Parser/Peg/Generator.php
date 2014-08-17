<?php
namespace Smarty\Tool\Parser\Peg;

use Smarty\Tool\Parser\Peg\Nodes\ParserCompiler;
use Smarty\Tool\Parser\Peg\Nodes\Text;
Use Smarty\Tool\Parser\Peg\Root;
Use Smarty\Template\Context;
Use Smarty\Compiler;
Use Smarty\Parser;
use Smarty\Parser\Exception\NoRule;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Template
 */
class Generator extends Parser
{

    /**
     * @var null|Generator
     */
    public $parser = null;
    /**
     * @var null|Generator
     */
    public $context = null;

    /**
     * @var string
     */
    public $filename = '';

    /**
     * @var string
     */
    public $filetime = '';

    /**
     * @var string
     */
    public $whitespacePattern = '/[\s\t]*(([#][^\r\n]*)?([\r\n]+[\s\t]*))*/';

    /**
     * Parser generated on 2014-06-29 17:56:13
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Tool/Parser/Peg/InternalTool/ParserGenerator.peg.inc' dated 2014-06-29 17:10:50

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
        "attrvalue" => "matchNodeattrvalue",
        "attrentry" => "matchNodeattrentry",
        "attr"      => "matchNodeattr",
        "Name"      => "matchNodeName",
        "Header"    => "matchNodeHeader",
        "End"       => "matchNodeEnd",
        "Comment"   => "matchNodeComment",
        "Text"      => "matchNodeText",
        "Parser"    => "matchNodeParser",
        "Attribute" => "matchNodeAttribute",
        "Node"      => "matchNodeNode",
        "Rule"      => "matchNodeRule",
        "Action"    => "matchNodeAction",
        "PHP"       => "matchNodePHP",
        "Arguments" => "matchNodeArguments",
        "Option"    => "matchNodeOption",
        "Sequence"  => "matchNodeSequence",
        "RuleToken" => "matchNodeRuleToken",
        "File"      => "matchNodeFile"
    );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array();

    /**
     * Parser rules and action for node 'attrvalue'
     *  Rule:
     * <node attrvalue> <rule>  .._? (  /(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|("[^"]*")|\d+|\w+))/ | (  '(' sub:attr ')' ) ) </rule>  <action sub> {
     * $result['value'] = $subres['_attr'];
     * } </action>  <action _finish> {
     * $mr = $result['_matchres'];
     * if (isset($mr['v1']) && !empty($mr['v1'])) {
     * $result['value'] = trim($mr['v1'], "'\"");
     * }
     * if (isset($mr['true']) && !empty($mr['true'])) {
     * $result['value'] = true;
     * }
     * if (isset($mr['false']) && !empty($mr['false'])) {
     * $result['value'] = false;
     * }
     * if (isset($mr['null']) && !empty($mr['null'])) {
     * $result['value'] = null;
     * }
     * $result['_matchres'] = array();
     * } </action> </node>

     */
    public function matchNodeattrvalue($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'attrvalue' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'attrvalue' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'attrvalue'
            if (!$valid) {
                break;
            }
            // Start 'attrvalue' min '1' max '1'
            // start option
            do {
                // Start 'attrvalue' min '1' max '1'
                $regexp = "/(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|(\"[^\"]*\")|\\d+|\\w+))/";
                $pos = $this->parser->pos;
                if (isset($this->parser->regexpCache['attrvalue6'][$pos])) {
                    $subres = $this->parser->regexpCache['attrvalue6'][$pos];
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
                                $this->parser->regexpCache['attrvalue6'][$subres['_startpos']] = $subres;
                                $this->parser->regexpCache['attrvalue6'][$pos] = false;
                                $subres = false;
                            }
                        } else {
                            $this->parser->regexpCache['attrvalue6'][$pos] = false;
                            $subres = false;
                        }
                    } else {
                        $this->parser->regexpCache['attrvalue6'][$pos] = false;
                        $subres = false;
                    }
                }
                if ($subres) {
                    $subres['_lineno'] = $this->parser->line;
                    $this->parser->pos = $subres['_endpos'];
                    $this->parser->line += substr_count($subres['_text'], "\n");
                    $subres['_tag'] = false;
                    $subres['_name'] = 'attrvalue';
                    $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
                    $valid = true;
                } else {
                    $valid = false;
                }
                if ($valid) {
                    $result['_text'] .= $subres['_text'];
                }
                // End 'attrvalue'
                if ($valid) {
                    break;
                }
                // Start 'attrvalue' min '1' max '1'
                // start sequence
                $backup7 = $result;
                $pos7 = $this->parser->pos;
                $line7 = $this->parser->line;
                do {
                    // Start 'attrvalue' min '1' max '1'
                    if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= '(';
                        $this->parser->successLiteral('(');
                        $valid = true;
                    } else {
                        $this->parser->failLiteral('(');
                        $valid = false;
                    }
                    // End 'attrvalue'
                    if (!$valid) {
                        break;
                    }
                    // Start 'attrvalue' tag 'sub' min '1' max '1'
                    $this->parser->addBacktrace(array('attr', $result));
                    $subres = $this->parser->matchRule($result, 'attr');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('attr', $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->attrvalue_sub($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'attrvalue'
                    if (!$valid) {
                        break;
                    }
                    // Start 'attrvalue' min '1' max '1'
                    if (')' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= ')';
                        $this->parser->successLiteral(')');
                        $valid = true;
                    } else {
                        $this->parser->failLiteral(')');
                        $valid = false;
                    }
                    // End 'attrvalue'
                    if (!$valid) {
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos7;
                    $this->parser->line = $line7;
                    $result = $backup7;
                }
                unset($backup7);
                // end sequence
                // End 'attrvalue'
                if ($valid) {
                    break;
                }
                break;
            } while (true);
            // end option
            // End 'attrvalue'
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
        // End 'attrvalue'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->attrvalue___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function attrvalue_sub(&$result, $subres)
    {
        $result['value'] = $subres['_attr'];
    }

    public function attrvalue___FINISH(&$result)
    {
        $mr = $result['_matchres'];
        if (isset($mr['v1']) && !empty($mr['v1'])) {
            $result['value'] = trim($mr['v1'], "'\"");
        }
        if (isset($mr['true']) && !empty($mr['true'])) {
            $result['value'] = true;
        }
        if (isset($mr['false']) && !empty($mr['false'])) {
            $result['value'] = false;
        }
        if (isset($mr['null']) && !empty($mr['null'])) {
            $result['value'] = null;
        }
        $result['_matchres'] = array();
    }

    /**
     * Parser rules and action for node 'attrentry'
     *  Rule:
     * <node attrentry> <rule>  .._? key:Name .._? (  '=' .._? val:attrvalue )? </rule>  <action key> {
     * $result['key'] = $subres['_text'];
     * $result['value'] = array($result['key'] => true);
     * } </action>  <action val> {
     * $result['value'][$result['key']] = $subres['value'];
     * } </action> </node>

     */
    public function matchNodeattrentry($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'attrentry' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'attrentry' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'attrentry'
            if (!$valid) {
                break;
            }
            // Start 'attrentry' tag 'key' min '1' max '1'
            $this->parser->addBacktrace(array('Name', $result));
            $subres = $this->parser->matchRule($result, 'Name');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Name', $subres));
                $result['_text'] .= $subres['_text'];
                $this->attrentry_key($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'attrentry'
            if (!$valid) {
                break;
            }
            // Start 'attrentry' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'attrentry'
            if (!$valid) {
                break;
            }
            // Start 'attrentry' min '0' max '1'
            // start sequence
            $backup6 = $result;
            $pos6 = $this->parser->pos;
            $line6 = $this->parser->line;
            do {
                // Start 'attrentry' min '1' max '1'
                if ('=' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= '=';
                    $this->parser->successLiteral('=');
                    $valid = true;
                } else {
                    $this->parser->failLiteral('=');
                    $valid = false;
                }
                // End 'attrentry'
                if (!$valid) {
                    break;
                }
                // Start 'attrentry' min '1' max '1'
                if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                }
                $valid = true;
                // End 'attrentry'
                if (!$valid) {
                    break;
                }
                // Start 'attrentry' tag 'val' min '1' max '1'
                $this->parser->addBacktrace(array('attrvalue', $result));
                $subres = $this->parser->matchRule($result, 'attrvalue');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('attrvalue', $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->attrentry_val($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'attrentry'
                if (!$valid) {
                    break;
                }
                break;
            } while (true);
            if (!$valid) {
                $this->parser->pos = $pos6;
                $this->parser->line = $line6;
                $result = $backup6;
            }
            unset($backup6);
            // end sequence
            $valid = true;
            // End 'attrentry'
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
        // End 'attrentry'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function attrentry_key(&$result, $subres)
    {
        $result['key'] = $subres['_text'];
        $result['value'] = array($result['key'] => true);
    }

    public function attrentry_val(&$result, $subres)
    {
        $result['value'][$result['key']] = $subres['value'];
    }

    /**
     * Parser rules and action for node 'attr'
     *  Rule:
     * <node attr> <rule>  attrentry (  ',' attrentry )* </rule>  <action _all> {
     * if (!isset($result['_attr'])) {
     * $result['_attr'] = array();
     * }
     * $result['_attr'] = array_merge($result['_attr'], $subres['value']);
     * } </action> </node>

     */
    public function matchNodeattr($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'attr' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'attr' min '1' max '1'
            $this->parser->addBacktrace(array('attrentry', $result));
            $subres = $this->parser->matchRule($result, 'attrentry');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('attrentry', $subres));
                $result['_text'] .= $subres['_text'];
                $this->attr___ALL($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'attr'
            if (!$valid) {
                break;
            }
            // Start 'attr' min '0' max 'null'
            $iteration3 = 0;
            do {
                // start sequence
                $backup4 = $result;
                $pos4 = $this->parser->pos;
                $line4 = $this->parser->line;
                do {
                    // Start 'attr' min '1' max '1'
                    if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= ',';
                        $this->parser->successLiteral(',');
                        $valid = true;
                    } else {
                        $this->parser->failLiteral(',');
                        $valid = false;
                    }
                    // End 'attr'
                    if (!$valid) {
                        break;
                    }
                    // Start 'attr' min '1' max '1'
                    $this->parser->addBacktrace(array('attrentry', $result));
                    $subres = $this->parser->matchRule($result, 'attrentry');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('attrentry', $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->attr___ALL($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'attr'
                    if (!$valid) {
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos4;
                    $this->parser->line = $line4;
                    $result = $backup4;
                }
                unset($backup4);
                // end sequence
                $iteration3 = $valid ? ($iteration3 + 1) : $iteration3;
                if (!$valid && $iteration3 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) {
                    break;
                }
            } while (true);
            // End 'attr'
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
        // End 'attr'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function attr___ALL(&$result, $subres)
    {
        if (!isset($result['_attr'])) {
            $result['_attr'] = array();
        }
        $result['_attr'] = array_merge($result['_attr'], $subres['value']);
    }

    /**
     * Parser rules and action for node 'Name'
     *  Rule:
     * <node Name> <rule>  /\w+/ </rule> </node>

     */
    public function matchNodeName($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Name' min '1' max '1'
        $regexp = "/\\w+/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Name2'][$pos])) {
            $subres = $this->parser->regexpCache['Name2'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                if ($subres['_startpos'] != $pos) {
                    $this->parser->regexpCache['Name2'][$subres['_startpos']] = $subres;
                    $this->parser->regexpCache['Name2'][$pos] = false;
                    $subres = false;
                }
            } else {
                $this->parser->regexpCache['Name2'][$pos] = false;
                $subres = false;
            }
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Name';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End 'Name'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     * Parser rules and action for node 'Header'
     *  Rule:
     * <node Header> <rule>  /\s*\/\*!\* / </rule> </node>

     */
    public function matchNodeHeader($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Header' min '1' max '1'
        $regexp = "/\\s*\\/\\*!\\* /";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Header2'][$pos])) {
            $subres = $this->parser->regexpCache['Header2'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                if ($subres['_startpos'] != $pos) {
                    $this->parser->regexpCache['Header2'][$subres['_startpos']] = $subres;
                    $this->parser->regexpCache['Header2'][$pos] = false;
                    $subres = false;
                }
            } else {
                $this->parser->regexpCache['Header2'][$pos] = false;
                $subres = false;
            }
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Header';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End 'Header'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     * Parser rules and action for node 'End'
     *  Rule:
     * <node End> <rule>  ./\s*\*\// </rule> </node>

     */
    public function matchNodeEnd($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'End' min '1' max '1'
        $regexp = "/\\s*\\*\\//";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['End2'][$pos])) {
            $subres = $this->parser->regexpCache['End2'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                if ($subres['_startpos'] != $pos) {
                    $this->parser->regexpCache['End2'][$subres['_startpos']] = $subres;
                    $this->parser->regexpCache['End2'][$pos] = false;
                    $subres = false;
                }
            } else {
                $this->parser->regexpCache['End2'][$pos] = false;
                $subres = false;
            }
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'End';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
        }
        // End 'End'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     * Parser rules and action for node 'Comment'
     *  Rule:
     * <node Comment> <rule>  /[\s\t]*(([#][^\r\n]*)?([\r\n]+[\s\t]*))* / </rule> </node>

     */
    public function matchNodeComment($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Comment' min '1' max '1'
        $regexp = "/[\\s\\t]*(([#][^\\r\\n]*)?([\\r\\n]+[\\s\\t]*))* /";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Comment2'][$pos])) {
            $subres = $this->parser->regexpCache['Comment2'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                if ($subres['_startpos'] != $pos) {
                    $this->parser->regexpCache['Comment2'][$subres['_startpos']] = $subres;
                    $this->parser->regexpCache['Comment2'][$pos] = false;
                    $subres = false;
                }
            } else {
                $this->parser->regexpCache['Comment2'][$pos] = false;
                $subres = false;
            }
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Comment';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        // End 'Comment'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     * Parser rules and action for node 'Text'
     *  Rule:
     * <node Text> <rule>  /([\S\s]+(?=([^\S\r\n]\/\*!\*)))|[\S\s]+/ </rule>  <action _start> {
     * $result['_node'] = new \Smarty\Tool\Parser\Peg\Nodes\Text ($this, null);
     * } </action>  <action _all> {
     * $result['_node']->_text = $subres['_text'];
     * } </action> </node>

     */
    public function matchNodeText($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->Text___START($result, $previous);
        // Start 'Text' min '1' max '1'
        $regexp = "/([\\S\\s]+(?=([^\\S\\r\\n]\\/\\*!\\*)))|[\\S\\s]+/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Text2'][$pos])) {
            $subres = $this->parser->regexpCache['Text2'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                if ($subres['_startpos'] != $pos) {
                    $this->parser->regexpCache['Text2'][$subres['_startpos']] = $subres;
                    $this->parser->regexpCache['Text2'][$pos] = false;
                    $subres = false;
                }
            } else {
                $this->parser->regexpCache['Text2'][$pos] = false;
                $subres = false;
            }
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Text';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
            $this->Text___ALL($result, $subres);
        }
        // End 'Text'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Text___START(&$result, $previous)
    {
        $result['_node'] = new Text ($this, null);
    }

    public function Text___ALL(&$result, $subres)
    {
        $result['_node']->_text = $subres['_text'];
    }

    /**
     * Parser rules and action for node 'Parser'
     *  Rule:
     * <node Parser> <rule>  ..Header .._? '<pegparser' _ Name '>' attr:Attribute* node:Node* .._? '</pegparser>' .._? End? </rule>  <action _start> {
     * $result['_node'] = new \Smarty\Tool\Parser\Peg\Nodes\ParserCompiler ($this, null);
     * } </action>  <action attr> {
     * if (!isset($result['_attr'])) {
     * $result['_attr'] = array();
     * }
     * $result['_attr'] = array_merge($result['_attr'], $subres['_attr']);
     * } </action>  <action node> {
     * $subres['_nodedef']['rule']['_name'] = $subres['_nodedef']['name'];
     * ksort($subres['_nodedef']['rule']);
     * $result['_node']->nodes[$subres['_nodedef']['name']] = $subres['_nodedef']['rule'];
     * $result['_node']->comments[$subres['_nodedef']['name']] = $subres['comment'];
     * if (isset($subres['_attr'])) {
     * $result['_node']->attributes[$subres['_nodedef']['name']] = $subres['_attr'];
     * }
     * if (isset($subres['_nodedef']['actions'])) {
     * $result['_node']->actions[$subres['_nodedef']['name']] = $subres['_nodedef']['actions'];
     * }
     * } </action> </node>

     */
    public function matchNodeParser($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->Parser___START($result, $previous);
        // Start 'Parser' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Parser' min '1' max '1'
            $this->parser->addBacktrace(array('Header', $result));
            $subres = $this->parser->matchRule($result, 'Header');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Header', $subres));
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Parser'
            if (!$valid) {
                break;
            }
            // Start 'Parser' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Parser'
            if (!$valid) {
                break;
            }
            // Start 'Parser' min '1' max '1'
            if ('<pegparser' == substr($this->parser->source, $this->parser->pos, 10)) {
                $this->parser->pos += 10;
                $result['_text'] .= '<pegparser';
                $this->parser->successLiteral('<pegparser');
                $valid = true;
            } else {
                $this->parser->failLiteral('<pegparser');
                $valid = false;
            }
            // End 'Parser'
            if (!$valid) {
                break;
            }
            // Start 'Parser' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
                $result['_text'] .= ' ';
                $valid = true;
            } else {
                $valid = false;
            }
            // End 'Parser'
            if (!$valid) {
                break;
            }
            // Start 'Parser' min '1' max '1'
            $this->parser->addBacktrace(array('Name', $result));
            $subres = $this->parser->matchRule($result, 'Name');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Name', $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Parser'
            if (!$valid) {
                break;
            }
            // Start 'Parser' min '1' max '1'
            if ('>' == substr($this->parser->source, $this->parser->pos, 1)) {
                $this->parser->pos += 1;
                $result['_text'] .= '>';
                $this->parser->successLiteral('>');
                $valid = true;
            } else {
                $this->parser->failLiteral('>');
                $valid = false;
            }
            // End 'Parser'
            if (!$valid) {
                break;
            }
            // Start 'Parser' tag 'attr' min '0' max 'null'
            $iteration8 = 0;
            do {
                $this->parser->addBacktrace(array('Attribute', $result));
                $subres = $this->parser->matchRule($result, 'Attribute');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Attribute', $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Parser_attr($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                $iteration8 = $valid ? ($iteration8 + 1) : $iteration8;
                if (!$valid && $iteration8 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) {
                    break;
                }
            } while (true);
            // End 'Parser'
            if (!$valid) {
                break;
            }
            // Start 'Parser' tag 'node' min '0' max 'null'
            $iteration9 = 0;
            do {
                $this->parser->addBacktrace(array('Node', $result));
                $subres = $this->parser->matchRule($result, 'Node');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Node', $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Parser_node($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                $iteration9 = $valid ? ($iteration9 + 1) : $iteration9;
                if (!$valid && $iteration9 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) {
                    break;
                }
            } while (true);
            // End 'Parser'
            if (!$valid) {
                break;
            }
            // Start 'Parser' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Parser'
            if (!$valid) {
                break;
            }
            // Start 'Parser' min '1' max '1'
            if ('</pegparser>' == substr($this->parser->source, $this->parser->pos, 12)) {
                $this->parser->pos += 12;
                $result['_text'] .= '</pegparser>';
                $this->parser->successLiteral('</pegparser>');
                $valid = true;
            } else {
                $this->parser->failLiteral('</pegparser>');
                $valid = false;
            }
            // End 'Parser'
            if (!$valid) {
                break;
            }
            // Start 'Parser' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Parser'
            if (!$valid) {
                break;
            }
            // Start 'Parser' min '0' max '1'
            $this->parser->addBacktrace(array('End', $result));
            $subres = $this->parser->matchRule($result, 'End');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('End', $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            $valid = true;
            // End 'Parser'
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
        // End 'Parser'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Parser___START(&$result, $previous)
    {
        $result['_node'] = new ParserCompiler ($this, null);
    }

    public function Parser_attr(&$result, $subres)
    {
        if (!isset($result['_attr'])) {
            $result['_attr'] = array();
        }
        $result['_attr'] = array_merge($result['_attr'], $subres['_attr']);
    }

    public function Parser_node(&$result, $subres)
    {
        $subres['_nodedef']['rule']['_name'] = $subres['_nodedef']['name'];
        ksort($subres['_nodedef']['rule']);
        $result['_node']->nodes[$subres['_nodedef']['name']] = $subres['_nodedef']['rule'];
        $result['_node']->comments[$subres['_nodedef']['name']] = $subres['comment'];
        if (isset($subres['_attr'])) {
            $result['_node']->attributes[$subres['_nodedef']['name']] = $subres['_attr'];
        }
        if (isset($subres['_nodedef']['actions'])) {
            $result['_node']->actions[$subres['_nodedef']['name']] = $subres['_nodedef']['actions'];
        }
    }

    /**
     * Parser rules and action for node 'Attribute'
     *  Rule:
     * <node Attribute> <rule>  .._? '<attribute>' attr:attr '</attribute>' .._? </rule>  <action attr> {
     * $result['_attr'] = $subres['_attr'];
     * } </action> </node>

     */
    public function matchNodeAttribute($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Attribute' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Attribute' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Attribute'
            if (!$valid) {
                break;
            }
            // Start 'Attribute' min '1' max '1'
            if ('<attribute>' == substr($this->parser->source, $this->parser->pos, 11)) {
                $this->parser->pos += 11;
                $result['_text'] .= '<attribute>';
                $this->parser->successLiteral('<attribute>');
                $valid = true;
            } else {
                $this->parser->failLiteral('<attribute>');
                $valid = false;
            }
            // End 'Attribute'
            if (!$valid) {
                break;
            }
            // Start 'Attribute' tag 'attr' min '1' max '1'
            $this->parser->addBacktrace(array('attr', $result));
            $subres = $this->parser->matchRule($result, 'attr');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('attr', $subres));
                $result['_text'] .= $subres['_text'];
                $this->Attribute_attr($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Attribute'
            if (!$valid) {
                break;
            }
            // Start 'Attribute' min '1' max '1'
            if ('</attribute>' == substr($this->parser->source, $this->parser->pos, 12)) {
                $this->parser->pos += 12;
                $result['_text'] .= '</attribute>';
                $this->parser->successLiteral('</attribute>');
                $valid = true;
            } else {
                $this->parser->failLiteral('</attribute>');
                $valid = false;
            }
            // End 'Attribute'
            if (!$valid) {
                break;
            }
            // Start 'Attribute' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Attribute'
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
        // End 'Attribute'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Attribute_attr(&$result, $subres)
    {
        $result['_attr'] = $subres['_attr'];
    }

    /**
     * Parser rules and action for node 'Node'
     *  Rule:
     * <node Node> <rule>  .._? /\s*\<(?<type>(node|token))\s+(?<nodename>[a-zA-Z_0-9]+)\>/ attr:Attribute* rule:Rule .act:Action* /<\/(node|token)>/ .._? </rule>  <action type> {
     * $result['_nodedef']['rule']['_attr'] = array('_nodetype' => $subres['_matchres']['type']);
     * } </action>  <action nodename> {
     * $result['nodename'] = $subres['_matchres']['nodename'];
     * $result['_nodedef']['name'] = $result['nodename'];
     * unset($subres['_matchres']);
     * } </action>  <action attr> {
     * $result['_nodedef']['rule']['_attr'] = array_merge($result['_nodedef']['rule']['_attr'], $subres['_attr']);
     * } </action>  <action rule> {
     * $subres['_rule']['_name'] = $result['nodename'];
     * $result['_nodedef']['rule'] = array_merge($result['_nodedef']['rule'], $subres['_rule']);
     * } </action>  <action act> {
     * if (!isset($result['_nodedef']['actions'])) {
     * $result['_nodedef']['actions'] = array();
     * }
     * $index = count($result['_nodedef']['actions']);
     * $result['_nodedef']['actions'][$index]['funcname'] = $subres['_matchres']['funcname'];
     * $result['_nodedef']['actions'][$index]['code'] = $subres['code'];
     * if (isset($subres['_matchres']['argument'])) {
     * $result['_nodedef']['actions'][$index]['argument'] = $subres['_matchres']['argument'];
     * }
     * unset($subres['_matchres']);
     * } </action>  <action _start> {
     * $regexp = substr($this->parser->whitespacePattern, 0, strlen($this->parser->whitespacePattern) -1);
     * $regexp .= '\s*\<(node|token)\s+[a-zA-Z_]+\>[\s\S]*?\<\/(node|token)\>[\s\S]*?[\n]/';
     * if (preg_match($regexp, $this->source, $match, 0, $this->pos )) {
     * $result['comment'] = $match[0];
     * }
     * } </action>  <action _finish> {
     * ksort($result['_nodedef']['rule']);
     * } </action> </node>

     */
    public function matchNodeNode($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->Node___START($result, $previous);
        // Start 'Node' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Node' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Node'
            if (!$valid) {
                break;
            }
            // Start 'Node' min '1' max '1'
            $regexp = "/\\s*\\<(?<type>(node|token))\\s+(?<nodename>[a-zA-Z_0-9]+)\\>/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['Node5'][$pos])) {
                $subres = $this->parser->regexpCache['Node5'][$pos];
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
                            $this->parser->regexpCache['Node5'][$subres['_startpos']] = $subres;
                            $this->parser->regexpCache['Node5'][$pos] = false;
                            $subres = false;
                        }
                    } else {
                        $this->parser->regexpCache['Node5'][$pos] = false;
                        $subres = false;
                    }
                } else {
                    $this->parser->regexpCache['Node5'][$pos] = false;
                    $subres = false;
                }
            }
            if ($subres) {
                $subres['_lineno'] = $this->parser->line;
                $this->parser->pos = $subres['_endpos'];
                $this->parser->line += substr_count($subres['_text'], "\n");
                $subres['_tag'] = false;
                $subres['_name'] = 'Node';
                if (isset($subres['_matchres']['type'])) {
                    $this->Node_type($result, $subres);
                    unset($subres['_matchres']['type']);
                }
                if (isset($subres['_matchres']['nodename'])) {
                    $this->Node_nodename($result, $subres);
                    unset($subres['_matchres']['nodename']);
                }
                $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
                $valid = true;
            } else {
                $valid = false;
            }
            if ($valid) {
                $result['_text'] .= $subres['_text'];
            }
            // End 'Node'
            if (!$valid) {
                break;
            }
            // Start 'Node' tag 'attr' min '0' max 'null'
            $iteration5 = 0;
            do {
                $this->parser->addBacktrace(array('Attribute', $result));
                $subres = $this->parser->matchRule($result, 'Attribute');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Attribute', $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Node_attr($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                $iteration5 = $valid ? ($iteration5 + 1) : $iteration5;
                if (!$valid && $iteration5 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) {
                    break;
                }
            } while (true);
            // End 'Node'
            if (!$valid) {
                break;
            }
            // Start 'Node' tag 'rule' min '1' max '1'
            $this->parser->addBacktrace(array('Rule', $result));
            $subres = $this->parser->matchRule($result, 'Rule');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Rule', $subres));
                $result['_text'] .= $subres['_text'];
                $this->Node_rule($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Node'
            if (!$valid) {
                break;
            }
            // Start 'Node' tag 'act' min '0' max 'null'
            $iteration7 = 0;
            do {
                $this->parser->addBacktrace(array('Action', $result));
                $subres = $this->parser->matchRule($result, 'Action');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Action', $subres));
                    $this->Node_act($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                $iteration7 = $valid ? ($iteration7 + 1) : $iteration7;
                if (!$valid && $iteration7 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) {
                    break;
                }
            } while (true);
            // End 'Node'
            if (!$valid) {
                break;
            }
            // Start 'Node' min '1' max '1'
            $regexp = "/<\\/(node|token)>/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['Node10'][$pos])) {
                $subres = $this->parser->regexpCache['Node10'][$pos];
            } else {
                if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                    if ($subres['_startpos'] != $pos) {
                        $this->parser->regexpCache['Node10'][$subres['_startpos']] = $subres;
                        $this->parser->regexpCache['Node10'][$pos] = false;
                        $subres = false;
                    }
                } else {
                    $this->parser->regexpCache['Node10'][$pos] = false;
                    $subres = false;
                }
            }
            if ($subres) {
                $subres['_lineno'] = $this->parser->line;
                $this->parser->pos = $subres['_endpos'];
                $this->parser->line += substr_count($subres['_text'], "\n");
                $subres['_tag'] = false;
                $subres['_name'] = 'Node';
                $valid = true;
            } else {
                $valid = false;
            }
            if ($valid) {
                $result['_text'] .= $subres['_text'];
            }
            // End 'Node'
            if (!$valid) {
                break;
            }
            // Start 'Node' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Node'
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
        // End 'Node'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Node___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Node_type(&$result, $subres)
    {
        $result['_nodedef']['rule']['_attr'] = array('_nodetype' => $subres['_matchres']['type']);
    }

    public function Node_nodename(&$result, $subres)
    {
        $result['nodename'] = $subres['_matchres']['nodename'];
        $result['_nodedef']['name'] = $result['nodename'];
        unset($subres['_matchres']);
    }

    public function Node_attr(&$result, $subres)
    {
        $result['_nodedef']['rule']['_attr'] = array_merge($result['_nodedef']['rule']['_attr'], $subres['_attr']);
    }

    public function Node_rule(&$result, $subres)
    {
        $subres['_rule']['_name'] = $result['nodename'];
        $result['_nodedef']['rule'] = array_merge($result['_nodedef']['rule'], $subres['_rule']);
    }

    public function Node_act(&$result, $subres)
    {
        if (!isset($result['_nodedef']['actions'])) {
            $result['_nodedef']['actions'] = array();
        }
        $index = count($result['_nodedef']['actions']);
        $result['_nodedef']['actions'][$index]['funcname'] = $subres['_matchres']['funcname'];
        $result['_nodedef']['actions'][$index]['code'] = $subres['code'];
        if (isset($subres['_matchres']['argument'])) {
            $result['_nodedef']['actions'][$index]['argument'] = $subres['_matchres']['argument'];
        }
        unset($subres['_matchres']);
    }

    public function Node___START(&$result, $previous)
    {
        $regexp = substr($this->parser->whitespacePattern, 0, strlen($this->parser->whitespacePattern) - 1);
        $regexp .= '\s*\<(node|token)\s+[a-zA-Z_]+\>[\s\S]*?\<\/(node|token)\>[\s\S]*?[\n]/';
        if (preg_match($regexp, $this->source, $match, 0, $this->pos)) {
            $result['comment'] = $match[0];
        }
    }

    public function Node___FINISH(&$result)
    {
        ksort($result['_nodedef']['rule']);
    }

    /**
     * Parser rules and action for node 'Rule'
     *  Rule:
     * <node Rule> <rule>  .._? '<rule>' .._? seq:Sequence .._? '</rule>' .._? </rule>  <action seq> {
     * $result['_rule'] = $subres['_rule'];
     * } </action> </node>

     */
    public function matchNodeRule($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Rule' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Rule' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Rule'
            if (!$valid) {
                break;
            }
            // Start 'Rule' min '1' max '1'
            if ('<rule>' == substr($this->parser->source, $this->parser->pos, 6)) {
                $this->parser->pos += 6;
                $result['_text'] .= '<rule>';
                $this->parser->successLiteral('<rule>');
                $valid = true;
            } else {
                $this->parser->failLiteral('<rule>');
                $valid = false;
            }
            // End 'Rule'
            if (!$valid) {
                break;
            }
            // Start 'Rule' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Rule'
            if (!$valid) {
                break;
            }
            // Start 'Rule' tag 'seq' min '1' max '1'
            $this->parser->addBacktrace(array('Sequence', $result));
            $subres = $this->parser->matchRule($result, 'Sequence');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Sequence', $subres));
                $result['_text'] .= $subres['_text'];
                $this->Rule_seq($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Rule'
            if (!$valid) {
                break;
            }
            // Start 'Rule' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Rule'
            if (!$valid) {
                break;
            }
            // Start 'Rule' min '1' max '1'
            if ('</rule>' == substr($this->parser->source, $this->parser->pos, 7)) {
                $this->parser->pos += 7;
                $result['_text'] .= '</rule>';
                $this->parser->successLiteral('</rule>');
                $valid = true;
            } else {
                $this->parser->failLiteral('</rule>');
                $valid = false;
            }
            // End 'Rule'
            if (!$valid) {
                break;
            }
            // Start 'Rule' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Rule'
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
        // End 'Rule'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Rule_seq(&$result, $subres)
    {
        $result['_rule'] = $subres['_rule'];
    }

    /**
     * Parser rules and action for node 'Action'
     *  Rule:
     * <node Action> <rule>  .._? /\<action\s+(?<funcname>\w+)(\((?<argument>\w+)\))?\>/ .._? code:/(\{(?:(?>[^{}]+|(?R))*)?\})/ .._? '</action>' .._? </rule>  <action code> {
     * $result['code'] = $subres['_text'];
     * } </action> </node>

     */
    public function matchNodeAction($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Action' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Action' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Action'
            if (!$valid) {
                break;
            }
            // Start 'Action' min '1' max '1'
            $regexp = "/\\<action\\s+(?<funcname>\\w+)(\\((?<argument>\\w+)\\))?\\>/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['Action5'][$pos])) {
                $subres = $this->parser->regexpCache['Action5'][$pos];
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
                            $this->parser->regexpCache['Action5'][$subres['_startpos']] = $subres;
                            $this->parser->regexpCache['Action5'][$pos] = false;
                            $subres = false;
                        }
                    } else {
                        $this->parser->regexpCache['Action5'][$pos] = false;
                        $subres = false;
                    }
                } else {
                    $this->parser->regexpCache['Action5'][$pos] = false;
                    $subres = false;
                }
            }
            if ($subres) {
                $subres['_lineno'] = $this->parser->line;
                $this->parser->pos = $subres['_endpos'];
                $this->parser->line += substr_count($subres['_text'], "\n");
                $subres['_tag'] = false;
                $subres['_name'] = 'Action';
                $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
                $valid = true;
            } else {
                $valid = false;
            }
            if ($valid) {
                $result['_text'] .= $subres['_text'];
            }
            // End 'Action'
            if (!$valid) {
                break;
            }
            // Start 'Action' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Action'
            if (!$valid) {
                break;
            }
            // Start 'Action' tag 'code' min '1' max '1'
            $regexp = "/(\\{(?:(?>[^{}]+|(?R))*)?\\})/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['Action8'][$pos])) {
                $subres = $this->parser->regexpCache['Action8'][$pos];
            } else {
                if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                    if ($subres['_startpos'] != $pos) {
                        $this->parser->regexpCache['Action8'][$subres['_startpos']] = $subres;
                        $this->parser->regexpCache['Action8'][$pos] = false;
                        $subres = false;
                    }
                } else {
                    $this->parser->regexpCache['Action8'][$pos] = false;
                    $subres = false;
                }
            }
            if ($subres) {
                $subres['_lineno'] = $this->parser->line;
                $this->parser->pos = $subres['_endpos'];
                $this->parser->line += substr_count($subres['_text'], "\n");
                $subres['_tag'] = 'code';
                $subres['_name'] = 'Action';
                $valid = true;
            } else {
                $valid = false;
            }
            if ($valid) {
                $result['_text'] .= $subres['_text'];
                $this->Action_code($result, $subres);
            }
            // End 'Action'
            if (!$valid) {
                break;
            }
            // Start 'Action' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Action'
            if (!$valid) {
                break;
            }
            // Start 'Action' min '1' max '1'
            if ('</action>' == substr($this->parser->source, $this->parser->pos, 9)) {
                $this->parser->pos += 9;
                $result['_text'] .= '</action>';
                $this->parser->successLiteral('</action>');
                $valid = true;
            } else {
                $this->parser->failLiteral('</action>');
                $valid = false;
            }
            // End 'Action'
            if (!$valid) {
                break;
            }
            // Start 'Action' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
            }
            $valid = true;
            // End 'Action'
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
        // End 'Action'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Action_code(&$result, $subres)
    {
        $result['code'] = $subres['_text'];
    }

    /**
     * Parser rules and action for node 'PHP'
     *  Rule:
     * <node PHP> <rule>  /.[\n\t ]* / .b:/(\{|\}|[^\n\}\{]+)* / </rule>  <action b> {
     * $result['_text'] = trim($subres['_text']);
     * } </action> </node>

     */
    public function matchNodePHP($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'PHP' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'PHP' min '1' max '1'
            $regexp = "/.[\\n\\t ]* /";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['PHP4'][$pos])) {
                $subres = $this->parser->regexpCache['PHP4'][$pos];
            } else {
                if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                    if ($subres['_startpos'] != $pos) {
                        $this->parser->regexpCache['PHP4'][$subres['_startpos']] = $subres;
                        $this->parser->regexpCache['PHP4'][$pos] = false;
                        $subres = false;
                    }
                } else {
                    $this->parser->regexpCache['PHP4'][$pos] = false;
                    $subres = false;
                }
            }
            if ($subres) {
                $subres['_lineno'] = $this->parser->line;
                $this->parser->pos = $subres['_endpos'];
                $this->parser->line += substr_count($subres['_text'], "\n");
                $subres['_tag'] = false;
                $subres['_name'] = 'PHP';
                $valid = true;
            } else {
                $valid = false;
            }
            if ($valid) {
                $result['_text'] .= $subres['_text'];
            }
            // End 'PHP'
            if (!$valid) {
                break;
            }
            // Start 'PHP' tag 'b' min '1' max '1'
            $regexp = "/(\\{|\\}|[^\\n\\}\\{]+)* /";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['PHP6'][$pos])) {
                $subres = $this->parser->regexpCache['PHP6'][$pos];
            } else {
                if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                    $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                    if ($subres['_startpos'] != $pos) {
                        $this->parser->regexpCache['PHP6'][$subres['_startpos']] = $subres;
                        $this->parser->regexpCache['PHP6'][$pos] = false;
                        $subres = false;
                    }
                } else {
                    $this->parser->regexpCache['PHP6'][$pos] = false;
                    $subres = false;
                }
            }
            if ($subres) {
                $subres['_lineno'] = $this->parser->line;
                $this->parser->pos = $subres['_endpos'];
                $this->parser->line += substr_count($subres['_text'], "\n");
                $subres['_tag'] = 'b';
                $subres['_name'] = 'PHP';
                $valid = true;
            } else {
                $valid = false;
            }
            if ($valid) {
                $this->PHP_b($result, $subres);
            }
            // End 'PHP'
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
        // End 'PHP'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function PHP_b(&$result, $subres)
    {
        $result['_text'] = trim($subres['_text']);
    }

    /**
     * Parser rules and action for node 'Arguments'
     *  Rule:
     * <node Arguments> <rule>  '(' attr:Name (  '=' value:Name | value:Arguments )? (  ',' attr:Name (  '=' value:Name | value:Arguments )? )* ')' </rule> </node>

     */
    public function matchNodeArguments($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Arguments' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Arguments' min '1' max '1'
            if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                $this->parser->pos += 1;
                $result['_text'] .= '(';
                $this->parser->successLiteral('(');
                $valid = true;
            } else {
                $this->parser->failLiteral('(');
                $valid = false;
            }
            // End 'Arguments'
            if (!$valid) {
                break;
            }
            // Start 'Arguments' tag 'attr' min '1' max '1'
            $this->parser->addBacktrace(array('Name', $result));
            $subres = $this->parser->matchRule($result, 'Name');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Name', $subres));
                $result['_text'] .= $subres['_text'];
                if (!isset($result['attr'])) {
                    $result['attr'] = $subres;
                } else {
                    if (!is_array($result['attr'])) {
                        $result['attr'] = array($result['attr']);
                    }
                    $result['attr'][] = $subres;
                }
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Arguments'
            if (!$valid) {
                break;
            }
            // Start 'Arguments' min '0' max '1'
            // start sequence
            $backup5 = $result;
            $pos5 = $this->parser->pos;
            $line5 = $this->parser->line;
            do {
                // Start 'Arguments' min '1' max '1'
                if ('=' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= '=';
                    $this->parser->successLiteral('=');
                    $valid = true;
                } else {
                    $this->parser->failLiteral('=');
                    $valid = false;
                }
                // End 'Arguments'
                if (!$valid) {
                    break;
                }
                // Start 'Arguments' min '1' max '1'
                // start option
                do {
                    // Start 'Arguments' tag 'value' min '1' max '1'
                    $this->parser->addBacktrace(array('Name', $result));
                    $subres = $this->parser->matchRule($result, 'Name');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Name', $subres));
                        $result['_text'] .= $subres['_text'];
                        if (!isset($result['value'])) {
                            $result['value'] = $subres;
                        } else {
                            if (!is_array($result['value'])) {
                                $result['value'] = array($result['value']);
                            }
                            $result['value'][] = $subres;
                        }
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'Arguments'
                    if ($valid) {
                        break;
                    }
                    // Start 'Arguments' tag 'value' min '1' max '1'
                    $this->parser->addBacktrace(array('Arguments', $result));
                    $subres = $this->parser->matchRule($result, 'Arguments');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Arguments', $subres));
                        $result['_text'] .= $subres['_text'];
                        if (!isset($result['value'])) {
                            $result['value'] = $subres;
                        } else {
                            if (!is_array($result['value'])) {
                                $result['value'] = array($result['value']);
                            }
                            $result['value'][] = $subres;
                        }
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'Arguments'
                    if ($valid) {
                        break;
                    }
                    break;
                } while (true);
                // end option
                // End 'Arguments'
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
            $valid = true;
            // End 'Arguments'
            if (!$valid) {
                break;
            }
            // Start 'Arguments' min '0' max 'null'
            $iteration10 = 0;
            do {
                // start sequence
                $backup11 = $result;
                $pos11 = $this->parser->pos;
                $line11 = $this->parser->line;
                do {
                    // Start 'Arguments' min '1' max '1'
                    if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= ',';
                        $this->parser->successLiteral(',');
                        $valid = true;
                    } else {
                        $this->parser->failLiteral(',');
                        $valid = false;
                    }
                    // End 'Arguments'
                    if (!$valid) {
                        break;
                    }
                    // Start 'Arguments' tag 'attr' min '1' max '1'
                    $this->parser->addBacktrace(array('Name', $result));
                    $subres = $this->parser->matchRule($result, 'Name');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Name', $subres));
                        $result['_text'] .= $subres['_text'];
                        if (!isset($result['attr'])) {
                            $result['attr'] = $subres;
                        } else {
                            if (!is_array($result['attr'])) {
                                $result['attr'] = array($result['attr']);
                            }
                            $result['attr'][] = $subres;
                        }
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'Arguments'
                    if (!$valid) {
                        break;
                    }
                    // Start 'Arguments' min '0' max '1'
                    // start sequence
                    $backup15 = $result;
                    $pos15 = $this->parser->pos;
                    $line15 = $this->parser->line;
                    do {
                        // Start 'Arguments' min '1' max '1'
                        if ('=' == substr($this->parser->source, $this->parser->pos, 1)) {
                            $this->parser->pos += 1;
                            $result['_text'] .= '=';
                            $this->parser->successLiteral('=');
                            $valid = true;
                        } else {
                            $this->parser->failLiteral('=');
                            $valid = false;
                        }
                        // End 'Arguments'
                        if (!$valid) {
                            break;
                        }
                        // Start 'Arguments' min '1' max '1'
                        // start option
                        do {
                            // Start 'Arguments' tag 'value' min '1' max '1'
                            $this->parser->addBacktrace(array('Name', $result));
                            $subres = $this->parser->matchRule($result, 'Name');
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('Name', $subres));
                                $result['_text'] .= $subres['_text'];
                                if (!isset($result['value'])) {
                                    $result['value'] = $subres;
                                } else {
                                    if (!is_array($result['value'])) {
                                        $result['value'] = array($result['value']);
                                    }
                                    $result['value'][] = $subres;
                                }
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            // End 'Arguments'
                            if ($valid) {
                                break;
                            }
                            // Start 'Arguments' tag 'value' min '1' max '1'
                            $this->parser->addBacktrace(array('Arguments', $result));
                            $subres = $this->parser->matchRule($result, 'Arguments');
                            $remove = array_pop($this->parser->backtrace);
                            if ($subres) {
                                $this->parser->successNode(array('Arguments', $subres));
                                $result['_text'] .= $subres['_text'];
                                if (!isset($result['value'])) {
                                    $result['value'] = $subres;
                                } else {
                                    if (!is_array($result['value'])) {
                                        $result['value'] = array($result['value']);
                                    }
                                    $result['value'][] = $subres;
                                }
                                $valid = true;
                            } else {
                                $valid = false;
                                $this->parser->failNode($remove);
                            }
                            // End 'Arguments'
                            if ($valid) {
                                break;
                            }
                            break;
                        } while (true);
                        // end option
                        // End 'Arguments'
                        if (!$valid) {
                            break;
                        }
                        break;
                    } while (true);
                    if (!$valid) {
                        $this->parser->pos = $pos15;
                        $this->parser->line = $line15;
                        $result = $backup15;
                    }
                    unset($backup15);
                    // end sequence
                    $valid = true;
                    // End 'Arguments'
                    if (!$valid) {
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos11;
                    $this->parser->line = $line11;
                    $result = $backup11;
                }
                unset($backup11);
                // end sequence
                $iteration10 = $valid ? ($iteration10 + 1) : $iteration10;
                if (!$valid && $iteration10 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) {
                    break;
                }
            } while (true);
            // End 'Arguments'
            if (!$valid) {
                break;
            }
            // Start 'Arguments' min '1' max '1'
            if (')' == substr($this->parser->source, $this->parser->pos, 1)) {
                $this->parser->pos += 1;
                $result['_text'] .= ')';
                $this->parser->successLiteral(')');
                $valid = true;
            } else {
                $this->parser->failLiteral(')');
                $valid = false;
            }
            // End 'Arguments'
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
        // End 'Arguments'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    /**
     * Parser rules and action for node 'Option'
     *  Rule:
     * <node Option> <rule>  _? result:RuleToken (  _? '|' _? option:RuleToken )* </rule>  <action result> {
     * $result['_rule'] = $subres['_rule'];
     * } </action>  <action option> {
     * ksort($subres['_rule']);
     * if(isset($result['_rule']['_type']) && $result['_rule']['_type'] != 'option') {
     * ksort($result['_rule']);
     * $r = $result['_rule'];
     * $result['_rule'] = array('_type' => 'option', '_param' => array($r, $subres['_rule']));
     * } else {
     * $result['_rule']['_param'][] = $subres['_rule'];
     * }
     * } </action> </node>

     */
    public function matchNodeOption($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Option' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Option' min '1' max '1'
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                $this->parser->pos += strlen($match[0]);
                $this->parser->line += substr_count($match[0], "\n");
                $result['_text'] .= ' ';
            }
            $valid = true;
            // End 'Option'
            if (!$valid) {
                break;
            }
            // Start 'Option' tag 'result' min '1' max '1'
            $this->parser->addBacktrace(array('RuleToken', $result));
            $subres = $this->parser->matchRule($result, 'RuleToken');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('RuleToken', $subres));
                $result['_text'] .= $subres['_text'];
                $this->Option_result($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Option'
            if (!$valid) {
                break;
            }
            // Start 'Option' min '0' max 'null'
            $iteration4 = 0;
            do {
                // start sequence
                $backup5 = $result;
                $pos5 = $this->parser->pos;
                $line5 = $this->parser->line;
                do {
                    // Start 'Option' min '1' max '1'
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                        $this->parser->pos += strlen($match[0]);
                        $this->parser->line += substr_count($match[0], "\n");
                        $result['_text'] .= ' ';
                    }
                    $valid = true;
                    // End 'Option'
                    if (!$valid) {
                        break;
                    }
                    // Start 'Option' min '1' max '1'
                    if ('|' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= '|';
                        $this->parser->successLiteral('|');
                        $valid = true;
                    } else {
                        $this->parser->failLiteral('|');
                        $valid = false;
                    }
                    // End 'Option'
                    if (!$valid) {
                        break;
                    }
                    // Start 'Option' min '1' max '1'
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                        $this->parser->pos += strlen($match[0]);
                        $this->parser->line += substr_count($match[0], "\n");
                        $result['_text'] .= ' ';
                    }
                    $valid = true;
                    // End 'Option'
                    if (!$valid) {
                        break;
                    }
                    // Start 'Option' tag 'option' min '1' max '1'
                    $this->parser->addBacktrace(array('RuleToken', $result));
                    $subres = $this->parser->matchRule($result, 'RuleToken');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('RuleToken', $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->Option_option($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'Option'
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
                $iteration4 = $valid ? ($iteration4 + 1) : $iteration4;
                if (!$valid && $iteration4 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) {
                    break;
                }
            } while (true);
            // End 'Option'
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
        // End 'Option'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Option_result(&$result, $subres)
    {
        $result['_rule'] = $subres['_rule'];
    }

    public function Option_option(&$result, $subres)
    {
        ksort($subres['_rule']);
        if (isset($result['_rule']['_type']) && $result['_rule']['_type'] != 'option') {
            ksort($result['_rule']);
            $r = $result['_rule'];
            $result['_rule'] = array('_type' => 'option', '_param' => array($r, $subres['_rule']));
        } else {
            $result['_rule']['_param'][] = $subres['_rule'];
        }
    }

    /**
     * Parser rules and action for node 'Sequence'
     *  Rule:
     * <node Sequence> <rule>  result:Option sequence:Option* </rule>  <action result> {
     * $result['_rule'] = $subres['_rule'];
     * } </action>  <action sequence> {
     * ksort($subres['_rule']);
     * if(isset($result['_rule']['_type']) && $result['_rule']['_type'] != 'sequence') {
     * ksort($result['_rule']);
     * $r = $result['_rule'];
     * $result['_rule'] = array('_type' => 'sequence', '_param' => array($r, $subres['_rule']));
     * } else {
     * $result['_rule']['_param'][] = $subres['_rule'];
     * }
     * } </action> </node>

     */
    public function matchNodeSequence($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Sequence' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Sequence' tag 'result' min '1' max '1'
            $this->parser->addBacktrace(array('Option', $result));
            $subres = $this->parser->matchRule($result, 'Option');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Option', $subres));
                $result['_text'] .= $subres['_text'];
                $this->Sequence_result($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Sequence'
            if (!$valid) {
                break;
            }
            // Start 'Sequence' tag 'sequence' min '0' max 'null'
            $iteration3 = 0;
            do {
                $this->parser->addBacktrace(array('Option', $result));
                $subres = $this->parser->matchRule($result, 'Option');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Option', $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->Sequence_sequence($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                $iteration3 = $valid ? ($iteration3 + 1) : $iteration3;
                if (!$valid && $iteration3 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) {
                    break;
                }
            } while (true);
            // End 'Sequence'
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
        // End 'Sequence'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Sequence_result(&$result, $subres)
    {
        $result['_rule'] = $subres['_rule'];
    }

    public function Sequence_sequence(&$result, $subres)
    {
        ksort($subres['_rule']);
        if (isset($result['_rule']['_type']) && $result['_rule']['_type'] != 'sequence') {
            ksort($result['_rule']);
            $r = $result['_rule'];
            $result['_rule'] = array('_type' => 'sequence', '_param' => array($r, $subres['_rule']));
        } else {
            $result['_rule']['_param'][] = $subres['_rule'];
        }
    }

    /**
     * Parser rules and action for node 'RuleToken'
     *  Rule:
     * <node RuleToken> <rule>  /((?<silent>\.+)|(?<pla>&)|(?<nla>\!))?((?<tag>\w+):)?/? (  /(?<rx>\G(\/|~|@|%|§)(((\\\\)*\\\2)|.*?(?=(\\|\2)))*\2)|((?<osp>_\?)|(?<wsp>_))|(?<node>\w+)|(?<literal>("[^"]*")|('[^']*'))|(\$(?<expression>\w+))/ | (  '(' .._? seq:Sequence .._? ')' ) ) /((?<quest>\?)|(?<any>\*)|(?<must>\+?)|(\{(?<min>\d+)?,(?<max>\d+)?\}))?/? </rule>  <action _start> {
     * $result['_rule'] = array();
     * } </action>  <action seq> {
     * $result['_rule'] = array_merge ($result['_rule'], $subres['_rule']);
     * } </action>  <action _finish> {
     * $result['_rule']['_tagcomment'] = $result['_text'];
     * $mr = $result['_matchres'];
     * if (isset($mr['osp']) && !empty($mr['osp'])) {
     * $result['_rule']['_type'] = 'whitespace';
     * $result['_rule']['_param'] = true;
     * }
     * if (isset($mr['wsp']) && !empty($mr['wsp'])) {
     * $result['_rule']['_type'] = 'whitespace';
     * $result['_rule']['_param'] = false;
     * }
     * if (isset($mr['node']) && !empty($mr['node'])) {
     * $result['_rule']['_type'] = 'recurse';
     * $result['_rule']['_param'] = $mr['node'];
     * }
     * if (isset($mr['expression']) && !empty($mr['expression'])) {
     * $result['_rule']['_type'] = 'expression';
     * $result['_rule']['_param'] = $mr['expression'];
     * }
     * if (isset($mr['literal']) && !empty($mr['literal'])) {
     * $result['_rule']['_type'] = 'literal';
     * $result['_rule']['_param'] = trim($mr['literal'],"'\"");
     * }
     * if (isset($mr['rx']) && !empty($mr['rx'])) {
     * $result['_rule']['_type'] = 'rx';
     * $result['_rule']['_param'] = $mr['rx'];
     * }
     * if (isset($mr['silent']) && !empty($mr['silent'])) {
     * $result['_rule']['_silent'] = strlen($mr['silent']);
     * }
     * if (isset($mr['pla']) && !empty($mr['pla'])) {
     * $result['_rule']['_pla'] = true;
     * }
     * if (isset($mr['nla']) && !empty($mr['nla'])) {
     * $result['_rule']['_nla'] = true;
     * }
     * if (isset($mr['tag']) && !empty($mr['tag'])) {
     * $result['_rule']['_tag'] =$mr['tag'];
     * }
     * if (isset($mr['quest']) && !empty($mr['quest'])) {
     * $result['_rule']['_min'] = 0;
     * } elseif (isset($mr['any']) && !empty($mr['any'])) {
     * $result['_rule']['_min'] = 0;
     * $result['_rule']['_max'] = null;
     * } elseif (isset($mr['must']) && !empty($mr['must'])) {
     * $result['_rule']['_max'] = null;
     * } else {
     * if (isset($mr['min']) && !empty($mr['min'])) {
     * $result['_rule']['_min'] = $mr['min'];
     * $result['_rule']['_max'] = null;
     * }
     * if (isset($mr['max']) && !empty($mr['max'])) {
     * $result['_rule']['_max'] = $mr['max'];
     * }
     * }
     * $result['_matchres'] = array();
     * } </action> </node>

     */
    public function matchNodeRuleToken($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->RuleToken___START($result, $previous);
        // Start 'RuleToken' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'RuleToken' min '0' max '1'
            $regexp = "/((?<silent>\\.+)|(?<pla>&)|(?<nla>\\!))?((?<tag>\\w+):)?/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['RuleToken4'][$pos])) {
                $subres = $this->parser->regexpCache['RuleToken4'][$pos];
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
                            $this->parser->regexpCache['RuleToken4'][$subres['_startpos']] = $subres;
                            $this->parser->regexpCache['RuleToken4'][$pos] = false;
                            $subres = false;
                        }
                    } else {
                        $this->parser->regexpCache['RuleToken4'][$pos] = false;
                        $subres = false;
                    }
                } else {
                    $this->parser->regexpCache['RuleToken4'][$pos] = false;
                    $subres = false;
                }
            }
            if ($subres) {
                $subres['_lineno'] = $this->parser->line;
                $this->parser->pos = $subres['_endpos'];
                $this->parser->line += substr_count($subres['_text'], "\n");
                $subres['_tag'] = false;
                $subres['_name'] = 'RuleToken';
                $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
                $valid = true;
            } else {
                $valid = false;
            }
            if ($valid) {
                $result['_text'] .= $subres['_text'];
            }
            $valid = true;
            // End 'RuleToken'
            if (!$valid) {
                break;
            }
            // Start 'RuleToken' min '1' max '1'
            // start option
            do {
                // Start 'RuleToken' min '1' max '1'
                $regexp = "/(?<rx>\\G(\\/|~|@|%|§)(((\\\\\\\\)*\\\\\\2)|.*?(?=(\\\\|\\2)))*\\2)|((?<osp>_\\?)|(?<wsp>_))|(?<node>\\w+)|(?<literal>(\"[^\"]*\")|('[^']*'))|(\\$(?<expression>\\w+))/";
                $pos = $this->parser->pos;
                if (isset($this->parser->regexpCache['RuleToken7'][$pos])) {
                    $subres = $this->parser->regexpCache['RuleToken7'][$pos];
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
                                $this->parser->regexpCache['RuleToken7'][$subres['_startpos']] = $subres;
                                $this->parser->regexpCache['RuleToken7'][$pos] = false;
                                $subres = false;
                            }
                        } else {
                            $this->parser->regexpCache['RuleToken7'][$pos] = false;
                            $subres = false;
                        }
                    } else {
                        $this->parser->regexpCache['RuleToken7'][$pos] = false;
                        $subres = false;
                    }
                }
                if ($subres) {
                    $subres['_lineno'] = $this->parser->line;
                    $this->parser->pos = $subres['_endpos'];
                    $this->parser->line += substr_count($subres['_text'], "\n");
                    $subres['_tag'] = false;
                    $subres['_name'] = 'RuleToken';
                    $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
                    $valid = true;
                } else {
                    $valid = false;
                }
                if ($valid) {
                    $result['_text'] .= $subres['_text'];
                }
                // End 'RuleToken'
                if ($valid) {
                    break;
                }
                // Start 'RuleToken' min '1' max '1'
                // start sequence
                $backup8 = $result;
                $pos8 = $this->parser->pos;
                $line8 = $this->parser->line;
                do {
                    // Start 'RuleToken' min '1' max '1'
                    if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= '(';
                        $this->parser->successLiteral('(');
                        $valid = true;
                    } else {
                        $this->parser->failLiteral('(');
                        $valid = false;
                    }
                    // End 'RuleToken'
                    if (!$valid) {
                        break;
                    }
                    // Start 'RuleToken' min '1' max '1'
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                        $this->parser->pos += strlen($match[0]);
                        $this->parser->line += substr_count($match[0], "\n");
                    }
                    $valid = true;
                    // End 'RuleToken'
                    if (!$valid) {
                        break;
                    }
                    // Start 'RuleToken' tag 'seq' min '1' max '1'
                    $this->parser->addBacktrace(array('Sequence', $result));
                    $subres = $this->parser->matchRule($result, 'Sequence');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Sequence', $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->RuleToken_seq($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'RuleToken'
                    if (!$valid) {
                        break;
                    }
                    // Start 'RuleToken' min '1' max '1'
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                        $this->parser->pos += strlen($match[0]);
                        $this->parser->line += substr_count($match[0], "\n");
                    }
                    $valid = true;
                    // End 'RuleToken'
                    if (!$valid) {
                        break;
                    }
                    // Start 'RuleToken' min '1' max '1'
                    if (')' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= ')';
                        $this->parser->successLiteral(')');
                        $valid = true;
                    } else {
                        $this->parser->failLiteral(')');
                        $valid = false;
                    }
                    // End 'RuleToken'
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
                // End 'RuleToken'
                if ($valid) {
                    break;
                }
                break;
            } while (true);
            // end option
            // End 'RuleToken'
            if (!$valid) {
                break;
            }
            // Start 'RuleToken' min '0' max '1'
            $regexp = "/((?<quest>\\?)|(?<any>\\*)|(?<must>\\+?)|(\\{(?<min>\\d+)?,(?<max>\\d+)?\\}))?/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['RuleToken16'][$pos])) {
                $subres = $this->parser->regexpCache['RuleToken16'][$pos];
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
                            $this->parser->regexpCache['RuleToken16'][$subres['_startpos']] = $subres;
                            $this->parser->regexpCache['RuleToken16'][$pos] = false;
                            $subres = false;
                        }
                    } else {
                        $this->parser->regexpCache['RuleToken16'][$pos] = false;
                        $subres = false;
                    }
                } else {
                    $this->parser->regexpCache['RuleToken16'][$pos] = false;
                    $subres = false;
                }
            }
            if ($subres) {
                $subres['_lineno'] = $this->parser->line;
                $this->parser->pos = $subres['_endpos'];
                $this->parser->line += substr_count($subres['_text'], "\n");
                $subres['_tag'] = false;
                $subres['_name'] = 'RuleToken';
                $result['_matchres'] = array_merge($result['_matchres'], $subres['_matchres']);
                $valid = true;
            } else {
                $valid = false;
            }
            if ($valid) {
                $result['_text'] .= $subres['_text'];
            }
            $valid = true;
            // End 'RuleToken'
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
        // End 'RuleToken'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->RuleToken___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function RuleToken___START(&$result, $previous)
    {
        $result['_rule'] = array();
    }

    public function RuleToken_seq(&$result, $subres)
    {
        $result['_rule'] = array_merge($result['_rule'], $subres['_rule']);
    }

    public function RuleToken___FINISH(&$result)
    {
        $result['_rule']['_tagcomment'] = $result['_text'];
        $mr = $result['_matchres'];
        if (isset($mr['osp']) && !empty($mr['osp'])) {
            $result['_rule']['_type'] = 'whitespace';
            $result['_rule']['_param'] = true;
        }
        if (isset($mr['wsp']) && !empty($mr['wsp'])) {
            $result['_rule']['_type'] = 'whitespace';
            $result['_rule']['_param'] = false;
        }
        if (isset($mr['node']) && !empty($mr['node'])) {
            $result['_rule']['_type'] = 'recurse';
            $result['_rule']['_param'] = $mr['node'];
        }
        if (isset($mr['expression']) && !empty($mr['expression'])) {
            $result['_rule']['_type'] = 'expression';
            $result['_rule']['_param'] = $mr['expression'];
        }
        if (isset($mr['literal']) && !empty($mr['literal'])) {
            $result['_rule']['_type'] = 'literal';
            $result['_rule']['_param'] = trim($mr['literal'], "'\"");
        }
        if (isset($mr['rx']) && !empty($mr['rx'])) {
            $result['_rule']['_type'] = 'rx';
            $result['_rule']['_param'] = $mr['rx'];
        }
        if (isset($mr['silent']) && !empty($mr['silent'])) {
            $result['_rule']['_silent'] = strlen($mr['silent']);
        }
        if (isset($mr['pla']) && !empty($mr['pla'])) {
            $result['_rule']['_pla'] = true;
        }
        if (isset($mr['nla']) && !empty($mr['nla'])) {
            $result['_rule']['_nla'] = true;
        }
        if (isset($mr['tag']) && !empty($mr['tag'])) {
            $result['_rule']['_tag'] = $mr['tag'];
        }
        if (isset($mr['quest']) && !empty($mr['quest'])) {
            $result['_rule']['_min'] = 0;
        } elseif (isset($mr['any']) && !empty($mr['any'])) {
            $result['_rule']['_min'] = 0;
            $result['_rule']['_max'] = null;
        } elseif (isset($mr['must']) && !empty($mr['must'])) {
            $result['_rule']['_max'] = null;
        } else {
            if (isset($mr['min']) && !empty($mr['min'])) {
                $result['_rule']['_min'] = $mr['min'];
                $result['_rule']['_max'] = null;
            }
            if (isset($mr['max']) && !empty($mr['max'])) {
                $result['_rule']['_max'] = $mr['max'];
            }
        }
        $result['_matchres'] = array();
    }

    /**
     * Parser rules and action for node 'File'
     *  Rule:
     * <node File> <rule>  (  .Text .Parser* )* </rule>  <action _start> {
     * $result['_nodes']= array();
     * } </action>  <action _all> {
     * if (isset($subres['_node'])) {
     * $result['_nodes'][] = $subres['_node'];
     * }
     * } </action> </node>

     */
    public function matchNodeFile($previous)
    {
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->File___START($result, $previous);
        // Start 'File' min '0' max 'null'
        $iteration0 = 0;
        do {
            // start sequence
            $backup1 = $result;
            $pos1 = $this->parser->pos;
            $line1 = $this->parser->line;
            do {
                // Start 'File' min '1' max '1'
                $this->parser->addBacktrace(array('Text', $result));
                $subres = $this->parser->matchRule($result, 'Text');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Text', $subres));
                    $this->File___ALL($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'File'
                if (!$valid) {
                    break;
                }
                // Start 'File' min '0' max 'null'
                $iteration3 = 0;
                do {
                    $this->parser->addBacktrace(array('Parser', $result));
                    $subres = $this->parser->matchRule($result, 'Parser');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Parser', $subres));
                        $this->File___ALL($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    $iteration3 = $valid ? ($iteration3 + 1) : $iteration3;
                    if (!$valid && $iteration3 >= 0) {
                        $valid = true;
                        break;
                    }
                    if (!$valid) {
                        break;
                    }
                } while (true);
                // End 'File'
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
            $iteration0 = $valid ? ($iteration0 + 1) : $iteration0;
            if (!$valid && $iteration0 >= 0) {
                $valid = true;
                break;
            }
            if (!$valid) {
                break;
            }
        } while (true);
        // End 'File'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function File___START(&$result, $previous)
    {
        $result['_nodes'] = array();
    }

    public function File___ALL(&$result, $subres)
    {
        if (isset($subres['_node'])) {
            $result['_nodes'][] = $subres['_node'];
        }
    }

    /**
     * Constructor
     *
     * @param \Smarty_Compiler|\Smarty_Compiler_CompilerCore $compiler compiler object
     * @param \Smarty_Template_Context                       $context
     */
    function __construct(Compiler $compiler, Context $context)
    {
        $this->parser = $this;
        $this->context = $context;
        if (isset($this->rules)) {
            foreach ($this->rules as $name => $rule) {
                $this->rulePegParserArray[$name] = $this;
            }
        }
        if (isset($this->matchMethods)) {
            foreach ($this->matchMethods as $name => $rule) {
                $this->rulePegParserArray[$name] = $this;
            }
        }
        if ($this->trace) {
            $this->traceFile = fopen('php://output', 'w');
        }
    }

    /**
     * @param string $ruleName
     *
     * @throws \Smarty\Parser\Exception\NoRule
     * @return mixed
     */
    public function getRuleAsArray($ruleName)
    {
        if (isset($this->rules[$ruleName])) {
            $rule = $this->rules[$ruleName];
            $rule['_ruleParser'] = $this;
        } else {
            throw new NoRule($ruleName, 0, $this->context);
        }
        return $rule;
    }

    /**
     * @param $infile
     *
     * @return mixed
     */
    public function compileFile($infile)
    {
        $this->filename = $infile;
        $this->filetime = filemtime($infile);
        $string = file_get_contents($infile);
        return $this->compile($string);
    }

    /**
     * @param $string
     *
     * @return mixed
     */
    public function compile($string)
    {
        $this->setSource($string);
        $result = $this->parser->parse('File');
        $output = '';
        foreach ($result['_nodes'] as $node) {
            $output .= $node->compile($this->filename, $this->filetime);
        }
        return $output;
    }

    /**
     * @param $string
     * @param $outfile
     */
    public function compileStringToFile($string, $outfile)
    {
        $string = $this->compile($string);
        file_put_contents($outfile, $string);
    }

    public function compileDynamic($string)
    {
        $this->setSource($string);
        if (preg_match("/([\\S\\s]+(?=([^\\S\\r\\n]\\/\\*!\\*)))|[\\S\\s]+/", $this->parser->source, $match)) {
            $this->parser->pos += strlen($match[1]);
            $this->parser->line += substr_count($match[1], "\n");
            $result = $this->parser->parse('Parser');
            return $result['_node']->nodes;
        }
        return '';
    }
}

