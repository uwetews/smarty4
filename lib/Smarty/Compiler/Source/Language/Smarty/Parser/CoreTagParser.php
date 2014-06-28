<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;
use Smarty\PegParser;

/**
 * Class CoreTagParser
 *
 * @package Smarty\Compiler\Source\Language\Smarty\Parser
 */
class CoreTagParser extends PegParser
{
   
    /**
     *
     * Parser generated on 2014-06-28 11:26:33
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/CoreTag.peg.inc' dated 2014-06-28 02:53:31
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
            "CoreTag" => "matchNodeCoreTag",
            "SmartyTagAttributes" => "matchNodeSmartyTagAttributes",
            "SmartyTagOptions" => "matchNodeSmartyTagOptions",
            "SmartyTagScopes" => "matchNodeSmartyTagScopes",
            "Smarty_Tag_Block_Close" => "matchNodeSmarty_Tag_Block_Close",
            "Smarty_Tag_Default" => "matchNodeSmarty_Tag_Default",
            "Smarty_Tag_Block_Default" => "matchNodeSmarty_Tag_Block_Default"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "CoreTag" => array(
                    "_nodetype" => "token"
                ),
            "SmartyTagAttributes" => array(
                    "_nodetype" => "token"
                ),
            "SmartyTagOptions" => array(
                    "_nodetype" => "token"
                ),
            "SmartyTagScopes" => array(
                    "_nodetype" => "token"
                ),
            "Smarty_Tag_Block_Close" => array(
                    "_nodetype" => "token"
                ),
            "Smarty_Tag_Default" => array(
                    "_nodetype" => "node"
                ),
            "Smarty_Tag_Block_Default" => array(
                    "_nodetype" => "node"
                )
        );
    /**
     *
     * Parser rules and action for node 'CoreTag'
     *
     *  Rule:
     <token CoreTag> <rule>  (  .Ldel .tagname:Id !'(' tag:$tagDispatcher ) | tag:TagStatement | tag:TagOutput </rule>  <action _start> {
                $i = 1;
            } </action>  <action _expression(tagDispatcher)> {
                    $result['_text'] = '';
                    return $this->parser->tagDispatcher($result);
                } </action>  <action tag> {
                    $result['node'] = $subres['node'];
                } </action> </token> 
     *
    */
    public function matchNodeCoreTag($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->CoreTag___START($result, $previous);
        // Start 'CoreTag' min '1' max '1'
        // start option
        do {
            // Start '(  .Ldel .tagname:Id !'(' tag:$tagDispatcher )' min '1' max '1'
            // start sequence
            $backup2 = $result;
            $pos2 = $this->parser->pos;
            $line2 = $this->parser->line;
            do {
                // Start '.Ldel' min '1' max '1'
                $this->parser->addBacktrace(array('Ldel', $result));
                $subres = $this->parser->matchRule($result, 'Ldel');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Ldel',  $subres));
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End '.Ldel'
                if (!$valid) {
                    break;
                }
                // Start '.tagname:Id' tag 'tagname' min '1' max '1'
                $this->parser->addBacktrace(array('Id', $result));
                $subres = $this->parser->matchRule($result, 'Id');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Id',  $subres));
                    if(!isset($result['tagname'])) {
                        $result['tagname'] = $subres;
                    } else {
                        if (!is_array($result['tagname'])) {
                            $result['tagname'] = array($result['tagname']);
                        }
                        $result['tagname'][] = $subres;
                    }
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End '.tagname:Id'
                if (!$valid) {
                    break;
                }
                // Start '!'('' min '1' max '1' negative lookahead
                $backup5 = $result;
                $pos5 = $this->parser->pos;
                $line5 = $this->parser->line;
                if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $result['_text'] .= '(';
                    $this->parser->successLiteral('(');
                    $valid = false;
                } else {
                    $this->parser->failLiteral('(');
                    $valid = true;
                }
                $this->parser->pos = $pos5;
                $this->parser->line = $line5;
                $result = $backup5;
                unset($backup5);
                // End '!'(''
                if (!$valid) {
                    break;
                }
                // Start 'tag:$tagDispatcher' tag 'tag' min '1' max '1'
                $subres = $result;
                $this->parser->addBacktrace(array('CoreTag', $result));
                $valid = false;
                $method = 'CoreTag_EXP_tagDispatcher';
                $valid = $this->$method($subres);
                $remove = array_pop($this->parser->backtrace);
                if ($valid) {
                    $this->parser->successNode(array('CoreTag', $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->CoreTag_tag($result, $subres);
                } else {
                    $this->parser->failNode($remove);
                }
                // End 'tag:$tagDispatcher'
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
            // End '(  .Ldel .tagname:Id !'(' tag:$tagDispatcher )'
            if ($valid) {
                break;
            }
            // Start 'tag:TagStatement' tag 'tag' min '1' max '1'
            $this->parser->addBacktrace(array('TagStatement', $result));
            $subres = $this->parser->matchRule($result, 'TagStatement');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('TagStatement',  $subres));
                $result['_text'] .= $subres['_text'];
                $this->CoreTag_tag($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'tag:TagStatement'
            if ($valid) {
                break;
            }
            // Start 'tag:TagOutput' tag 'tag' min '1' max '1'
            $this->parser->addBacktrace(array('TagOutput', $result));
            $subres = $this->parser->matchRule($result, 'TagOutput');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('TagOutput',  $subres));
                $result['_text'] .= $subres['_text'];
                $this->CoreTag_tag($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'tag:TagOutput'
            if ($valid) {
                break;
            }
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
        }
        return $result;
    }

    public function CoreTag___START (&$result, $previous) {
        $i = 1;
    }


    public function CoreTag_EXP_tagDispatcher (&$result) {
        $result['_text'] = '';
        return $this->parser->tagDispatcher($result);
    }


    public function CoreTag_tag (&$result, $subres) {
        $result['node'] = $subres['node'];
    }


    /**
     *
     * Parser rules and action for node 'SmartyTagAttributes'
     *
     *  Rule:
     <token SmartyTagAttributes> <rule>  (  _ (  name:Id _? '=' _? ) value:Value )* </rule>  <action _start> {
                $result['node'] = $previous['node'];
            } </action>  <action name> {
                $result['name'] = strtolower($subres['_text']);
            } </action>  <action value> {
                $result['node']->setTagAttribute(array(isset($result['name']) ? $result['name'] : null, $subres['node']));
            } </action>  <action _finish> {
                $i = 1;
            } </action> </token> 
     *
    */
    public function matchNodeSmartyTagAttributes($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->SmartyTagAttributes___START($result, $previous);
        // Start '(  _ (  name:Id _? '=' _? ) value:Value )*' min '0' max 'null'
        $iteration0 = 0;
        do {
            // start sequence
            $backup1 = $result;
            $pos1 = $this->parser->pos;
            $line1 = $this->parser->line;
            do {
                // Start '_' min '1' max '1'
                if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                    $result['_text'] .= ' ';
                    $valid = true;
                } else {
                    $valid = false;
                }
                // End '_'
                if (!$valid) {
                    break;
                }
                // Start '(  name:Id _? '=' _? )' min '1' max '1'
                // start sequence
                $backup4 = $result;
                $pos4 = $this->parser->pos;
                $line4 = $this->parser->line;
                do {
                    // Start 'name:Id' tag 'name' min '1' max '1'
                    $this->parser->addBacktrace(array('Id', $result));
                    $subres = $this->parser->matchRule($result, 'Id');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('Id',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $this->SmartyTagAttributes_name($result, $subres);
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'name:Id'
                    if (!$valid) {
                        break;
                    }
                    // Start '_?' min '1' max '1'
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                        $this->parser->pos += strlen($match[0]);
                        $this->parser->line += substr_count($match[0], "\n");
                        $result['_text'] .= ' ';
                    }
                    $valid = true;
                    // End '_?'
                    if (!$valid) {
                        break;
                    }
                    // Start ''='' min '1' max '1'
                    if ('=' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $result['_text'] .= '=';
                        $this->parser->successLiteral('=');
                        $valid = true;
                    } else {
                        $this->parser->failLiteral('=');
                        $valid = false;
                    }
                    // End ''=''
                    if (!$valid) {
                        break;
                    }
                    // Start '_?' min '1' max '1'
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                        $this->parser->pos += strlen($match[0]);
                        $this->parser->line += substr_count($match[0], "\n");
                        $result['_text'] .= ' ';
                    }
                    $valid = true;
                    // End '_?'
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
                // End '(  name:Id _? '=' _? )'
                if (!$valid) {
                    break;
                }
                // Start 'value:Value' tag 'value' min '1' max '1'
                $this->parser->addBacktrace(array('Value', $result));
                $subres = $this->parser->matchRule($result, 'Value');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Value',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->SmartyTagAttributes_value($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'value:Value'
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
            if (!$valid) break;
        } while (true);
        // End '(  _ (  name:Id _? '=' _? ) value:Value )*'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->SmartyTagAttributes___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function SmartyTagAttributes___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function SmartyTagAttributes_name (&$result, $subres) {
        $result['name'] = strtolower($subres['_text']);
    }


    public function SmartyTagAttributes_value (&$result, $subres) {
        $result['node']->setTagAttribute(array(isset($result['name']) ? $result['name'] : null, $subres['node']));
    }


    public function SmartyTagAttributes___FINISH (&$result) {
        $i = 1;
    }


    /**
     *
     * Parser rules and action for node 'SmartyTagOptions'
     *
     *  Rule:
     <token SmartyTagOptions> <rule>  (  _ option:Id )* </rule>  <action _start> {
                $result['node'] = $previous['node'];
            } </action>  <action option> {
                $result['node']->setTagOption(strtolower($subres['_text']));
            } </action> </token> 
     *
    */
    public function matchNodeSmartyTagOptions($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->SmartyTagOptions___START($result, $previous);
        // Start '(  _ option:Id )*' min '0' max 'null'
        $iteration0 = 0;
        do {
            // start sequence
            $backup1 = $result;
            $pos1 = $this->parser->pos;
            $line1 = $this->parser->line;
            do {
                // Start '_' min '1' max '1'
                if (preg_match($this->parser->whitespacePattern, $this->parser->source, $match, 0, $this->parser->pos)) {
                    $this->parser->pos += strlen($match[0]);
                    $this->parser->line += substr_count($match[0], "\n");
                    $result['_text'] .= ' ';
                    $valid = true;
                } else {
                    $valid = false;
                }
                // End '_'
                if (!$valid) {
                    break;
                }
                // Start 'option:Id' tag 'option' min '1' max '1'
                $this->parser->addBacktrace(array('Id', $result));
                $subres = $this->parser->matchRule($result, 'Id');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Id',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->SmartyTagOptions_option($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'option:Id'
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
            if (!$valid) break;
        } while (true);
        // End '(  _ option:Id )*'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function SmartyTagOptions___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function SmartyTagOptions_option (&$result, $subres) {
        $result['node']->setTagOption(strtolower($subres['_text']));
    }


    /**
     *
     * Parser rules and action for node 'SmartyTagScopes'
     *
     *  Rule:
     <token SmartyTagScopes> <rule>  (  /scope\s*=\s*(?<scope>(parent|root|global))/ )? </rule>  <action _start> {
                $result['node'] = $previous['node'];
            } </action>  <action option> {
                $result['node']->setTagOption(strtolower($subres['_text']));
            } </action> </token> 
     *
    */
    public function matchNodeSmartyTagScopes($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->SmartyTagScopes___START($result, $previous);
        // Start '(  /scope\s*=\s*(?<scope>(parent|root|global))/ )?' min '0' max '1'
        $regexp = "/scope\s*=\s*(?<scope>(parent|root|global))/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['SmartyTagScopes2'][$pos])) {
            $subres = $this->parser->regexpCache['SmartyTagScopes2'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]));
                foreach ($match as $n => $v) {
                    if (is_string($n)) {
                        $subres['_matchres'][$n] = $v[0];
                    }
                }
                if ($subres['_startpos'] != $pos) {
                    $this->parser->regexpCache['SmartyTagScopes2'][$subres['_startpos']] = $subres;
                    $this->parser->regexpCache['SmartyTagScopes2'][$pos] = false;
                    $subres = false;
                }
            } else {
                $this->parser->regexpCache['SmartyTagScopes2'][$pos] = false;
                $subres = false;
            }
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'SmartyTagScopes';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        }
        $valid = true;
        // End '(  /scope\s*=\s*(?<scope>(parent|root|global))/ )?'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function SmartyTagScopes___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function SmartyTagScopes_option (&$result, $subres) {
        $result['node']->setTagOption(strtolower($subres['_text']));
    }


    /**
     *
     * Parser rules and action for node 'Smarty_Tag_Block_Close'
     *
     *  Rule:
     <token Smarty_Tag_Block_Close> <rule>  LdelSlash tag:Id Rdel </rule> </token> 
     *
    */
    public function matchNodeSmarty_Tag_Block_Close($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Smarty_Tag_Block_Close' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'LdelSlash' min '1' max '1'
            $this->parser->addBacktrace(array('LdelSlash', $result));
            $subres = $this->parser->matchRule($result, 'LdelSlash');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('LdelSlash',  $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'LdelSlash'
            if (!$valid) {
                break;
            }
            // Start 'tag:Id' tag 'tag' min '1' max '1'
            $this->parser->addBacktrace(array('Id', $result));
            $subres = $this->parser->matchRule($result, 'Id');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Id',  $subres));
                $result['_text'] .= $subres['_text'];
                if(!isset($result['tag'])) {
                    $result['tag'] = $subres;
                } else {
                    if (!is_array($result['tag'])) {
                        $result['tag'] = array($result['tag']);
                    }
                    $result['tag'][] = $subres;
                }
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'tag:Id'
            if (!$valid) {
                break;
            }
            // Start 'Rdel' min '1' max '1'
            $this->parser->addBacktrace(array('Rdel', $result));
            $subres = $this->parser->matchRule($result, 'Rdel');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Rdel',  $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Rdel'
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
        // End 'Smarty_Tag_Block_Close'
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
     *
     * Parser rules and action for node 'Smarty_Tag_Default'
     *
     *  Rule:
     <node Smarty_Tag_Default> <rule>  Ldel Id SmartyTagAttributes SmartyTagOptions Rdel </rule>  <action _start> {
                $result['node'] = $previous['node'];
            } </action>  <action _finish> {
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

            } </action> </node> 
     *
    */
    public function matchNodeSmarty_Tag_Default($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->Smarty_Tag_Default___START($result, $previous);
        // Start 'Smarty_Tag_Default' min '1' max '1'
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
            // Start 'Id' min '1' max '1'
            $this->parser->addBacktrace(array('Id', $result));
            $subres = $this->parser->matchRule($result, 'Id');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Id',  $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Id'
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
            // Start 'Rdel' min '1' max '1'
            $this->parser->addBacktrace(array('Rdel', $result));
            $subres = $this->parser->matchRule($result, 'Rdel');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Rdel',  $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Rdel'
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
        // End 'Smarty_Tag_Default'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->Smarty_Tag_Default___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Smarty_Tag_Default___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function Smarty_Tag_Default___FINISH (&$result) {
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
     *
     * Parser rules and action for node 'Smarty_Tag_Block_Default'
     *
     *  Rule:
     <node Smarty_Tag_Block_Default> <rule>  Smarty_Tag_Default body:Body Smarty_Tag_Block_Close </rule> </node> 
     *
    */
    public function matchNodeSmarty_Tag_Block_Default($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start 'Smarty_Tag_Block_Default' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        do {
            // Start 'Smarty_Tag_Default' min '1' max '1'
            $this->parser->addBacktrace(array('Smarty_Tag_Default', $result));
            $subres = $this->parser->matchRule($result, 'Smarty_Tag_Default');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Smarty_Tag_Default',  $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Smarty_Tag_Default'
            if (!$valid) {
                break;
            }
            // Start 'body:Body' tag 'body' min '1' max '1'
            $this->parser->addBacktrace(array('Body', $result));
            $subres = $this->parser->matchRule($result, 'Body');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Body',  $subres));
                $result['_text'] .= $subres['_text'];
                if(!isset($result['body'])) {
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
                break;
            }
            // Start 'Smarty_Tag_Block_Close' min '1' max '1'
            $this->parser->addBacktrace(array('Smarty_Tag_Block_Close', $result));
            $subres = $this->parser->matchRule($result, 'Smarty_Tag_Block_Close');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Smarty_Tag_Block_Close',  $subres));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            // End 'Smarty_Tag_Block_Close'
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
        // End 'Smarty_Tag_Block_Default'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }


}
