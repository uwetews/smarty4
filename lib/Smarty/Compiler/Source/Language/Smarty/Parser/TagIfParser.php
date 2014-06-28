<?php
namespace Smarty\Compiler\Source\Language\Smarty\Parser;

use Smarty\PegParser;

/**
 * Class TagIfParser
 *
 * @package Smarty\Compiler\Source\Language\Smarty\Parser
 */
class TagIfParser extends PegParser
{
   
    /**
     *
     * Parser generated on 2014-06-28 11:26:33
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Source/Language/Smarty/Parser/TagIf.peg.inc' dated 2014-06-28 02:53:30
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
            "TagIf" => "matchNodeTagIf",
            "elseifTagif" => "matchNodeelseifTagif",
            "elseTagif" => "matchNodeelseTagif"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "TagIf" => array(
                    "_nodetype" => "node",
                    "attributes" => array(
                            "subtags" => array(
                                    "elseif" => true,
                                    "else" => true
                                )
                        ),
                    "options" => "nocache"
                ),
            "elseifTagif" => array(
                    "_nodetype" => "token"
                ),
            "elseTagif" => array(
                    "_nodetype" => "token"
                )
        );
    /**
     *
     * Parser rules and action for node 'TagIf'
     *
     *  Rule:
     <node TagIf> <attribute> attributes =  ( subtags =  ( elseif , else )), options =  nocache</attribute>  <rule>  Ldel 'if' _ condition:Statement | condition:Logexpr SmartyTagOptions Rdel body:Body? (  !LdelSlash elseifTagif )* (  !LdelSlash elseTagif )? close:Smarty_Tag_Block_Close </rule>  <action _start> {
                    $result['node'] = $previous['node'];
                } </action>  <action condition> {
                    $result['condition'] = $subres['node'];
                } </action>  <action body> {
                    $result['body'] = $subres['node'];
                } </action>  <action _finish> {
                    $result['node']->addSubTree(array('condition' => $result['condition'], 'body' => isset($result['body']) ? $result['body'] : false),'if');
                } </action> </node> 
     *
    */
    public function matchNodeTagIf($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->TagIf___START($result, $previous);
        // Start 'TagIf' min '1' max '1'
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
            // Start ''if'' min '1' max '1'
            if ('if' == substr($this->parser->source, $this->parser->pos, 2)) {
                $this->parser->pos += 2;
                $result['_text'] .= 'if';
                $this->parser->successLiteral('if');
                $valid = true;
            } else {
                $this->parser->failLiteral('if');
                $valid = false;
            }
            // End ''if''
            if (!$valid) {
                break;
            }
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
            // Start 'TagIf' min '1' max '1'
            // start option
            do {
                // Start 'condition:Statement' tag 'condition' min '1' max '1'
                $this->parser->addBacktrace(array('Statement', $result));
                $subres = $this->parser->matchRule($result, 'Statement');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Statement',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->TagIf_condition($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'condition:Statement'
                if ($valid) {
                    break;
                }
                // Start 'condition:Logexpr' tag 'condition' min '1' max '1'
                $this->parser->addBacktrace(array('Logexpr', $result));
                $subres = $this->parser->matchRule($result, 'Logexpr');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Logexpr',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->TagIf_condition($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'condition:Logexpr'
                if ($valid) {
                    break;
                }
                break;
            } while (true);
            // end option
            // End 'TagIf'
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
            // Start 'body:Body?' tag 'body' min '0' max '1'
            $this->parser->addBacktrace(array('Body', $result));
            $subres = $this->parser->matchRule($result, 'Body');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Body',  $subres));
                $result['_text'] .= $subres['_text'];
                $this->TagIf_body($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            $valid = true;
            // End 'body:Body?'
            if (!$valid) {
                break;
            }
            // Start '(  !LdelSlash elseifTagif )*' min '0' max 'null'
            $iteration11 = 0;
            do {
                // start sequence
                $backup12 = $result;
                $pos12 = $this->parser->pos;
                $line12 = $this->parser->line;
                do {
                    // Start '!LdelSlash' min '1' max '1' negative lookahead
                    $backup13 = $result;
                    $pos13 = $this->parser->pos;
                    $line13 = $this->parser->line;
                    $this->parser->addBacktrace(array('LdelSlash', $result));
                    $subres = $this->parser->matchRule($result, 'LdelSlash');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('LdelSlash',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $valid = false;
                    } else {
                        $valid = true;
                        $this->parser->failNode($remove);
                    }
                    $this->parser->pos = $pos13;
                    $this->parser->line = $line13;
                    $result = $backup13;
                    unset($backup13);
                    // End '!LdelSlash'
                    if (!$valid) {
                        break;
                    }
                    // Start 'elseifTagif' min '1' max '1'
                    $this->parser->addBacktrace(array('elseifTagif', $result));
                    $subres = $this->parser->matchRule($result, 'elseifTagif');
                    $remove = array_pop($this->parser->backtrace);
                    if ($subres) {
                        $this->parser->successNode(array('elseifTagif',  $subres));
                        $result['_text'] .= $subres['_text'];
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->parser->failNode($remove);
                    }
                    // End 'elseifTagif'
                    if (!$valid) {
                        break;
                    }
                    break;
                } while (true);
                if (!$valid) {
                    $this->parser->pos = $pos12;
                    $this->parser->line = $line12;
                    $result = $backup12;
                }
                unset($backup12);
                // end sequence
                $iteration11 = $valid ? ($iteration11 + 1) : $iteration11;
                if (!$valid && $iteration11 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) break;
            } while (true);
            // End '(  !LdelSlash elseifTagif )*'
            if (!$valid) {
                break;
            }
            // Start '(  !LdelSlash elseTagif )?' min '0' max '1'
            // start sequence
            $backup16 = $result;
            $pos16 = $this->parser->pos;
            $line16 = $this->parser->line;
            do {
                // Start '!LdelSlash' min '1' max '1' negative lookahead
                $backup17 = $result;
                $pos17 = $this->parser->pos;
                $line17 = $this->parser->line;
                $this->parser->addBacktrace(array('LdelSlash', $result));
                $subres = $this->parser->matchRule($result, 'LdelSlash');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('LdelSlash',  $subres));
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
                // End '!LdelSlash'
                if (!$valid) {
                    break;
                }
                // Start 'elseTagif' min '1' max '1'
                $this->parser->addBacktrace(array('elseTagif', $result));
                $subres = $this->parser->matchRule($result, 'elseTagif');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('elseTagif',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'elseTagif'
                if (!$valid) {
                    break;
                }
                break;
            } while (true);
            if (!$valid) {
                $this->parser->pos = $pos16;
                $this->parser->line = $line16;
                $result = $backup16;
            }
            unset($backup16);
            // end sequence
            $valid = true;
            // End '(  !LdelSlash elseTagif )?'
            if (!$valid) {
                break;
            }
            // Start 'close:Smarty_Tag_Block_Close' tag 'close' min '1' max '1'
            $this->parser->addBacktrace(array('Smarty_Tag_Block_Close', $result));
            $subres = $this->parser->matchRule($result, 'Smarty_Tag_Block_Close');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Smarty_Tag_Block_Close',  $subres));
                $result['_text'] .= $subres['_text'];
                if(!isset($result['close'])) {
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
            // End 'close:Smarty_Tag_Block_Close'
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
        // End 'TagIf'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->TagIf___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function TagIf___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function TagIf_condition (&$result, $subres) {
        $result['condition'] = $subres['node'];
    }


    public function TagIf_body (&$result, $subres) {
        $result['body'] = $subres['node'];
    }


    public function TagIf___FINISH (&$result) {
        $result['node']->addSubTree(array('condition'=> $result['condition'], 'body'=> isset($result['body']) ? $result['body'] : false),'if');
    }


    /**
     *
     * Parser rules and action for node 'elseifTagif'
     *
     *  Rule:
     <token elseifTagif> <rule>  Ldel 'elseif' _ condition:Statement | condition:Logexpr Rdel body:Body? </rule>  <action _start> {
                    $result['node'] = $previous['node'];
                 } </action>  <action condition> {
                    $result['condition'] = $subres['node'];
                } </action>  <action body> {
                    $result['body'] = $subres['node'];
                } </action>  <action _finish> {
                    $result['node']->addSubTree(array('condition' => $result['condition'], 'body' => isset($result['body']) ? $result['body'] : false),'elseif', true);
                } </action> </token> 
     *
    */
    public function matchNodeelseifTagif($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->elseifTagif___START($result, $previous);
        // Start 'elseifTagif' min '1' max '1'
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
            // Start ''elseif'' min '1' max '1'
            if ('elseif' == substr($this->parser->source, $this->parser->pos, 6)) {
                $this->parser->pos += 6;
                $result['_text'] .= 'elseif';
                $this->parser->successLiteral('elseif');
                $valid = true;
            } else {
                $this->parser->failLiteral('elseif');
                $valid = false;
            }
            // End ''elseif''
            if (!$valid) {
                break;
            }
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
            // Start 'elseifTagif' min '1' max '1'
            // start option
            do {
                // Start 'condition:Statement' tag 'condition' min '1' max '1'
                $this->parser->addBacktrace(array('Statement', $result));
                $subres = $this->parser->matchRule($result, 'Statement');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Statement',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->elseifTagif_condition($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'condition:Statement'
                if ($valid) {
                    break;
                }
                // Start 'condition:Logexpr' tag 'condition' min '1' max '1'
                $this->parser->addBacktrace(array('Logexpr', $result));
                $subres = $this->parser->matchRule($result, 'Logexpr');
                $remove = array_pop($this->parser->backtrace);
                if ($subres) {
                    $this->parser->successNode(array('Logexpr',  $subres));
                    $result['_text'] .= $subres['_text'];
                    $this->elseifTagif_condition($result, $subres);
                    $valid = true;
                } else {
                    $valid = false;
                    $this->parser->failNode($remove);
                }
                // End 'condition:Logexpr'
                if ($valid) {
                    break;
                }
                break;
            } while (true);
            // end option
            // End 'elseifTagif'
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
            // Start 'body:Body?' tag 'body' min '0' max '1'
            $this->parser->addBacktrace(array('Body', $result));
            $subres = $this->parser->matchRule($result, 'Body');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Body',  $subres));
                $result['_text'] .= $subres['_text'];
                $this->elseifTagif_body($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            $valid = true;
            // End 'body:Body?'
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
        // End 'elseifTagif'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->elseifTagif___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function elseifTagif___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function elseifTagif_condition (&$result, $subres) {
        $result['condition'] = $subres['node'];
    }


    public function elseifTagif_body (&$result, $subres) {
        $result['body'] = $subres['node'];
    }


    public function elseifTagif___FINISH (&$result) {
        $result['node']->addSubTree(array('condition'=> $result['condition'], 'body'=> isset($result['body']) ? $result['body'] : false),'elseif', true);
    }


    /**
     *
     * Parser rules and action for node 'elseTagif'
     *
     *  Rule:
     <token elseTagif> <rule>  Ldel 'else' Rdel body:Body? </rule>  <action _start> {
                    $result['node'] = $previous['node'];
                } </action>  <action body> {
                    $result['body'] = $subres['node'];
                } </action>  <action _finish> {
                    $result['node']->addSubTree(array('body' => isset($result['body']) ? $result['body'] : false),'else');
                } </action> </token> 
     *
    */
    public function matchNodeelseTagif($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->elseTagif___START($result, $previous);
        // Start 'elseTagif' min '1' max '1'
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
            // Start ''else'' min '1' max '1'
            if ('else' == substr($this->parser->source, $this->parser->pos, 4)) {
                $this->parser->pos += 4;
                $result['_text'] .= 'else';
                $this->parser->successLiteral('else');
                $valid = true;
            } else {
                $this->parser->failLiteral('else');
                $valid = false;
            }
            // End ''else''
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
            // Start 'body:Body?' tag 'body' min '0' max '1'
            $this->parser->addBacktrace(array('Body', $result));
            $subres = $this->parser->matchRule($result, 'Body');
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Body',  $subres));
                $result['_text'] .= $subres['_text'];
                $this->elseTagif_body($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            $valid = true;
            // End 'body:Body?'
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
        // End 'elseTagif'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
            $this->elseTagif___FINISH($result);
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function elseTagif___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function elseTagif_body (&$result, $subres) {
        $result['body'] = $subres['node'];
    }


    public function elseTagif___FINISH (&$result) {
        $result['node']->addSubTree(array('body'=> isset($result['body']) ? $result['body'] : false),'else');
    }



}

