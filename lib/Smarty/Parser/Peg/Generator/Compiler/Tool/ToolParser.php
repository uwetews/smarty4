<?php
Namespace Smarty\Parser\Peg\Generator\Compiler\Tool;

use Smarty\Parser\Exception\NoRule;
use Smarty\Parser\Peg\RuleRoot;
/**
 * Class RuleRoot;
 *
 * @package Smarty\Nodes\Template
 */
class ToolParser extends RuleRoot
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
     *
     * Parser generated on 2014-08-26 20:41:51
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Tool/Parser/Peg/InternalTool/ParserGenerator.peg.inc' dated 2014-08-26 20:41:36
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
            "Root" => "matchNodeRoot",
            "Text" => "matchNodeText",
            "Parser" => "matchNodeParser",
            "Name" => "matchNodeName",
            "Header" => "matchNodeHeader",
            "End" => "matchNodeEnd",
            "Comment" => "matchNodeComment",
            "attrvalue" => "matchNodeattrvalue",
            "AttrEntry" => "matchNodeAttrEntry",
            "Attribute" => "matchNodeAttribute",
            "Node" => "matchNodeNode",
            "Rule" => "matchNodeRule",
            "Action" => "matchNodeAction",
            "Option" => "matchNodeOption",
            "Sequence" => "matchNodeSequence",
            "RuleToken" => "matchNodeRuleToken"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "Attribute" => array(
                    "importNode" => true
                ),
            "Rule" => array(
                    "importNode" => true
                ),
            "Action" => array(
                    "importNode" => true
                )
        );
    /**
     *
     * Parser rules and action for node 'Root'
     *
     *  Rule:
     * 
     * 
     *             <node Root>
     *                 <rule>(.Text .Parser*)*</rule>
     *                 <action _start>
     *                     {
     *                         $nodeRes['_node']= new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Root;
     *                     }
     *                 </action>
     *                 <action _all>
     *                     {
     *                         if (isset($matchRes['_node'])) {
     *                             $nodeRes['_node']->addNode($matchRes['_node']);
     *                         }
     *                     }
     *                 </action>
     *             </node>
     * 
     *
    */
    public function matchNodeRoot($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->Root_START($nodeRes, $previous);
        /*
         * Start rule: (.Text .Parser*)*
         *       min: 0 max: null
         */
        $iteration0 = 0;
        do {
            // start sequence
            $backup1 = $nodeRes;
            $pos1 = $this->parser->pos;
            $line1 = $this->parser->line;
            $error1 = $error;
            if ($trace) {
                $this->parser->addBacktrace(array('_s1_', ''));
            }
            do {
                $error = array();
                /*
                 * Start rule: .Text
                 *       min: 1 max: 1
                 */
                if ($trace) {
                    $this->parser->addBacktrace(array('Text', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'Text', $error);
                if ($trace) {
                    $remove = array_pop($this->parser->backtrace);
                }
                if ($matchRes) {
                    if ($trace) {
                        $this->parser->successNode(array('Text',  $matchRes['_text']));
                    }
                    $this->Root_ALL($nodeRes, $matchRes);
                    $valid = true;
                } else {
                    $valid = false;
                    if ($trace) {
                        $this->parser->failNode($remove);
                    }
                }
                /*
                 * End rule: .Text
                 */
                if (!$valid) {
                    $this->parser->matchError($error1, 'SequenceElement', $error);
                    $error = $error1;
                    break;
                }
                $error = array();
                /*
                 * Start rule: .Parser*
                 *       min: 0 max: null
                 */
                $iteration3 = 0;
                do {
                    if ($trace) {
                        $this->parser->addBacktrace(array('Parser', ''));
                    }
                    $matchRes = $this->parser->matchRule($nodeRes, 'Parser', $error);
                    if ($trace) {
                        $remove = array_pop($this->parser->backtrace);
                    }
                    if ($matchRes) {
                        if ($trace) {
                            $this->parser->successNode(array('Parser',  $matchRes['_text']));
                        }
                        $this->Root_ALL($nodeRes, $matchRes);
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $this->parser->failNode($remove);
                        }
                    }
                    $iteration3 = $valid ? ($iteration3 + 1) : $iteration3;
                    if (!$valid && $iteration3 >= 0) {
                        $valid = true;
                        break;
                    }
                    if (!$valid) break;
                } while (true);
                /*
                 * End rule: .Parser*
                 */
                if (!$valid) {
                    $this->parser->matchError($error1, 'SequenceElement', $error);
                    $error = $error1;
                    break;
                }
                break;
            } while (true);
            if ($trace) {
                $remove = array_pop($this->parser->backtrace);
            }
            if (!$valid) {
                if ($trace) {
                    $this->parser->failNode($remove);
                }
                $this->parser->pos = $pos1;
                $this->parser->line = $line1;
                $nodeRes = $backup1;
            } elseif ($trace) {
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
            if (!$valid) break;
        } while (true);
        /*
         * End rule: (.Text .Parser*)*
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Root');
        }
        return $nodeRes;
    }


    public function Root_START (&$nodeRes, $previous)
    {
        $nodeRes['_node']= new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Root;
    }



    public function Root_ALL (&$nodeRes, $matchRes)
    {
        if (isset($matchRes['_node']))        {
            $nodeRes['_node']->addNode($matchRes['_node']);
        }
    }

    /**
     *
     * Parser rules and action for node 'Text'
     *
     *  Rule:
     * <node Text>
     *                 <rule>/([\S\s]+(?=([^\S\r\n]\/\*!\*)))|[\S\s]+/</rule>
     *                 <action _start>
     *                     {
     *                         $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Text ($this, null);
     *                     }
     *                 </action>
     *                 <action _all>
     *                     {
     *                         $nodeRes['_node']->addText($matchRes['_text']);
     *                     }
     *                 </action>
     *             </node>
     * 
     *
    */
    public function matchNodeText($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->Text_START($nodeRes, $previous);
        /*
         * Start rule: /([\S\s]+(?=([^\S\r\n]\/\*!\*)))|[\S\s]+/
         *       min: 1 max: 1
         */
        $regexp = "/([\\S\\s]+(?=([^\\S\\r\\n]\\/\\*!\\*)))|[\\S\\s]+/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Rx_Text1'][$pos])) {
            $matchRes = $this->parser->regexpCache['Rx_Text1'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                if ($matchRes['_startpos'] != $pos) {
                    $this->parser->regexpCache['Rx_Text1'][$matchRes['_startpos']] = $matchRes;
                    $this->parser->regexpCache['Rx_Text1'][$pos] = false;
                    $matchRes = false;
                }
            } else {
                $this->parser->regexpCache['Rx_Text1'][$pos] = false;
                $matchRes = false;
            }
        }
        if ($matchRes) {
            $matchRes['_lineno'] = $this->parser->line;
            $this->parser->pos = $matchRes['_endpos'];
            $this->parser->line += substr_count($matchRes['_text'], "\n");
            $nodeRes['_text'] .= $matchRes['_text'];
            $this->Text_ALL($nodeRes, $matchRes);
            $valid = true;
        } else {
            $valid = false;
        }
        if (!$valid) {
            $this->parser->matchError($error, 'rx', "/([\\S\\s]+(?=([^\\S\\r\\n]\\/\\*!\\*)))|[\\S\\s]+/");
        }
        /*
         * End rule: /([\S\s]+(?=([^\S\r\n]\/\*!\*)))|[\S\s]+/
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Text');
        }
        return $nodeRes;
    }


    public function Text_START (&$nodeRes, $previous)
    {
        $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Text ($this, null);
    }



    public function Text_ALL (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->addText($matchRes['_text']);
    }

    /**
     *
     * Parser rules and action for node 'Parser'
     *
     *  Rule:
     * <node Parser>
     *                 <rule>..Header .._? '<pegparser' _ name:Name '>' attr:Attribute* node:Node* .._? '</pegparser>' .._? End?</rule>
     *                 <action _start>
     *                     {
     *                         $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\PegParser;
     *                     }
     *                 </action>
     *                 <action name>
     *                     {
     *                         $nodeRes['_node']->setName($matchRes['_text']);
     *                     }
     *                 </action>
     *                 <action attr>
     *                     {
     *                         $nodeRes['_node']->addAttribute($matchRes['_node']);
     *                     }
     *                 </action>
     *                 <action node>
     *                     {
     *                         $nodeRes['_node']->addNode($matchRes['_node']);
     *                     }
     *                 </action>
     *             </node>
     * 
     *
    */
    public function matchNodeParser($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->Parser_START($nodeRes, $previous);
        // start sequence
        $backup0 = $nodeRes;
        $pos0 = $this->parser->pos;
        $line0 = $this->parser->line;
        $error0 = $error;
        if ($trace) {
            $this->parser->addBacktrace(array('_s0_', ''));
        }
        do {
            $error = array();
            /*
             * Start rule: ..Header
             *       min: 1 max: 1
             */
            if ($trace) {
                $this->parser->addBacktrace(array('Header', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'Header', $error);
            if ($trace) {
                $remove = array_pop($this->parser->backtrace);
            }
            if ($matchRes) {
                if ($trace) {
                    $this->parser->successNode(array('Header',  $matchRes['_text']));
                }
                if(!isset($nodeRes['Header'])) {
                    $nodeRes['Header'] = $matchRes;
                } else {
                    if (!is_array($nodeRes['Header'])) {
                        $nodeRes['Header'] = array($nodeRes['Header']);
                    }
                    $nodeRes['Header'][] = $matchRes;
                }
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $this->parser->failNode($remove);
                }
            }
            /*
             * End rule: ..Header
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: '<pegparser'
             *       min: 1 max: 1
             */
            if ('<pegparser' == substr($this->parser->source, $this->parser->pos, 10)) {
                $this->parser->pos += 10;
                $nodeRes['_text'] .= '<pegparser';
                if ($trace) {
                    $this->parser->successNode(array('\'<pegparser\'', '<pegparser'));
                }
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', '<pegparser');
                if ($trace) {
                    $this->parser->failNode(array('\'<pegparser\'',  ''));
                }
                $valid = false;
            }
            /*
             * End rule: '<pegparser'
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: _
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                    $nodeRes['_text'] .= ' ';
                    $valid = true;
                } else {
                    $valid = false;
                }
            } else {
                $valid = false;
            }
            if ($valid) {
                if ($trace) {
                    $this->parser->successNode(array("' '",  ' '));
                }
            } else {
                if ($trace) {
                    $this->parser->failNode(array("' '",  ''));
                }
            }
            /*
             * End rule: _
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: name:Name
             *       tag: 'name'
             *       min: 1 max: 1
             */
            if ($trace) {
                $this->parser->addBacktrace(array('Name', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'Name', $error);
            if ($trace) {
                $remove = array_pop($this->parser->backtrace);
            }
            if ($matchRes) {
                if ($trace) {
                    $this->parser->successNode(array('Name',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                $this->Parser_MATCH_name($nodeRes, $matchRes);
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $this->parser->failNode($remove);
                }
            }
            /*
             * End rule: name:Name
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: '>'
             *       min: 1 max: 1
             */
            if ('>' == substr($this->parser->source, $this->parser->pos, 1)) {
                $this->parser->pos += 1;
                $nodeRes['_text'] .= '>';
                if ($trace) {
                    $this->parser->successNode(array('\'>\'', '>'));
                }
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', '>');
                if ($trace) {
                    $this->parser->failNode(array('\'>\'',  ''));
                }
                $valid = false;
            }
            /*
             * End rule: '>'
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: attr:Attribute*
             *       tag: 'attr'
             *       min: 0 max: null
             */
            $iteration7 = 0;
            do {
                if ($trace) {
                    $this->parser->addBacktrace(array('Attribute', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'Attribute', $error);
                if ($trace) {
                    $remove = array_pop($this->parser->backtrace);
                }
                if ($matchRes) {
                    if ($trace) {
                        $this->parser->successNode(array('Attribute',  $matchRes['_text']));
                    }
                    $nodeRes['_text'] .= $matchRes['_text'];
                    $this->Parser_MATCH_attr($nodeRes, $matchRes);
                    $valid = true;
                } else {
                    $valid = false;
                    if ($trace) {
                        $this->parser->failNode($remove);
                    }
                }
                $iteration7 = $valid ? ($iteration7 + 1) : $iteration7;
                if (!$valid && $iteration7 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) break;
            } while (true);
            /*
             * End rule: attr:Attribute*
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: node:Node*
             *       tag: 'node'
             *       min: 0 max: null
             */
            $iteration8 = 0;
            do {
                if ($trace) {
                    $this->parser->addBacktrace(array('Node', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'Node', $error);
                if ($trace) {
                    $remove = array_pop($this->parser->backtrace);
                }
                if ($matchRes) {
                    if ($trace) {
                        $this->parser->successNode(array('Node',  $matchRes['_text']));
                    }
                    $nodeRes['_text'] .= $matchRes['_text'];
                    $this->Parser_MATCH_node($nodeRes, $matchRes);
                    $valid = true;
                } else {
                    $valid = false;
                    if ($trace) {
                        $this->parser->failNode($remove);
                    }
                }
                $iteration8 = $valid ? ($iteration8 + 1) : $iteration8;
                if (!$valid && $iteration8 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) break;
            } while (true);
            /*
             * End rule: node:Node*
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: '</pegparser>'
             *       min: 1 max: 1
             */
            if ('</pegparser>' == substr($this->parser->source, $this->parser->pos, 12)) {
                $this->parser->pos += 12;
                $nodeRes['_text'] .= '</pegparser>';
                if ($trace) {
                    $this->parser->successNode(array('\'</pegparser>\'', '</pegparser>'));
                }
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', '</pegparser>');
                if ($trace) {
                    $this->parser->failNode(array('\'</pegparser>\'',  ''));
                }
                $valid = false;
            }
            /*
             * End rule: '</pegparser>'
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: End?
             *       min: 0 max: 1
             */
            $error = array();
            if ($trace) {
                $this->parser->addBacktrace(array('End', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'End', $error);
            if ($trace) {
                $remove = array_pop($this->parser->backtrace);
            }
            if ($matchRes) {
                if ($trace) {
                    $this->parser->successNode(array('End',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                if(!isset($nodeRes['End'])) {
                    $nodeRes['End'] = $matchRes;
                } else {
                    if (!is_array($nodeRes['End'])) {
                        $nodeRes['End'] = array($nodeRes['End']);
                    }
                    $nodeRes['End'][] = $matchRes;
                }
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $this->parser->failNode($remove);
                }
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, 'End', $error);
            }
            $valid = true;
            /*
             * End rule: End?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            break;
        } while (true);
        if ($trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if (!$valid) {
            if ($trace) {
                $this->parser->failNode($remove);
            }
            $this->parser->pos = $pos0;
            $this->parser->line = $line0;
            $nodeRes = $backup0;
        } elseif ($trace) {
            $this->parser->successNode($remove);
        }
        $error = $error0;
        unset($backup0);
        // end sequence
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Parser');
        }
        return $nodeRes;
    }


    public function Parser_START (&$nodeRes, $previous)
    {
        $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\PegParser;
    }



    public function Parser_MATCH_name (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setName($matchRes['_text']);
    }



    public function Parser_MATCH_attr (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->addAttribute($matchRes['_node']);
    }



    public function Parser_MATCH_node (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->addNode($matchRes['_node']);
    }

    /**
     *
     * Parser rules and action for node 'Name'
     *
     *  Rule:
     * <node Name>
     *                 <rule>/\w+/</rule>
     *             </node>
     * 
     *
    */
    public function matchNodeName($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        /*
         * Start rule: /\w+/
         *       min: 1 max: 1
         */
        $regexp = "/\\w+/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Rx_Name1'][$pos])) {
            $matchRes = $this->parser->regexpCache['Rx_Name1'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                if ($matchRes['_startpos'] != $pos) {
                    $this->parser->regexpCache['Rx_Name1'][$matchRes['_startpos']] = $matchRes;
                    $this->parser->regexpCache['Rx_Name1'][$pos] = false;
                    $matchRes = false;
                }
            } else {
                $this->parser->regexpCache['Rx_Name1'][$pos] = false;
                $matchRes = false;
            }
        }
        if ($matchRes) {
            $matchRes['_lineno'] = $this->parser->line;
            $this->parser->pos = $matchRes['_endpos'];
            $this->parser->line += substr_count($matchRes['_text'], "\n");
            $nodeRes['_text'] .= $matchRes['_text'];
            $valid = true;
        } else {
            $valid = false;
        }
        if (!$valid) {
            $this->parser->matchError($error, 'rx', "/\\w+/");
        }
        /*
         * End rule: /\w+/
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Name');
        }
        return $nodeRes;
    }
    /**
     *
     * Parser rules and action for node 'Header'
     *
     *  Rule:
     * <node Header>
     *                 <rule>/\s*\/\*!\* /</rule>
     *             </node>
     * 
     *
    */
    public function matchNodeHeader($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        /*
         * Start rule: /\s*\/\*!\* /
         *       min: 1 max: 1
         */
        $regexp = "/\\s*\\/\\*!\\* /";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Rx_Header1'][$pos])) {
            $matchRes = $this->parser->regexpCache['Rx_Header1'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                if ($matchRes['_startpos'] != $pos) {
                    $this->parser->regexpCache['Rx_Header1'][$matchRes['_startpos']] = $matchRes;
                    $this->parser->regexpCache['Rx_Header1'][$pos] = false;
                    $matchRes = false;
                }
            } else {
                $this->parser->regexpCache['Rx_Header1'][$pos] = false;
                $matchRes = false;
            }
        }
        if ($matchRes) {
            $matchRes['_lineno'] = $this->parser->line;
            $this->parser->pos = $matchRes['_endpos'];
            $this->parser->line += substr_count($matchRes['_text'], "\n");
            $nodeRes['_text'] .= $matchRes['_text'];
            $valid = true;
        } else {
            $valid = false;
        }
        if (!$valid) {
            $this->parser->matchError($error, 'rx', "/\\s*\\/\\*!\\* /");
        }
        /*
         * End rule: /\s*\/\*!\* /
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Header');
        }
        return $nodeRes;
    }
    /**
     *
     * Parser rules and action for node 'End'
     *
     *  Rule:
     * <node End>
     *                 <rule>./\s*\*\//</rule>
     *             </node>
     * 
     *
    */
    public function matchNodeEnd($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        /*
         * Start rule: ./\s*\*\//
         *       min: 1 max: 1
         */
        $regexp = "/\\s*\\*\\//";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Rx_End1'][$pos])) {
            $matchRes = $this->parser->regexpCache['Rx_End1'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                if ($matchRes['_startpos'] != $pos) {
                    $this->parser->regexpCache['Rx_End1'][$matchRes['_startpos']] = $matchRes;
                    $this->parser->regexpCache['Rx_End1'][$pos] = false;
                    $matchRes = false;
                }
            } else {
                $this->parser->regexpCache['Rx_End1'][$pos] = false;
                $matchRes = false;
            }
        }
        if ($matchRes) {
            $matchRes['_lineno'] = $this->parser->line;
            $this->parser->pos = $matchRes['_endpos'];
            $this->parser->line += substr_count($matchRes['_text'], "\n");
            $valid = true;
        } else {
            $valid = false;
        }
        if (!$valid) {
            $this->parser->matchError($error, 'rx', "/\\s*\\*\\//");
        }
        /*
         * End rule: ./\s*\*\//
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'End');
        }
        return $nodeRes;
    }
    /**
     *
     * Parser rules and action for node 'Comment'
     *
     *  Rule:
     * <node Comment>
     *                 <rule>/[\s\t]*(([#][^\r\n]*)?([\r\n]+[\s\t]*))* /</rule>
     *             </node>
     * 
     *
    */
    public function matchNodeComment($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        /*
         * Start rule: /[\s\t]*(([#][^\r\n]*)?([\r\n]+[\s\t]*))* /
         *       min: 1 max: 1
         */
        $regexp = "/[\\s\\t]*(([#][^\\r\\n]*)?([\\r\\n]+[\\s\\t]*))* /";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Rx_Comment1'][$pos])) {
            $matchRes = $this->parser->regexpCache['Rx_Comment1'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                if ($matchRes['_startpos'] != $pos) {
                    $this->parser->regexpCache['Rx_Comment1'][$matchRes['_startpos']] = $matchRes;
                    $this->parser->regexpCache['Rx_Comment1'][$pos] = false;
                    $matchRes = false;
                }
            } else {
                $this->parser->regexpCache['Rx_Comment1'][$pos] = false;
                $matchRes = false;
            }
        }
        if ($matchRes) {
            $matchRes['_lineno'] = $this->parser->line;
            $this->parser->pos = $matchRes['_endpos'];
            $this->parser->line += substr_count($matchRes['_text'], "\n");
            $nodeRes['_text'] .= $matchRes['_text'];
            $valid = true;
        } else {
            $valid = false;
        }
        if (!$valid) {
            $this->parser->matchError($error, 'rx', "/[\\s\\t]*(([#][^\\r\\n]*)?([\\r\\n]+[\\s\\t]*))* /");
        }
        /*
         * End rule: /[\s\t]*(([#][^\r\n]*)?([\r\n]+[\s\t]*))* /
         */
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Comment');
        }
        return $nodeRes;
    }
    /**
     *
     * Parser rules and action for node 'attrvalue'
     *
     *  Rule:
     * <node attrvalue>
     *                 <rule> .._? ( /(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|("[^"]*")|\d+|\w+))/ | ( '(' sub:attr ')' ) )</rule>
     *                 <action sub> {
     *                         $nodeRes['value'] = $matchRes['_attr'];
     *                     }
     *                 </action>
     *                 <action _finish>
     *                     {
     *                         $mr = $nodeRes['_pregMatch'];
     *                         if (isset($mr['v1']) && !empty($mr['v1'])) {
     *                             $nodeRes['value'] = trim($mr['v1'], "'\"");
     *                         }
     *                         if (isset($mr['true']) && !empty($mr['true'])) {
     *                             $nodeRes['value'] = true;
     *                         }
     *                         if (isset($mr['false']) && !empty($mr['false'])) {
     *                             $nodeRes['value'] = false;
     *                         }
     *                         if (isset($mr['null']) && !empty($mr['null'])) {
     *                             $nodeRes['value'] = null;
     *                         }
     *                         $nodeRes['_pregMatch'] = array();
     *                     }
     *                 </action>
     *             </node>
     * 
     *
    */
    public function matchNodeattrvalue($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        // start sequence
        $backup0 = $nodeRes;
        $pos0 = $this->parser->pos;
        $line0 = $this->parser->line;
        $error0 = $error;
        if ($trace) {
            $this->parser->addBacktrace(array('_s0_', ''));
        }
        do {
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: (/(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|("[^"]*")|\d+|\w+))/ | ('(' sub:attr ')'))
             *       min: 1 max: 1
             */
            // start option
            $error3 = $error;
            $errorOption3 =array();
            if ($trace) {
                $this->parser->addBacktrace(array('_o3_', ''));
            }
            do {
                $error = array();
                array_pop($this->parser->backtrace);
                if ($trace) {
                    $this->parser->addBacktrace(array('_o3:1_', ''));
                }
                /*
                 * Start rule: /(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|("[^"]*")|\d+|\w+))/
                 *       min: 1 max: 1
                 */
                $regexp = "/(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|(\"[^\"]*\")|\\d+|\\w+))/";
                $pos = $this->parser->pos;
                if (isset($this->parser->regexpCache['Rx_attrvalue5'][$pos])) {
                    $matchRes = $this->parser->regexpCache['Rx_attrvalue5'][$pos];
                } else {
                    if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                        if (strlen($pregMatch[0][0]) != 0) {
                            $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                            foreach ($pregMatch as $n => $v) {
                                if (is_string($n) && strlen($v[0])) {
                                    $matchRes['_pregMatch'][$n] = $v[0];
                                }
                            }
                            if ($matchRes['_startpos'] != $pos) {
                                $this->parser->regexpCache['Rx_attrvalue5'][$matchRes['_startpos']] = $matchRes;
                                $this->parser->regexpCache['Rx_attrvalue5'][$pos] = false;
                                $matchRes = false;
                            }
                        } else {
                            $this->parser->regexpCache['Rx_attrvalue5'][$pos] = false;
                            $matchRes = false;
                        }
                    } else {
                        $this->parser->regexpCache['Rx_attrvalue5'][$pos] = false;
                        $matchRes = false;
                    }
                }
                if ($matchRes) {
                    $matchRes['_lineno'] = $this->parser->line;
                    $this->parser->pos = $matchRes['_endpos'];
                    $this->parser->line += substr_count($matchRes['_text'], "\n");
                    $nodeRes['_text'] .= $matchRes['_text'];
                    $nodeRes['_pregMatch'] = array_merge($nodeRes['_pregMatch'], $matchRes['_pregMatch']);
                    $valid = true;
                } else {
                    $valid = false;
                }
                if (!$valid) {
                    $this->parser->matchError($error, 'rx', "/(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|(\"[^\"]*\")|\\d+|\\w+))/");
                }
                /*
                 * End rule: /(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|("[^"]*")|\d+|\w+))/
                 */
                if ($valid) {
                    if ($trace) {
                        $this->parser->successNode(array_pop($this->parser->backtrace));
                    }
                    $error = $error3;
                    break;
                } else {
                    $this->parser->logOption($errorOption3, '', $error);
                }
                $error = array();
                array_pop($this->parser->backtrace);
                if ($trace) {
                    $this->parser->addBacktrace(array('_o3:2_', ''));
                }
                /*
                 * Start rule: ('(' sub:attr ')')
                 *       min: 1 max: 1
                 */
                // start sequence
                $backup7 = $nodeRes;
                $pos7 = $this->parser->pos;
                $line7 = $this->parser->line;
                $error7 = $error;
                if ($trace) {
                    $this->parser->addBacktrace(array('_s7_', ''));
                }
                do {
                    $error = array();
                    /*
                     * Start rule: '('
                     *       min: 1 max: 1
                     */
                    if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $nodeRes['_text'] .= '(';
                        if ($trace) {
                            $this->parser->successNode(array('\'(\'', '('));
                        }
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', '(');
                        if ($trace) {
                            $this->parser->failNode(array('\'(\'',  ''));
                        }
                        $valid = false;
                    }
                    /*
                     * End rule: '('
                     */
                    if (!$valid) {
                        $this->parser->matchError($error7, 'SequenceElement', $error);
                        $error = $error7;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: sub:attr
                     *       tag: 'sub'
                     *       min: 1 max: 1
                     */
                    if ($trace) {
                        $this->parser->addBacktrace(array('attr', ''));
                    }
                    $matchRes = $this->parser->matchRule($nodeRes, 'attr', $error);
                    if ($trace) {
                        $remove = array_pop($this->parser->backtrace);
                    }
                    if ($matchRes) {
                        if ($trace) {
                            $this->parser->successNode(array('attr',  $matchRes['_text']));
                        }
                        $nodeRes['_text'] .= $matchRes['_text'];
                        $this->attrvalue_MATCH_sub($nodeRes, $matchRes);
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $this->parser->failNode($remove);
                        }
                    }
                    /*
                     * End rule: sub:attr
                     */
                    if (!$valid) {
                        $this->parser->matchError($error7, 'SequenceElement', $error);
                        $error = $error7;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: ')'
                     *       min: 1 max: 1
                     */
                    if (')' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $nodeRes['_text'] .= ')';
                        if ($trace) {
                            $this->parser->successNode(array('\')\'', ')'));
                        }
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', ')');
                        if ($trace) {
                            $this->parser->failNode(array('\')\'',  ''));
                        }
                        $valid = false;
                    }
                    /*
                     * End rule: ')'
                     */
                    if (!$valid) {
                        $this->parser->matchError($error7, 'SequenceElement', $error);
                        $error = $error7;
                        break;
                    }
                    break;
                } while (true);
                if ($trace) {
                    $remove = array_pop($this->parser->backtrace);
                }
                if (!$valid) {
                    if ($trace) {
                        $this->parser->failNode($remove);
                    }
                    $this->parser->pos = $pos7;
                    $this->parser->line = $line7;
                    $nodeRes = $backup7;
                } elseif ($trace) {
                    $this->parser->successNode($remove);
                }
                $error = $error7;
                unset($backup7);
                // end sequence
                /*
                 * End rule: ('(' sub:attr ')')
                 */
                if ($valid) {
                    if ($trace) {
                        $this->parser->successNode(array_pop($this->parser->backtrace));
                    }
                    $error = $error3;
                    break;
                } else {
                    $this->parser->logOption($errorOption3, 'Sequence', $error);
                }
                $error = $error3;
                array_pop($this->parser->backtrace);
                break;
            } while (true);
            // end option
            /*
             * End rule: (/(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|("[^"]*")|\d+|\w+))/ | ('(' sub:attr ')'))
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            break;
        } while (true);
        if ($trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if (!$valid) {
            if ($trace) {
                $this->parser->failNode($remove);
            }
            $this->parser->pos = $pos0;
            $this->parser->line = $line0;
            $nodeRes = $backup0;
        } elseif ($trace) {
            $this->parser->successNode($remove);
        }
        $error = $error0;
        unset($backup0);
        // end sequence
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
            $this->attrvalue_FINISH($nodeRes);
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'attrvalue');
        }
        return $nodeRes;
    }


    public function attrvalue_MATCH_sub (&$nodeRes, $matchRes)
    {
        $nodeRes['value'] = $matchRes['_attr'];
    }



    public function attrvalue_FINISH (&$nodeRes)
    {
        $mr = $nodeRes['_pregMatch'];
        if (isset($mr['v1']) && !empty($mr['v1']))        {
            $nodeRes['value'] = trim($mr['v1'], "'\"");
        }
        if (isset($mr['true']) && !empty($mr['true']))        {
            $nodeRes['value'] = true;
        }
        if (isset($mr['false']) && !empty($mr['false']))        {
            $nodeRes['value'] = false;
        }
        if (isset($mr['null']) && !empty($mr['null']))        {
            $nodeRes['value'] = null;
        }
        $nodeRes['_pregMatch'] = array();
    }

    /**
     *
     * Parser rules and action for node 'AttrEntry'
     *
     *  Rule:
     * <node AttrEntry>
     *                 <rule> .._? key:Name .._? ( '=' .._? val:attrvalue)? </rule>
     *                 <action key>
     *                 {
     *                     $nodeRes['key'] = $matchRes['_text'];
     *                     $nodeRes['value'] = array($nodeRes['key'] => true);
     *                 }
     *                 </action>
     *                 <action val>
     *                 {
     *                     $nodeRes['value'][$nodeRes['key']] = $matchRes['value'];
     *                 }
     *                 </action>
     *              </node>
     * 
     *
    */
    public function matchNodeAttrEntry($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        // start sequence
        $backup0 = $nodeRes;
        $pos0 = $this->parser->pos;
        $line0 = $this->parser->line;
        $error0 = $error;
        if ($trace) {
            $this->parser->addBacktrace(array('_s0_', ''));
        }
        do {
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: key:Name
             *       tag: 'key'
             *       min: 1 max: 1
             */
            if ($trace) {
                $this->parser->addBacktrace(array('Name', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'Name', $error);
            if ($trace) {
                $remove = array_pop($this->parser->backtrace);
            }
            if ($matchRes) {
                if ($trace) {
                    $this->parser->successNode(array('Name',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                $this->AttrEntry_MATCH_key($nodeRes, $matchRes);
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $this->parser->failNode($remove);
                }
            }
            /*
             * End rule: key:Name
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: ('=' .._? val:attrvalue)?
             *       min: 0 max: 1
             */
            $error = array();
            // start sequence
            $backup5 = $nodeRes;
            $pos5 = $this->parser->pos;
            $line5 = $this->parser->line;
            $error5 = $error;
            if ($trace) {
                $this->parser->addBacktrace(array('_s5_', ''));
            }
            do {
                $error = array();
                /*
                 * Start rule: '='
                 *       min: 1 max: 1
                 */
                if ('=' == substr($this->parser->source, $this->parser->pos, 1)) {
                    $this->parser->pos += 1;
                    $nodeRes['_text'] .= '=';
                    if ($trace) {
                        $this->parser->successNode(array('\'=\'', '='));
                    }
                    $valid = true;
                } else {
                    $this->parser->matchError($error, 'literal', '=');
                    if ($trace) {
                        $this->parser->failNode(array('\'=\'',  ''));
                    }
                    $valid = false;
                }
                /*
                 * End rule: '='
                 */
                if (!$valid) {
                    $this->parser->matchError($error5, 'SequenceElement', $error);
                    $error = $error5;
                    break;
                }
                $error = array();
                /*
                 * Start rule: .._?
                 *       min: 1 max: 1
                 */
                if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                    if (!empty($pregMatch[0])) {
                        $this->parser->pos += strlen($pregMatch[0]);
                        $this->parser->line += substr_count($pregMatch[0], "\n");
                    }
                }
                if ($trace) {
                    $this->parser->successNode(array("' '",  $pregMatch[0]));
                }
                $valid = true;
                /*
                 * End rule: .._?
                 */
                if (!$valid) {
                    $this->parser->matchError($error5, 'SequenceElement', $error);
                    $error = $error5;
                    break;
                }
                $error = array();
                /*
                 * Start rule: val:attrvalue
                 *       tag: 'val'
                 *       min: 1 max: 1
                 */
                if ($trace) {
                    $this->parser->addBacktrace(array('attrvalue', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'attrvalue', $error);
                if ($trace) {
                    $remove = array_pop($this->parser->backtrace);
                }
                if ($matchRes) {
                    if ($trace) {
                        $this->parser->successNode(array('attrvalue',  $matchRes['_text']));
                    }
                    $nodeRes['_text'] .= $matchRes['_text'];
                    $this->AttrEntry_MATCH_val($nodeRes, $matchRes);
                    $valid = true;
                } else {
                    $valid = false;
                    if ($trace) {
                        $this->parser->failNode($remove);
                    }
                }
                /*
                 * End rule: val:attrvalue
                 */
                if (!$valid) {
                    $this->parser->matchError($error5, 'SequenceElement', $error);
                    $error = $error5;
                    break;
                }
                break;
            } while (true);
            if ($trace) {
                $remove = array_pop($this->parser->backtrace);
            }
            if (!$valid) {
                if ($trace) {
                    $this->parser->failNode($remove);
                }
                $this->parser->pos = $pos5;
                $this->parser->line = $line5;
                $nodeRes = $backup5;
            } elseif ($trace) {
                $this->parser->successNode($remove);
            }
            $error = $error5;
            unset($backup5);
            // end sequence
            if (!$valid) {
                $this->parser->logOption($errorResult, 'Sequence', $error);
            }
            $valid = true;
            /*
             * End rule: ('=' .._? val:attrvalue)?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            break;
        } while (true);
        if ($trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if (!$valid) {
            if ($trace) {
                $this->parser->failNode($remove);
            }
            $this->parser->pos = $pos0;
            $this->parser->line = $line0;
            $nodeRes = $backup0;
        } elseif ($trace) {
            $this->parser->successNode($remove);
        }
        $error = $error0;
        unset($backup0);
        // end sequence
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'AttrEntry');
        }
        return $nodeRes;
    }


    public function AttrEntry_MATCH_key (&$nodeRes, $matchRes)
    {
        $nodeRes['key'] = $matchRes['_text'];
        $nodeRes['value'] = array($nodeRes['key'] => true);
    }



    public function AttrEntry_MATCH_val (&$nodeRes, $matchRes)
    {
        $nodeRes['value'][$nodeRes['key']] = $matchRes['value'];
    }

    /**
     *
     * Parser rules and action for node 'Attribute'
     *
     *  Rule:
     * <node Attribute>
     *                 <attribute>importNode</attribute>
     *                 <rule>.._? '<attribute>' attr:AttrEntry (',' attr:AttrEntry)* '</attribute>' .._?</rule>
     *                 <action _start>
     *                     {
     *                         $nodeRes['_previousNode'] = $previous['_node'];
     *                     }
     *                 </action>
     *                 <action attr>
     *                     {
     *                         $nodeRes['_previousNode']->addAttribute($matchRes['value']);
     *                     }
     *                 </action>
     *             </node>
     * 
     *
    */
    public function matchNodeAttribute($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->Attribute_START($nodeRes, $previous);
        // start sequence
        $backup0 = $nodeRes;
        $pos0 = $this->parser->pos;
        $line0 = $this->parser->line;
        $error0 = $error;
        if ($trace) {
            $this->parser->addBacktrace(array('_s0_', ''));
        }
        do {
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: '<attribute>'
             *       min: 1 max: 1
             */
            if ('<attribute>' == substr($this->parser->source, $this->parser->pos, 11)) {
                $this->parser->pos += 11;
                $nodeRes['_text'] .= '<attribute>';
                if ($trace) {
                    $this->parser->successNode(array('\'<attribute>\'', '<attribute>'));
                }
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', '<attribute>');
                if ($trace) {
                    $this->parser->failNode(array('\'<attribute>\'',  ''));
                }
                $valid = false;
            }
            /*
             * End rule: '<attribute>'
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: attr:AttrEntry
             *       tag: 'attr'
             *       min: 1 max: 1
             */
            if ($trace) {
                $this->parser->addBacktrace(array('AttrEntry', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'AttrEntry', $error);
            if ($trace) {
                $remove = array_pop($this->parser->backtrace);
            }
            if ($matchRes) {
                if ($trace) {
                    $this->parser->successNode(array('AttrEntry',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                $this->Attribute_MATCH_attr($nodeRes, $matchRes);
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $this->parser->failNode($remove);
                }
            }
            /*
             * End rule: attr:AttrEntry
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: (',' attr:AttrEntry)*
             *       min: 0 max: null
             */
            $iteration4 = 0;
            do {
                // start sequence
                $backup5 = $nodeRes;
                $pos5 = $this->parser->pos;
                $line5 = $this->parser->line;
                $error5 = $error;
                if ($trace) {
                    $this->parser->addBacktrace(array('_s5_', ''));
                }
                do {
                    $error = array();
                    /*
                     * Start rule: ','
                     *       min: 1 max: 1
                     */
                    if (',' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $nodeRes['_text'] .= ',';
                        if ($trace) {
                            $this->parser->successNode(array('\',\'', ','));
                        }
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', ',');
                        if ($trace) {
                            $this->parser->failNode(array('\',\'',  ''));
                        }
                        $valid = false;
                    }
                    /*
                     * End rule: ','
                     */
                    if (!$valid) {
                        $this->parser->matchError($error5, 'SequenceElement', $error);
                        $error = $error5;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: attr:AttrEntry
                     *       tag: 'attr'
                     *       min: 1 max: 1
                     */
                    if ($trace) {
                        $this->parser->addBacktrace(array('AttrEntry', ''));
                    }
                    $matchRes = $this->parser->matchRule($nodeRes, 'AttrEntry', $error);
                    if ($trace) {
                        $remove = array_pop($this->parser->backtrace);
                    }
                    if ($matchRes) {
                        if ($trace) {
                            $this->parser->successNode(array('AttrEntry',  $matchRes['_text']));
                        }
                        $nodeRes['_text'] .= $matchRes['_text'];
                        $this->Attribute_MATCH_attr($nodeRes, $matchRes);
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $this->parser->failNode($remove);
                        }
                    }
                    /*
                     * End rule: attr:AttrEntry
                     */
                    if (!$valid) {
                        $this->parser->matchError($error5, 'SequenceElement', $error);
                        $error = $error5;
                        break;
                    }
                    break;
                } while (true);
                if ($trace) {
                    $remove = array_pop($this->parser->backtrace);
                }
                if (!$valid) {
                    if ($trace) {
                        $this->parser->failNode($remove);
                    }
                    $this->parser->pos = $pos5;
                    $this->parser->line = $line5;
                    $nodeRes = $backup5;
                } elseif ($trace) {
                    $this->parser->successNode($remove);
                }
                $error = $error5;
                unset($backup5);
                // end sequence
                $iteration4 = $valid ? ($iteration4 + 1) : $iteration4;
                if (!$valid && $iteration4 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) break;
            } while (true);
            /*
             * End rule: (',' attr:AttrEntry)*
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: '</attribute>'
             *       min: 1 max: 1
             */
            if ('</attribute>' == substr($this->parser->source, $this->parser->pos, 12)) {
                $this->parser->pos += 12;
                $nodeRes['_text'] .= '</attribute>';
                if ($trace) {
                    $this->parser->successNode(array('\'</attribute>\'', '</attribute>'));
                }
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', '</attribute>');
                if ($trace) {
                    $this->parser->failNode(array('\'</attribute>\'',  ''));
                }
                $valid = false;
            }
            /*
             * End rule: '</attribute>'
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            break;
        } while (true);
        if ($trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if (!$valid) {
            if ($trace) {
                $this->parser->failNode($remove);
            }
            $this->parser->pos = $pos0;
            $this->parser->line = $line0;
            $nodeRes = $backup0;
        } elseif ($trace) {
            $this->parser->successNode($remove);
        }
        $error = $error0;
        unset($backup0);
        // end sequence
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Attribute');
        }
        return $nodeRes;
    }


    public function Attribute_START (&$nodeRes, $previous)
    {
        $nodeRes['_previousNode'] = $previous['_node'];
    }



    public function Attribute_MATCH_attr (&$nodeRes, $matchRes)
    {
        $nodeRes['_previousNode']->addAttribute($matchRes['value']);
    }

    /**
     *
     * Parser rules and action for node 'Node'
     *
     *  Rule:
     * <node Node>
     *                 <rule>.._?  instance:/\s*\<(?<type>(node|token))\s+(?<nodeName>[a-zA-Z_0-9]+)\>/  Attribute* Rule .Action* /<\/(node|token)>/ .._?</rule>
     *                 <action _start>
     *                     {
     *                         $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Node;
     *                         $regexp = substr($this->parser->whitespacePattern, 0, strlen($this->parser->whitespacePattern) -1);
     *                         $regexp .= '\s*\<(node|token)\s+[a-zA-Z_]+\>[\s\S]*?\<\/(node|token)\>[\s\S]*?[\n]/';
     *                         if (preg_match($regexp, $this->source, $match, 0, $this->pos )) {
     *                             $nodeRes['definition'] = $match[0];
     *                         }
     *                     }
     *                 </action>
     *                 <action instance>
     *                     {
     *                         $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Node;
     *                         $nodeRes['_node']->setDefinition($nodeRes['definition']);
     *                     }
     *                 </action>
     *                 <action type>
     *                  {
     *                         $nodeRes['_node']->setType($matchRes['_pregMatch']['type']);
     *                  }
     *                 </action>
     *                 <action nodeName>
     *                     {
     *                         $nodeRes['_node']->setName($matchRes['_pregMatch']['nodeName']);
     *                     }
     *                 </action>
     *             </node>
     * 
     *
    */
    public function matchNodeNode($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->Node_START($nodeRes, $previous);
        // start sequence
        $backup0 = $nodeRes;
        $pos0 = $this->parser->pos;
        $line0 = $this->parser->line;
        $error0 = $error;
        if ($trace) {
            $this->parser->addBacktrace(array('_s0_', ''));
        }
        do {
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: instance:/\s*\<(?<type>(node|token))\s+(?<nodeName>[a-zA-Z_0-9]+)\>/
             *       tag: 'instance'
             *       min: 1 max: 1
             */
            $regexp = "/\\s*\\<(?<type>(node|token))\\s+(?<nodeName>[a-zA-Z_0-9]+)\\>/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['Rx_Node3'][$pos])) {
                $matchRes = $this->parser->regexpCache['Rx_Node3'][$pos];
            } else {
                if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                    if (strlen($pregMatch[0][0]) != 0) {
                        $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                        foreach ($pregMatch as $n => $v) {
                            if (is_string($n) && strlen($v[0])) {
                                $matchRes['_pregMatch'][$n] = $v[0];
                            }
                        }
                        if ($matchRes['_startpos'] != $pos) {
                            $this->parser->regexpCache['Rx_Node3'][$matchRes['_startpos']] = $matchRes;
                            $this->parser->regexpCache['Rx_Node3'][$pos] = false;
                            $matchRes = false;
                        }
                    } else {
                        $this->parser->regexpCache['Rx_Node3'][$pos] = false;
                        $matchRes = false;
                    }
                } else {
                    $this->parser->regexpCache['Rx_Node3'][$pos] = false;
                    $matchRes = false;
                }
            }
            if ($matchRes) {
                $matchRes['_lineno'] = $this->parser->line;
                $this->parser->pos = $matchRes['_endpos'];
                $this->parser->line += substr_count($matchRes['_text'], "\n");
                $nodeRes['_text'] .= $matchRes['_text'];
                $this->Node_MATCH_instance($nodeRes, $matchRes);
                if (isset($matchRes['_pregMatch']['type'])) {
                    $this->Node_MATCH_type($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['type']);
                }
                if (isset($matchRes['_pregMatch']['nodeName'])) {
                    $this->Node_MATCH_nodeName($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['nodeName']);
                }
                $nodeRes['_pregMatch'] = array_merge($nodeRes['_pregMatch'], $matchRes['_pregMatch']);
                $valid = true;
            } else {
                $valid = false;
            }
            if (!$valid) {
                $this->parser->matchError($error, 'rx', "/\\s*\\<(?<type>(node|token))\\s+(?<nodeName>[a-zA-Z_0-9]+)\\>/");
            }
            /*
             * End rule: instance:/\s*\<(?<type>(node|token))\s+(?<nodeName>[a-zA-Z_0-9]+)\>/
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: Attribute*
             *       min: 0 max: null
             */
            $iteration4 = 0;
            do {
                if ($trace) {
                    $this->parser->addBacktrace(array('Attribute', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'Attribute', $error);
                if ($trace) {
                    $remove = array_pop($this->parser->backtrace);
                }
                if ($matchRes) {
                    if ($trace) {
                        $this->parser->successNode(array('Attribute',  $matchRes['_text']));
                    }
                    $nodeRes['_text'] .= $matchRes['_text'];
                    if(!isset($nodeRes['Attribute'])) {
                        $nodeRes['Attribute'] = $matchRes;
                    } else {
                        if (!is_array($nodeRes['Attribute'])) {
                            $nodeRes['Attribute'] = array($nodeRes['Attribute']);
                        }
                        $nodeRes['Attribute'][] = $matchRes;
                    }
                    $valid = true;
                } else {
                    $valid = false;
                    if ($trace) {
                        $this->parser->failNode($remove);
                    }
                }
                $iteration4 = $valid ? ($iteration4 + 1) : $iteration4;
                if (!$valid && $iteration4 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) break;
            } while (true);
            /*
             * End rule: Attribute*
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: Rule
             *       min: 1 max: 1
             */
            if ($trace) {
                $this->parser->addBacktrace(array('Rule', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'Rule', $error);
            if ($trace) {
                $remove = array_pop($this->parser->backtrace);
            }
            if ($matchRes) {
                if ($trace) {
                    $this->parser->successNode(array('Rule',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                if(!isset($nodeRes['Rule'])) {
                    $nodeRes['Rule'] = $matchRes;
                } else {
                    if (!is_array($nodeRes['Rule'])) {
                        $nodeRes['Rule'] = array($nodeRes['Rule']);
                    }
                    $nodeRes['Rule'][] = $matchRes;
                }
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $this->parser->failNode($remove);
                }
            }
            /*
             * End rule: Rule
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .Action*
             *       min: 0 max: null
             */
            $iteration6 = 0;
            do {
                if ($trace) {
                    $this->parser->addBacktrace(array('Action', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'Action', $error);
                if ($trace) {
                    $remove = array_pop($this->parser->backtrace);
                }
                if ($matchRes) {
                    if ($trace) {
                        $this->parser->successNode(array('Action',  $matchRes['_text']));
                    }
                    if(!isset($nodeRes['Action'])) {
                        $nodeRes['Action'] = $matchRes;
                    } else {
                        if (!is_array($nodeRes['Action'])) {
                            $nodeRes['Action'] = array($nodeRes['Action']);
                        }
                        $nodeRes['Action'][] = $matchRes;
                    }
                    $valid = true;
                } else {
                    $valid = false;
                    if ($trace) {
                        $this->parser->failNode($remove);
                    }
                }
                $iteration6 = $valid ? ($iteration6 + 1) : $iteration6;
                if (!$valid && $iteration6 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) break;
            } while (true);
            /*
             * End rule: .Action*
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: /<\/(node|token)>/
             *       min: 1 max: 1
             */
            $regexp = "/<\\/(node|token)>/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['Rx_Node8'][$pos])) {
                $matchRes = $this->parser->regexpCache['Rx_Node8'][$pos];
            } else {
                if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                    $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                    if ($matchRes['_startpos'] != $pos) {
                        $this->parser->regexpCache['Rx_Node8'][$matchRes['_startpos']] = $matchRes;
                        $this->parser->regexpCache['Rx_Node8'][$pos] = false;
                        $matchRes = false;
                    }
                } else {
                    $this->parser->regexpCache['Rx_Node8'][$pos] = false;
                    $matchRes = false;
                }
            }
            if ($matchRes) {
                $matchRes['_lineno'] = $this->parser->line;
                $this->parser->pos = $matchRes['_endpos'];
                $this->parser->line += substr_count($matchRes['_text'], "\n");
                $nodeRes['_text'] .= $matchRes['_text'];
                $valid = true;
            } else {
                $valid = false;
            }
            if (!$valid) {
                $this->parser->matchError($error, 'rx', "/<\\/(node|token)>/");
            }
            /*
             * End rule: /<\/(node|token)>/
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            break;
        } while (true);
        if ($trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if (!$valid) {
            if ($trace) {
                $this->parser->failNode($remove);
            }
            $this->parser->pos = $pos0;
            $this->parser->line = $line0;
            $nodeRes = $backup0;
        } elseif ($trace) {
            $this->parser->successNode($remove);
        }
        $error = $error0;
        unset($backup0);
        // end sequence
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Node');
        }
        return $nodeRes;
    }


    public function Node_START (&$nodeRes, $previous)
    {
        $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Node;
        $regexp = substr($this->parser->whitespacePattern, 0, strlen($this->parser->whitespacePattern) -1);
        $regexp .= '\s*\<(node|token)\s+[a-zA-Z_]+\>[\s\S]*?\<\/(node|token)\>[\s\S]*?[\n]/';
        if (preg_match($regexp, $this->source, $match, 0, $this->pos ))        {
            $nodeRes['definition'] = $match[0];
        }
    }



    public function Node_MATCH_instance (&$nodeRes, $matchRes)
    {
        $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Node;
        $nodeRes['_node']->setDefinition($nodeRes['definition']);
    }



    public function Node_MATCH_type (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setType($matchRes['_pregMatch']['type']);
    }



    public function Node_MATCH_nodeName (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setName($matchRes['_pregMatch']['nodeName']);
    }

    /**
     *
     * Parser rules and action for node 'Rule'
     *
     *  Rule:
     * <node Rule>
     *                 <attribute>importNode</attribute>
     *                 <rule>.._? '<rule>' .._? seq:Sequence .._? '</rule>' .._?</rule>
     *                 <action _start>
     *                     {
     *                         $nodeRes['_previousNode'] = $previous['_node'];
     *                     }
     *                 </action>
     *                 <action seq>
     *                     {
     *                         $nodeRes['_previousNode']->setRule($matchRes['_node']);
     *                     }
     *                 </action>
     *             </node>
     * 
     *
    */
    public function matchNodeRule($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->Rule_START($nodeRes, $previous);
        // start sequence
        $backup0 = $nodeRes;
        $pos0 = $this->parser->pos;
        $line0 = $this->parser->line;
        $error0 = $error;
        if ($trace) {
            $this->parser->addBacktrace(array('_s0_', ''));
        }
        do {
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: '<rule>'
             *       min: 1 max: 1
             */
            if ('<rule>' == substr($this->parser->source, $this->parser->pos, 6)) {
                $this->parser->pos += 6;
                $nodeRes['_text'] .= '<rule>';
                if ($trace) {
                    $this->parser->successNode(array('\'<rule>\'', '<rule>'));
                }
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', '<rule>');
                if ($trace) {
                    $this->parser->failNode(array('\'<rule>\'',  ''));
                }
                $valid = false;
            }
            /*
             * End rule: '<rule>'
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: seq:Sequence
             *       tag: 'seq'
             *       min: 1 max: 1
             */
            if ($trace) {
                $this->parser->addBacktrace(array('Sequence', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'Sequence', $error);
            if ($trace) {
                $remove = array_pop($this->parser->backtrace);
            }
            if ($matchRes) {
                if ($trace) {
                    $this->parser->successNode(array('Sequence',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                $this->Rule_MATCH_seq($nodeRes, $matchRes);
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $this->parser->failNode($remove);
                }
            }
            /*
             * End rule: seq:Sequence
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: '</rule>'
             *       min: 1 max: 1
             */
            if ('</rule>' == substr($this->parser->source, $this->parser->pos, 7)) {
                $this->parser->pos += 7;
                $nodeRes['_text'] .= '</rule>';
                if ($trace) {
                    $this->parser->successNode(array('\'</rule>\'', '</rule>'));
                }
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', '</rule>');
                if ($trace) {
                    $this->parser->failNode(array('\'</rule>\'',  ''));
                }
                $valid = false;
            }
            /*
             * End rule: '</rule>'
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            break;
        } while (true);
        if ($trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if (!$valid) {
            if ($trace) {
                $this->parser->failNode($remove);
            }
            $this->parser->pos = $pos0;
            $this->parser->line = $line0;
            $nodeRes = $backup0;
        } elseif ($trace) {
            $this->parser->successNode($remove);
        }
        $error = $error0;
        unset($backup0);
        // end sequence
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Rule');
        }
        return $nodeRes;
    }


    public function Rule_START (&$nodeRes, $previous)
    {
        $nodeRes['_previousNode'] = $previous['_node'];
    }



    public function Rule_MATCH_seq (&$nodeRes, $matchRes)
    {
        $nodeRes['_previousNode']->setRule($matchRes['_node']);
    }

    /**
     *
     * Parser rules and action for node 'Action'
     *
     *  Rule:
     * <node Action>
     *                 <attribute>importNode</attribute>
     *                 <rule>.._? instance:/\<action\s+(?<actionName>\w+)(\((?<argument>\w+)\))?\>/ .._? code:/(\{(?:(?>[^{}]+|(?R))*)?\})/ .._? '</action>' .._?</rule>
     *                 <action _start>
     *                     {
     *                         $nodeRes['_previousNode'] = $previous['_node'];
     *                     }
     *                 </action>
     *                 <action instance>
     *                     {
     *                         $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Action;
     *                     }
     *                 </action>
     *                 <action actionName>
     *                     {
     *                         $nodeRes['_node']->setName($matchRes['_pregMatch']['actionName']);
     *                     }
     *                 </action>
     *                 <action argument>
     *                     {
     *                         $nodeRes['_node']->setArgument($matchRes['_pregMatch']['argument']);
     *                     }
     *                 </action>
     *                 <action code>
     *                     {
     *                         $nodeRes['_node']->setCode($matchRes['_text']);
     *                     }
     *                 </action>
     *                 <action _finish>
     *                     {
     *                         $nodeRes['_previousNode']->addAction($nodeRes['_node']);
     *                     }
     *                 </action>
     *             </node>
     * 
     *
    */
    public function matchNodeAction($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->Action_START($nodeRes, $previous);
        // start sequence
        $backup0 = $nodeRes;
        $pos0 = $this->parser->pos;
        $line0 = $this->parser->line;
        $error0 = $error;
        if ($trace) {
            $this->parser->addBacktrace(array('_s0_', ''));
        }
        do {
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: instance:/\<action\s+(?<actionName>\w+)(\((?<argument>\w+)\))?\>/
             *       tag: 'instance'
             *       min: 1 max: 1
             */
            $regexp = "/\\<action\\s+(?<actionName>\\w+)(\\((?<argument>\\w+)\\))?\\>/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['Rx_Action3'][$pos])) {
                $matchRes = $this->parser->regexpCache['Rx_Action3'][$pos];
            } else {
                if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                    if (strlen($pregMatch[0][0]) != 0) {
                        $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                        foreach ($pregMatch as $n => $v) {
                            if (is_string($n) && strlen($v[0])) {
                                $matchRes['_pregMatch'][$n] = $v[0];
                            }
                        }
                        if ($matchRes['_startpos'] != $pos) {
                            $this->parser->regexpCache['Rx_Action3'][$matchRes['_startpos']] = $matchRes;
                            $this->parser->regexpCache['Rx_Action3'][$pos] = false;
                            $matchRes = false;
                        }
                    } else {
                        $this->parser->regexpCache['Rx_Action3'][$pos] = false;
                        $matchRes = false;
                    }
                } else {
                    $this->parser->regexpCache['Rx_Action3'][$pos] = false;
                    $matchRes = false;
                }
            }
            if ($matchRes) {
                $matchRes['_lineno'] = $this->parser->line;
                $this->parser->pos = $matchRes['_endpos'];
                $this->parser->line += substr_count($matchRes['_text'], "\n");
                $nodeRes['_text'] .= $matchRes['_text'];
                $this->Action_MATCH_instance($nodeRes, $matchRes);
                if (isset($matchRes['_pregMatch']['actionName'])) {
                    $this->Action_MATCH_actionName($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['actionName']);
                }
                if (isset($matchRes['_pregMatch']['argument'])) {
                    $this->Action_MATCH_argument($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['argument']);
                }
                $nodeRes['_pregMatch'] = array_merge($nodeRes['_pregMatch'], $matchRes['_pregMatch']);
                $valid = true;
            } else {
                $valid = false;
            }
            if (!$valid) {
                $this->parser->matchError($error, 'rx', "/\\<action\\s+(?<actionName>\\w+)(\\((?<argument>\\w+)\\))?\\>/");
            }
            /*
             * End rule: instance:/\<action\s+(?<actionName>\w+)(\((?<argument>\w+)\))?\>/
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: code:/(\{(?:(?>[^{}]+|(?R))*)?\})/
             *       tag: 'code'
             *       min: 1 max: 1
             */
            $regexp = "/(\\{(?:(?>[^{}]+|(?R))*)?\\})/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['Rx_Action6'][$pos])) {
                $matchRes = $this->parser->regexpCache['Rx_Action6'][$pos];
            } else {
                if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                    $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                    if ($matchRes['_startpos'] != $pos) {
                        $this->parser->regexpCache['Rx_Action6'][$matchRes['_startpos']] = $matchRes;
                        $this->parser->regexpCache['Rx_Action6'][$pos] = false;
                        $matchRes = false;
                    }
                } else {
                    $this->parser->regexpCache['Rx_Action6'][$pos] = false;
                    $matchRes = false;
                }
            }
            if ($matchRes) {
                $matchRes['_lineno'] = $this->parser->line;
                $this->parser->pos = $matchRes['_endpos'];
                $this->parser->line += substr_count($matchRes['_text'], "\n");
                $nodeRes['_text'] .= $matchRes['_text'];
                $this->Action_MATCH_code($nodeRes, $matchRes);
                $valid = true;
            } else {
                $valid = false;
            }
            if (!$valid) {
                $this->parser->matchError($error, 'rx', "/(\\{(?:(?>[^{}]+|(?R))*)?\\})/");
            }
            /*
             * End rule: code:/(\{(?:(?>[^{}]+|(?R))*)?\})/
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: '</action>'
             *       min: 1 max: 1
             */
            if ('</action>' == substr($this->parser->source, $this->parser->pos, 9)) {
                $this->parser->pos += 9;
                $nodeRes['_text'] .= '</action>';
                if ($trace) {
                    $this->parser->successNode(array('\'</action>\'', '</action>'));
                }
                $valid = true;
            } else {
                $this->parser->matchError($error, 'literal', '</action>');
                if ($trace) {
                    $this->parser->failNode(array('\'</action>\'',  ''));
                }
                $valid = false;
            }
            /*
             * End rule: '</action>'
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: .._?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: .._?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            break;
        } while (true);
        if ($trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if (!$valid) {
            if ($trace) {
                $this->parser->failNode($remove);
            }
            $this->parser->pos = $pos0;
            $this->parser->line = $line0;
            $nodeRes = $backup0;
        } elseif ($trace) {
            $this->parser->successNode($remove);
        }
        $error = $error0;
        unset($backup0);
        // end sequence
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
            $this->Action_FINISH($nodeRes);
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Action');
        }
        return $nodeRes;
    }


    public function Action_START (&$nodeRes, $previous)
    {
        $nodeRes['_previousNode'] = $previous['_node'];
    }



    public function Action_MATCH_instance (&$nodeRes, $matchRes)
    {
        $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Action;
    }



    public function Action_MATCH_actionName (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setName($matchRes['_pregMatch']['actionName']);
    }



    public function Action_MATCH_argument (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setArgument($matchRes['_pregMatch']['argument']);
    }



    public function Action_MATCH_code (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setCode($matchRes['_text']);
    }



    public function Action_FINISH (&$nodeRes)
    {
        $nodeRes['_previousNode']->addAction($nodeRes['_node']);
    }

    /**
     *
     * Parser rules and action for node 'Option'
     *
     *  Rule:
     * <node Option>
     *                 <rule> _? token:RuleToken ( _? '|' _? token:RuleToken)*</rule>
     *                 <action token>
     *                     {
     *                         $nodeRes['optionNodes'][] = $matchRes['_node'];
     *                     }
     *                 </action>
     *                 <action _finish>
     *                     {
     *                         if (count($nodeRes['optionNodes']) == 1) {
     *                            $nodeRes['_node'] = $nodeRes['optionNodes'][0];
     *                         } else {
     *                            $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Option;
     *                            $nodeRes['_node']->addOptionNodes($nodeRes['optionNodes']);
     *                         }
     *                     }
     *                 </action>
     *             </node>
     * 
     *
    */
    public function matchNodeOption($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        // start sequence
        $backup0 = $nodeRes;
        $pos0 = $this->parser->pos;
        $line0 = $this->parser->line;
        $error0 = $error;
        if ($trace) {
            $this->parser->addBacktrace(array('_s0_', ''));
        }
        do {
            $error = array();
            /*
             * Start rule: _?
             *       min: 1 max: 1
             */
            if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                if (!empty($pregMatch[0])) {
                    $this->parser->pos += strlen($pregMatch[0]);
                    $this->parser->line += substr_count($pregMatch[0], "\n");
                    $nodeRes['_text'] .= ' ';
                }
            }
            if ($trace) {
                $this->parser->successNode(array("' '",  $pregMatch[0]));
            }
            $valid = true;
            /*
             * End rule: _?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: token:RuleToken
             *       tag: 'token'
             *       min: 1 max: 1
             */
            if ($trace) {
                $this->parser->addBacktrace(array('RuleToken', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'RuleToken', $error);
            if ($trace) {
                $remove = array_pop($this->parser->backtrace);
            }
            if ($matchRes) {
                if ($trace) {
                    $this->parser->successNode(array('RuleToken',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                $this->Option_MATCH_token($nodeRes, $matchRes);
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $this->parser->failNode($remove);
                }
            }
            /*
             * End rule: token:RuleToken
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: (_? '|' _? token:RuleToken)*
             *       min: 0 max: null
             */
            $iteration3 = 0;
            do {
                // start sequence
                $backup4 = $nodeRes;
                $pos4 = $this->parser->pos;
                $line4 = $this->parser->line;
                $error4 = $error;
                if ($trace) {
                    $this->parser->addBacktrace(array('_s4_', ''));
                }
                do {
                    $error = array();
                    /*
                     * Start rule: _?
                     *       min: 1 max: 1
                     */
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                        if (!empty($pregMatch[0])) {
                            $this->parser->pos += strlen($pregMatch[0]);
                            $this->parser->line += substr_count($pregMatch[0], "\n");
                            $nodeRes['_text'] .= ' ';
                        }
                    }
                    if ($trace) {
                        $this->parser->successNode(array("' '",  $pregMatch[0]));
                    }
                    $valid = true;
                    /*
                     * End rule: _?
                     */
                    if (!$valid) {
                        $this->parser->matchError($error4, 'SequenceElement', $error);
                        $error = $error4;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: '|'
                     *       min: 1 max: 1
                     */
                    if ('|' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $nodeRes['_text'] .= '|';
                        if ($trace) {
                            $this->parser->successNode(array('\'|\'', '|'));
                        }
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', '|');
                        if ($trace) {
                            $this->parser->failNode(array('\'|\'',  ''));
                        }
                        $valid = false;
                    }
                    /*
                     * End rule: '|'
                     */
                    if (!$valid) {
                        $this->parser->matchError($error4, 'SequenceElement', $error);
                        $error = $error4;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: _?
                     *       min: 1 max: 1
                     */
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                        if (!empty($pregMatch[0])) {
                            $this->parser->pos += strlen($pregMatch[0]);
                            $this->parser->line += substr_count($pregMatch[0], "\n");
                            $nodeRes['_text'] .= ' ';
                        }
                    }
                    if ($trace) {
                        $this->parser->successNode(array("' '",  $pregMatch[0]));
                    }
                    $valid = true;
                    /*
                     * End rule: _?
                     */
                    if (!$valid) {
                        $this->parser->matchError($error4, 'SequenceElement', $error);
                        $error = $error4;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: token:RuleToken
                     *       tag: 'token'
                     *       min: 1 max: 1
                     */
                    if ($trace) {
                        $this->parser->addBacktrace(array('RuleToken', ''));
                    }
                    $matchRes = $this->parser->matchRule($nodeRes, 'RuleToken', $error);
                    if ($trace) {
                        $remove = array_pop($this->parser->backtrace);
                    }
                    if ($matchRes) {
                        if ($trace) {
                            $this->parser->successNode(array('RuleToken',  $matchRes['_text']));
                        }
                        $nodeRes['_text'] .= $matchRes['_text'];
                        $this->Option_MATCH_token($nodeRes, $matchRes);
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $this->parser->failNode($remove);
                        }
                    }
                    /*
                     * End rule: token:RuleToken
                     */
                    if (!$valid) {
                        $this->parser->matchError($error4, 'SequenceElement', $error);
                        $error = $error4;
                        break;
                    }
                    break;
                } while (true);
                if ($trace) {
                    $remove = array_pop($this->parser->backtrace);
                }
                if (!$valid) {
                    if ($trace) {
                        $this->parser->failNode($remove);
                    }
                    $this->parser->pos = $pos4;
                    $this->parser->line = $line4;
                    $nodeRes = $backup4;
                } elseif ($trace) {
                    $this->parser->successNode($remove);
                }
                $error = $error4;
                unset($backup4);
                // end sequence
                $iteration3 = $valid ? ($iteration3 + 1) : $iteration3;
                if (!$valid && $iteration3 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) break;
            } while (true);
            /*
             * End rule: (_? '|' _? token:RuleToken)*
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            break;
        } while (true);
        if ($trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if (!$valid) {
            if ($trace) {
                $this->parser->failNode($remove);
            }
            $this->parser->pos = $pos0;
            $this->parser->line = $line0;
            $nodeRes = $backup0;
        } elseif ($trace) {
            $this->parser->successNode($remove);
        }
        $error = $error0;
        unset($backup0);
        // end sequence
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
            $this->Option_FINISH($nodeRes);
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Option');
        }
        return $nodeRes;
    }


    public function Option_MATCH_token (&$nodeRes, $matchRes)
    {
        $nodeRes['optionNodes'][] = $matchRes['_node'];
    }



    public function Option_FINISH (&$nodeRes)
    {
        if (count($nodeRes['optionNodes']) == 1)        {
            $nodeRes['_node'] = $nodeRes['optionNodes'][0];
        }
        else        {
            $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Option;
            $nodeRes['_node']->addOptionNodes($nodeRes['optionNodes']);
        }
    }

    /**
     *
     * Parser rules and action for node 'Sequence'
     *
     *  Rule:
     * <node Sequence>
     *                 <rule>token:Option  token:Option*</rule>
     *                 <action token>
     *                     {
     *                         $nodeRes['sequenceNodes'][] = $matchRes['_node'];
     *                     }
     *                 </action>
     *                 <action _finish>
     *                     {
     *                         if (count($nodeRes['sequenceNodes']) == 1) {
     *                            $nodeRes['_node'] = $nodeRes['sequenceNodes'][0];
     *                         } else {
     *                            $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Sequence;
     *                            $nodeRes['_node']->addSequenceNodes($nodeRes['sequenceNodes']);
     *                         }
     *                     }
     *                 </action>
     *              </node>
     * 
     *
    */
    public function matchNodeSequence($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        // start sequence
        $backup0 = $nodeRes;
        $pos0 = $this->parser->pos;
        $line0 = $this->parser->line;
        $error0 = $error;
        if ($trace) {
            $this->parser->addBacktrace(array('_s0_', ''));
        }
        do {
            $error = array();
            /*
             * Start rule: token:Option
             *       tag: 'token'
             *       min: 1 max: 1
             */
            if ($trace) {
                $this->parser->addBacktrace(array('Option', ''));
            }
            $matchRes = $this->parser->matchRule($nodeRes, 'Option', $error);
            if ($trace) {
                $remove = array_pop($this->parser->backtrace);
            }
            if ($matchRes) {
                if ($trace) {
                    $this->parser->successNode(array('Option',  $matchRes['_text']));
                }
                $nodeRes['_text'] .= $matchRes['_text'];
                $this->Sequence_MATCH_token($nodeRes, $matchRes);
                $valid = true;
            } else {
                $valid = false;
                if ($trace) {
                    $this->parser->failNode($remove);
                }
            }
            /*
             * End rule: token:Option
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: token:Option*
             *       tag: 'token'
             *       min: 0 max: null
             */
            $iteration2 = 0;
            do {
                if ($trace) {
                    $this->parser->addBacktrace(array('Option', ''));
                }
                $matchRes = $this->parser->matchRule($nodeRes, 'Option', $error);
                if ($trace) {
                    $remove = array_pop($this->parser->backtrace);
                }
                if ($matchRes) {
                    if ($trace) {
                        $this->parser->successNode(array('Option',  $matchRes['_text']));
                    }
                    $nodeRes['_text'] .= $matchRes['_text'];
                    $this->Sequence_MATCH_token($nodeRes, $matchRes);
                    $valid = true;
                } else {
                    $valid = false;
                    if ($trace) {
                        $this->parser->failNode($remove);
                    }
                }
                $iteration2 = $valid ? ($iteration2 + 1) : $iteration2;
                if (!$valid && $iteration2 >= 0) {
                    $valid = true;
                    break;
                }
                if (!$valid) break;
            } while (true);
            /*
             * End rule: token:Option*
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            break;
        } while (true);
        if ($trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if (!$valid) {
            if ($trace) {
                $this->parser->failNode($remove);
            }
            $this->parser->pos = $pos0;
            $this->parser->line = $line0;
            $nodeRes = $backup0;
        } elseif ($trace) {
            $this->parser->successNode($remove);
        }
        $error = $error0;
        unset($backup0);
        // end sequence
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
            $this->Sequence_FINISH($nodeRes);
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Sequence');
        }
        return $nodeRes;
    }


    public function Sequence_MATCH_token (&$nodeRes, $matchRes)
    {
        $nodeRes['sequenceNodes'][] = $matchRes['_node'];
    }



    public function Sequence_FINISH (&$nodeRes)
    {
        if (count($nodeRes['sequenceNodes']) == 1)        {
            $nodeRes['_node'] = $nodeRes['sequenceNodes'][0];
        }
        else        {
            $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Sequence;
            $nodeRes['_node']->addSequenceNodes($nodeRes['sequenceNodes']);
        }
    }

    /**
     *
     * Parser rules and action for node 'RuleToken'
     *
     *  Rule:
     * <node RuleToken>
     *                 <rule>/((?<silent>\.+)|(?<pla>&)|(?<nla>\!))?((?<tag>\w+):)?/? ( /(?<rx>\G(\/|~|@|%|§)(((\\\\)*\\\2)|.*?(?=(\\|\2)))*\2)|((?<wsp>_)(?<wspOptional>\?)?)|(?<matchToken>\w+)|(?<literal>("[^"]*")|('[^']*'))|(\$(?<expression>\w+))/ | ('(' .._? seq:Sequence .._? ')')) /((?<quest>\?)|(?<any>\*)|(?<must>\+?)|(\{(?<min>\d+)?,(?<max>\d+)?\}))?/?</rule>
     *                 <action _start>
     *                     {
     *                         if (!isset($nodeRes['_node'])) {
     *                             $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Token;
     *                         }
     *                     }
     *                </action>
     *                <action silent>
     *                     {
     *                         $nodeRes['_node']->setSilent(strlen($matchRes['_pregMatch']['silent']));
     *                     }
     *                </action>
     *                <action pla>
     *                     {
     *                         $nodeRes['_node']->setPla();
     *                         $nodeRes['_node']->setSilent(1);
     *                     }
     *                </action>
     *                <action nla>
     *                     {
     *                         $nodeRes['_node']->setNla();
     *                         $nodeRes['_node']->setSilent(1);
     *                     }
     *                </action>
     *                <action tag>
     *                     {
     *                         $nodeRes['_node']->setTag($matchRes['_pregMatch']['tag']);
     *                     }
     *                </action>
     *                <action rx>
     *                     {
     *                         $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\RegExpr($matchRes['_pregMatch']['rx']));
     *                     }
     *                </action>
     *                <action wsp>
     *                     {
     *                         $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\WhiteSpace(isset($matchRes['_pregMatch']['wspOptional']) ? true : false));
     *                     }
     *                </action>
     *                <action matchToken>
     *                     {
     *                         $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\MatchToken($matchRes['_pregMatch']['matchToken']));
     *                     }
     *                </action>
     *                <action literal>
     *                     {
     *                         $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Literal($matchRes['_pregMatch']['literal']));
     *                     }
     *                </action>
     *                <action expression>
     *                     {
     *                         $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Expression($matchRes['_pregMatch']['expression']));
     *                     }
     *                </action>
     *                <action seq>
     *                     {
     *                         $nodeRes['_node']->setRuleToken($matchRes['_node']);
     *                     }
     *                </action>
     *                <action quest>
     *                     {
     *                         $nodeRes['_node']->setMin(0);
     *                     }
     *                </action>
     *                <action any>
     *                     {
     *                         $nodeRes['_node']->setMin(0);
     *                         $nodeRes['_node']->setMax(null);
     *                     }
     *                </action>
     *                <action must>
     *                     {
     *                         $nodeRes['_node']->setMax(null);
     *                     }
     *                </action>
     *                <action min>
     *                     {
     *                         $nodeRes['_node']->setMin($matchRes['_pregMatch']['min']);
     *                         if (isset($matchRes['_pregMatch']['max'])) {
     *                             $nodeRes['_node']->setMax($matchRes['_pregMatch']['max']);
     *                             unset($matchRes['_pregMatch']['max']);
     *                         } else {
     *                             $nodeRes['_node']->setMax($matchRes['_pregMatch']['max']);
     *                         }
     *                     }
     *                </action>
     *                <action max>
     *                     {
     *                         $nodeRes['_node']->setMax($matchRes['_pregMatch']['max']);
     *                     }
     *                </action>
     *                <action _finish>
     *                     {
     *                         $nodeRes['_node']->setRuleText($nodeRes['_text']);
     *                         $nodeRes['_pregMatch'] = array();
     *                     }
     *                 </action>
     *             </node>
     * 
     *
    */
    public function matchNodeRuleToken($previous, &$errorResult){
        $trace = $this->parser->trace;
        $nodeRes = $this->parser->resultDefault;
        $error = array();
        $pos0 = $nodeRes['_startpos'] = $nodeRes['_endpos'] = $this->parser->pos;
        $nodeRes['_lineno'] = $this->parser->line;
        $this->RuleToken_START($nodeRes, $previous);
        // start sequence
        $backup0 = $nodeRes;
        $pos0 = $this->parser->pos;
        $line0 = $this->parser->line;
        $error0 = $error;
        if ($trace) {
            $this->parser->addBacktrace(array('_s0_', ''));
        }
        do {
            $error = array();
            /*
             * Start rule: /((?<silent>\.+)|(?<pla>&)|(?<nla>\!))?((?<tag>\w+):)?/?
             *       min: 0 max: 1
             */
            $error = array();
            $regexp = "/((?<silent>\\.+)|(?<pla>&)|(?<nla>\\!))?((?<tag>\\w+):)?/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['Rx_RuleToken2'][$pos])) {
                $matchRes = $this->parser->regexpCache['Rx_RuleToken2'][$pos];
            } else {
                if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                    if (strlen($pregMatch[0][0]) != 0) {
                        $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                        foreach ($pregMatch as $n => $v) {
                            if (is_string($n) && strlen($v[0])) {
                                $matchRes['_pregMatch'][$n] = $v[0];
                            }
                        }
                        if ($matchRes['_startpos'] != $pos) {
                            $this->parser->regexpCache['Rx_RuleToken2'][$matchRes['_startpos']] = $matchRes;
                            $this->parser->regexpCache['Rx_RuleToken2'][$pos] = false;
                            $matchRes = false;
                        }
                    } else {
                        $this->parser->regexpCache['Rx_RuleToken2'][$pos] = false;
                        $matchRes = false;
                    }
                } else {
                    $this->parser->regexpCache['Rx_RuleToken2'][$pos] = false;
                    $matchRes = false;
                }
            }
            if ($matchRes) {
                $matchRes['_lineno'] = $this->parser->line;
                $this->parser->pos = $matchRes['_endpos'];
                $this->parser->line += substr_count($matchRes['_text'], "\n");
                $nodeRes['_text'] .= $matchRes['_text'];
                if (isset($matchRes['_pregMatch']['silent'])) {
                    $this->RuleToken_MATCH_silent($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['silent']);
                }
                if (isset($matchRes['_pregMatch']['pla'])) {
                    $this->RuleToken_MATCH_pla($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['pla']);
                }
                if (isset($matchRes['_pregMatch']['nla'])) {
                    $this->RuleToken_MATCH_nla($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['nla']);
                }
                if (isset($matchRes['_pregMatch']['tag'])) {
                    $this->RuleToken_MATCH_tag($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['tag']);
                }
                $nodeRes['_pregMatch'] = array_merge($nodeRes['_pregMatch'], $matchRes['_pregMatch']);
                $valid = true;
            } else {
                $valid = false;
            }
            if (!$valid) {
                $this->parser->matchError($error, 'rx', "/((?<silent>\\.+)|(?<pla>&)|(?<nla>\\!))?((?<tag>\\w+):)?/");
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, '', $error);
            }
            $valid = true;
            /*
             * End rule: /((?<silent>\.+)|(?<pla>&)|(?<nla>\!))?((?<tag>\w+):)?/?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: (/(?<rx>\G(\/|~|@|%|§)(((\\\\)*\\\2)|.*?(?=(\\|\2)))*\2)|((?<wsp>_)(?<wspOptional>\?)?)|(?<matchToken>\w+)|(?<literal>("[^"]*")|('[^']*'))|(\$(?<expression>\w+))/ | ('(' .._? seq:Sequence .._? ')'))
             *       min: 1 max: 1
             */
            // start option
            $error4 = $error;
            $errorOption4 =array();
            if ($trace) {
                $this->parser->addBacktrace(array('_o4_', ''));
            }
            do {
                $error = array();
                array_pop($this->parser->backtrace);
                if ($trace) {
                    $this->parser->addBacktrace(array('_o4:1_', ''));
                }
                /*
                 * Start rule: /(?<rx>\G(\/|~|@|%|§)(((\\\\)*\\\2)|.*?(?=(\\|\2)))*\2)|((?<wsp>_)(?<wspOptional>\?)?)|(?<matchToken>\w+)|(?<literal>("[^"]*")|('[^']*'))|(\$(?<expression>\w+))/
                 *       min: 1 max: 1
                 */
                $regexp = "/(?<rx>\\G(\\/|~|@|%|§)(((\\\\\\\\)*\\\\\\2)|.*?(?=(\\\\|\\2)))*\\2)|((?<wsp>_)(?<wspOptional>\\?)?)|(?<matchToken>\\w+)|(?<literal>(\"[^\"]*\")|('[^']*'))|(\\$(?<expression>\\w+))/";
                $pos = $this->parser->pos;
                if (isset($this->parser->regexpCache['Rx_RuleToken6'][$pos])) {
                    $matchRes = $this->parser->regexpCache['Rx_RuleToken6'][$pos];
                } else {
                    if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                        if (strlen($pregMatch[0][0]) != 0) {
                            $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                            foreach ($pregMatch as $n => $v) {
                                if (is_string($n) && strlen($v[0])) {
                                    $matchRes['_pregMatch'][$n] = $v[0];
                                }
                            }
                            if ($matchRes['_startpos'] != $pos) {
                                $this->parser->regexpCache['Rx_RuleToken6'][$matchRes['_startpos']] = $matchRes;
                                $this->parser->regexpCache['Rx_RuleToken6'][$pos] = false;
                                $matchRes = false;
                            }
                        } else {
                            $this->parser->regexpCache['Rx_RuleToken6'][$pos] = false;
                            $matchRes = false;
                        }
                    } else {
                        $this->parser->regexpCache['Rx_RuleToken6'][$pos] = false;
                        $matchRes = false;
                    }
                }
                if ($matchRes) {
                    $matchRes['_lineno'] = $this->parser->line;
                    $this->parser->pos = $matchRes['_endpos'];
                    $this->parser->line += substr_count($matchRes['_text'], "\n");
                    $nodeRes['_text'] .= $matchRes['_text'];
                    if (isset($matchRes['_pregMatch']['rx'])) {
                        $this->RuleToken_MATCH_rx($nodeRes, $matchRes);
                        unset($matchRes['_pregMatch']['rx']);
                    }
                    if (isset($matchRes['_pregMatch']['wsp'])) {
                        $this->RuleToken_MATCH_wsp($nodeRes, $matchRes);
                        unset($matchRes['_pregMatch']['wsp']);
                    }
                    if (isset($matchRes['_pregMatch']['matchToken'])) {
                        $this->RuleToken_MATCH_matchToken($nodeRes, $matchRes);
                        unset($matchRes['_pregMatch']['matchToken']);
                    }
                    if (isset($matchRes['_pregMatch']['literal'])) {
                        $this->RuleToken_MATCH_literal($nodeRes, $matchRes);
                        unset($matchRes['_pregMatch']['literal']);
                    }
                    if (isset($matchRes['_pregMatch']['expression'])) {
                        $this->RuleToken_MATCH_expression($nodeRes, $matchRes);
                        unset($matchRes['_pregMatch']['expression']);
                    }
                    $nodeRes['_pregMatch'] = array_merge($nodeRes['_pregMatch'], $matchRes['_pregMatch']);
                    $valid = true;
                } else {
                    $valid = false;
                }
                if (!$valid) {
                    $this->parser->matchError($error, 'rx', "/(?<rx>\\G(\\/|~|@|%|§)(((\\\\\\\\)*\\\\\\2)|.*?(?=(\\\\|\\2)))*\\2)|((?<wsp>_)(?<wspOptional>\\?)?)|(?<matchToken>\\w+)|(?<literal>(\"[^\"]*\")|('[^']*'))|(\\$(?<expression>\\w+))/");
                }
                /*
                 * End rule: /(?<rx>\G(\/|~|@|%|§)(((\\\\)*\\\2)|.*?(?=(\\|\2)))*\2)|((?<wsp>_)(?<wspOptional>\?)?)|(?<matchToken>\w+)|(?<literal>("[^"]*")|('[^']*'))|(\$(?<expression>\w+))/
                 */
                if ($valid) {
                    if ($trace) {
                        $this->parser->successNode(array_pop($this->parser->backtrace));
                    }
                    $error = $error4;
                    break;
                } else {
                    $this->parser->logOption($errorOption4, '', $error);
                }
                $error = array();
                array_pop($this->parser->backtrace);
                if ($trace) {
                    $this->parser->addBacktrace(array('_o4:2_', ''));
                }
                /*
                 * Start rule: ('(' .._? seq:Sequence .._? ')')
                 *       min: 1 max: 1
                 */
                // start sequence
                $backup8 = $nodeRes;
                $pos8 = $this->parser->pos;
                $line8 = $this->parser->line;
                $error8 = $error;
                if ($trace) {
                    $this->parser->addBacktrace(array('_s8_', ''));
                }
                do {
                    $error = array();
                    /*
                     * Start rule: '('
                     *       min: 1 max: 1
                     */
                    if ('(' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $nodeRes['_text'] .= '(';
                        if ($trace) {
                            $this->parser->successNode(array('\'(\'', '('));
                        }
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', '(');
                        if ($trace) {
                            $this->parser->failNode(array('\'(\'',  ''));
                        }
                        $valid = false;
                    }
                    /*
                     * End rule: '('
                     */
                    if (!$valid) {
                        $this->parser->matchError($error8, 'SequenceElement', $error);
                        $error = $error8;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: .._?
                     *       min: 1 max: 1
                     */
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                        if (!empty($pregMatch[0])) {
                            $this->parser->pos += strlen($pregMatch[0]);
                            $this->parser->line += substr_count($pregMatch[0], "\n");
                        }
                    }
                    if ($trace) {
                        $this->parser->successNode(array("' '",  $pregMatch[0]));
                    }
                    $valid = true;
                    /*
                     * End rule: .._?
                     */
                    if (!$valid) {
                        $this->parser->matchError($error8, 'SequenceElement', $error);
                        $error = $error8;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: seq:Sequence
                     *       tag: 'seq'
                     *       min: 1 max: 1
                     */
                    if ($trace) {
                        $this->parser->addBacktrace(array('Sequence', ''));
                    }
                    $matchRes = $this->parser->matchRule($nodeRes, 'Sequence', $error);
                    if ($trace) {
                        $remove = array_pop($this->parser->backtrace);
                    }
                    if ($matchRes) {
                        if ($trace) {
                            $this->parser->successNode(array('Sequence',  $matchRes['_text']));
                        }
                        $nodeRes['_text'] .= $matchRes['_text'];
                        $this->RuleToken_MATCH_seq($nodeRes, $matchRes);
                        $valid = true;
                    } else {
                        $valid = false;
                        if ($trace) {
                            $this->parser->failNode($remove);
                        }
                    }
                    /*
                     * End rule: seq:Sequence
                     */
                    if (!$valid) {
                        $this->parser->matchError($error8, 'SequenceElement', $error);
                        $error = $error8;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: .._?
                     *       min: 1 max: 1
                     */
                    if (preg_match($this->parser->whitespacePattern, $this->parser->source, $pregMatch, 0, $this->parser->pos)) {
                        if (!empty($pregMatch[0])) {
                            $this->parser->pos += strlen($pregMatch[0]);
                            $this->parser->line += substr_count($pregMatch[0], "\n");
                        }
                    }
                    if ($trace) {
                        $this->parser->successNode(array("' '",  $pregMatch[0]));
                    }
                    $valid = true;
                    /*
                     * End rule: .._?
                     */
                    if (!$valid) {
                        $this->parser->matchError($error8, 'SequenceElement', $error);
                        $error = $error8;
                        break;
                    }
                    $error = array();
                    /*
                     * Start rule: ')'
                     *       min: 1 max: 1
                     */
                    if (')' == substr($this->parser->source, $this->parser->pos, 1)) {
                        $this->parser->pos += 1;
                        $nodeRes['_text'] .= ')';
                        if ($trace) {
                            $this->parser->successNode(array('\')\'', ')'));
                        }
                        $valid = true;
                    } else {
                        $this->parser->matchError($error, 'literal', ')');
                        if ($trace) {
                            $this->parser->failNode(array('\')\'',  ''));
                        }
                        $valid = false;
                    }
                    /*
                     * End rule: ')'
                     */
                    if (!$valid) {
                        $this->parser->matchError($error8, 'SequenceElement', $error);
                        $error = $error8;
                        break;
                    }
                    break;
                } while (true);
                if ($trace) {
                    $remove = array_pop($this->parser->backtrace);
                }
                if (!$valid) {
                    if ($trace) {
                        $this->parser->failNode($remove);
                    }
                    $this->parser->pos = $pos8;
                    $this->parser->line = $line8;
                    $nodeRes = $backup8;
                } elseif ($trace) {
                    $this->parser->successNode($remove);
                }
                $error = $error8;
                unset($backup8);
                // end sequence
                /*
                 * End rule: ('(' .._? seq:Sequence .._? ')')
                 */
                if ($valid) {
                    if ($trace) {
                        $this->parser->successNode(array_pop($this->parser->backtrace));
                    }
                    $error = $error4;
                    break;
                } else {
                    $this->parser->logOption($errorOption4, 'Sequence', $error);
                }
                $error = $error4;
                array_pop($this->parser->backtrace);
                break;
            } while (true);
            // end option
            /*
             * End rule: (/(?<rx>\G(\/|~|@|%|§)(((\\\\)*\\\2)|.*?(?=(\\|\2)))*\2)|((?<wsp>_)(?<wspOptional>\?)?)|(?<matchToken>\w+)|(?<literal>("[^"]*")|('[^']*'))|(\$(?<expression>\w+))/ | ('(' .._? seq:Sequence .._? ')'))
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            $error = array();
            /*
             * Start rule: /((?<quest>\?)|(?<any>\*)|(?<must>\+?)|(\{(?<min>\d+)?,(?<max>\d+)?\}))?/?
             *       min: 0 max: 1
             */
            $error = array();
            $regexp = "/((?<quest>\\?)|(?<any>\\*)|(?<must>\\+?)|(\\{(?<min>\\d+)?,(?<max>\\d+)?\\}))?/";
            $pos = $this->parser->pos;
            if (isset($this->parser->regexpCache['Rx_RuleToken15'][$pos])) {
                $matchRes = $this->parser->regexpCache['Rx_RuleToken15'][$pos];
            } else {
                if (preg_match($regexp . 'Sxs', $this->parser->source, $pregMatch, PREG_OFFSET_CAPTURE, $pos)) {
                    if (strlen($pregMatch[0][0]) != 0) {
                        $matchRes = array('_silent' => 0, '_text' => $pregMatch[0][0], '_startpos' => $pregMatch[0][1], '_endpos' => $pregMatch[0][1] + strlen($pregMatch[0][0]), '_pregMatch' => array());
                        foreach ($pregMatch as $n => $v) {
                            if (is_string($n) && strlen($v[0])) {
                                $matchRes['_pregMatch'][$n] = $v[0];
                            }
                        }
                        if ($matchRes['_startpos'] != $pos) {
                            $this->parser->regexpCache['Rx_RuleToken15'][$matchRes['_startpos']] = $matchRes;
                            $this->parser->regexpCache['Rx_RuleToken15'][$pos] = false;
                            $matchRes = false;
                        }
                    } else {
                        $this->parser->regexpCache['Rx_RuleToken15'][$pos] = false;
                        $matchRes = false;
                    }
                } else {
                    $this->parser->regexpCache['Rx_RuleToken15'][$pos] = false;
                    $matchRes = false;
                }
            }
            if ($matchRes) {
                $matchRes['_lineno'] = $this->parser->line;
                $this->parser->pos = $matchRes['_endpos'];
                $this->parser->line += substr_count($matchRes['_text'], "\n");
                $nodeRes['_text'] .= $matchRes['_text'];
                if (isset($matchRes['_pregMatch']['quest'])) {
                    $this->RuleToken_MATCH_quest($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['quest']);
                }
                if (isset($matchRes['_pregMatch']['any'])) {
                    $this->RuleToken_MATCH_any($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['any']);
                }
                if (isset($matchRes['_pregMatch']['must'])) {
                    $this->RuleToken_MATCH_must($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['must']);
                }
                if (isset($matchRes['_pregMatch']['min'])) {
                    $this->RuleToken_MATCH_min($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['min']);
                }
                if (isset($matchRes['_pregMatch']['max'])) {
                    $this->RuleToken_MATCH_max($nodeRes, $matchRes);
                    unset($matchRes['_pregMatch']['max']);
                }
                $nodeRes['_pregMatch'] = array_merge($nodeRes['_pregMatch'], $matchRes['_pregMatch']);
                $valid = true;
            } else {
                $valid = false;
            }
            if (!$valid) {
                $this->parser->matchError($error, 'rx', "/((?<quest>\\?)|(?<any>\\*)|(?<must>\\+?)|(\\{(?<min>\\d+)?,(?<max>\\d+)?\\}))?/");
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, '', $error);
            }
            $valid = true;
            /*
             * End rule: /((?<quest>\?)|(?<any>\*)|(?<must>\+?)|(\{(?<min>\d+)?,(?<max>\d+)?\}))?/?
             */
            if (!$valid) {
                $this->parser->matchError($error0, 'SequenceElement', $error);
                $error = $error0;
                break;
            }
            break;
        } while (true);
        if ($trace) {
            $remove = array_pop($this->parser->backtrace);
        }
        if (!$valid) {
            if ($trace) {
                $this->parser->failNode($remove);
            }
            $this->parser->pos = $pos0;
            $this->parser->line = $line0;
            $nodeRes = $backup0;
        } elseif ($trace) {
            $this->parser->successNode($remove);
        }
        $error = $error0;
        unset($backup0);
        // end sequence
        if ($valid) {
            $nodeRes['_endpos'] = $this->parser->pos;
            $nodeRes['_endline'] = $this->parser->line;
            $this->RuleToken_FINISH($nodeRes);
        }
        if (!$valid) {
            $nodeRes = false;
            $this->parser->matchError($errorResult, 'token', $error, 'RuleToken');
        }
        return $nodeRes;
    }


    public function RuleToken_START (&$nodeRes, $previous)
    {
        if (!isset($nodeRes['_node']))        {
            $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Token;
        }
    }



    public function RuleToken_MATCH_silent (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setSilent(strlen($matchRes['_pregMatch']['silent']));
    }



    public function RuleToken_MATCH_pla (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setPla();
        $nodeRes['_node']->setSilent(1);
    }



    public function RuleToken_MATCH_nla (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setNla();
        $nodeRes['_node']->setSilent(1);
    }



    public function RuleToken_MATCH_tag (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setTag($matchRes['_pregMatch']['tag']);
    }



    public function RuleToken_MATCH_rx (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\RegExpr($matchRes['_pregMatch']['rx']));
    }



    public function RuleToken_MATCH_wsp (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\WhiteSpace(isset($matchRes['_pregMatch']['wspOptional']) ? true : false));
    }



    public function RuleToken_MATCH_matchToken (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\MatchToken($matchRes['_pregMatch']['matchToken']));
    }



    public function RuleToken_MATCH_literal (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Literal($matchRes['_pregMatch']['literal']));
    }



    public function RuleToken_MATCH_expression (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Expression($matchRes['_pregMatch']['expression']));
    }



    public function RuleToken_MATCH_seq (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setRuleToken($matchRes['_node']);
    }



    public function RuleToken_MATCH_quest (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setMin(0);
    }



    public function RuleToken_MATCH_any (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setMin(0);
        $nodeRes['_node']->setMax(null);
    }



    public function RuleToken_MATCH_must (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setMax(null);
    }



    public function RuleToken_MATCH_min (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setMin($matchRes['_pregMatch']['min']);
        if (isset($matchRes['_pregMatch']['max']))        {
            $nodeRes['_node']->setMax($matchRes['_pregMatch']['max']);
            unset($matchRes['_pregMatch']['max']);
        }
        else        {
            $nodeRes['_node']->setMax($matchRes['_pregMatch']['max']);
        }
    }



    public function RuleToken_MATCH_max (&$nodeRes, $matchRes)
    {
        $nodeRes['_node']->setMax($matchRes['_pregMatch']['max']);
    }



    public function RuleToken_FINISH (&$nodeRes)
    {
        $nodeRes['_node']->setRuleText($nodeRes['_text']);
        $nodeRes['_pregMatch'] = array();
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
        if (isset($this->ruleMethods)) {
            foreach ($this->ruleMethods as $name => $method) {
                $this->ruleCallbackArray[$name] = array($this, $method);
            }
        }
        $this->trace = false;
    }

    /**
     * @param string $ruleName
     *
     * @throws \Smarty\Parser\Exception\NoRule
     * @return mixed
     */
    public function getRuleAsArray($ruleName)
    {
        if (isset($this->ruleArray[$ruleName])) {
            $rule = $this->ruleArray[$ruleName];
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
        $nodeRes = $this->parser->parse('Root');
        $root = $nodeRes['_node'];
        $root->setFilename($this->filename);
        $root->setFiletime($this->filetime);
        $root->compileParser();
        $output = $root->getFormatted();
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

    /**
     * @param $string
     *
     * @return string
     */
    public function compileDynamic($string)
    {
        $this->setSource($string);
        if (preg_match("/([\\S\\s]+(?=([^\\S\\r\\n]\\/\\*!\\*)))|[\\S\\s]+/", $this->parser->source, $match)) {
            $this->parser->pos += strlen($match[1]);
            $this->parser->line += substr_count($match[1], "\n");
            $nodeRes = $this->parser->parse('Parser');
            return $nodeRes['_node']->nodes;
        }
        return '';
    }
}

