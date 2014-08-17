<?php
namespace Smarty\Compiler\Target\Language\Php\Parser;

use Smarty\Node;
use Smarty\PegParser;

/**
 * Class TemplateParser
 *
 * @package Smarty\Compiler\Target\Language\Php\Parser
 */
class TemplateParser extends PegParser
{

    /**
     * Parser generated on 2014-08-10 18:55:25
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Target/Language/Php/Parser/Template.peg.inc' dated 2014-07-16 23:45:52

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
        "Template" => "matchNodeTemplate",
        "Bom"      => "matchNodeBom"
    );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
        "Template" => array(
            "_nodetype" => "node"
        ),
        "Bom"      => array(
            "_nodetype" => "node"
        )
    );

    /**
     * Parser rules and action for node 'Template'
     *  Rule:
     * <node Template>
     * <rule>.Bom? nodes:Body?  Unexpected?</rule>
     * <action _start>
     * {
     * $result['node'] = new Node\Template($this->parser, $result);
     * }
     * </action>
     * <action nodes>
     * {
     * $result['node']->templateBodyNode = $subres['node'];
     * $result['node']->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
     * $result['node']->templateBodyNode->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
     * }
     * </action>
     * </node>


     */
    public function matchNodeTemplate($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->Template___START($result, $previous);
        // Start 'Template' min '1' max '1'
        // start sequence
        $backup1 = $result;
        $pos1 = $this->parser->pos;
        $line1 = $this->parser->line;
        $error1 = $error;
        $this->parser->addBacktrace(array('_s1_', ''));
        do {
            $error = array();
            // Start '.Bom?' min '0' max '1'
            $error = array();
            $this->parser->addBacktrace(array('Bom', ''));
            $subres = $this->parser->matchRule($result, 'Bom', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Bom', $subres['_text']));
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, 'Template', $error);
            }
            $valid = true;
            // End '.Bom?'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'nodes:Body?' tag 'nodes' min '0' max '1'
            $error = array();
            $this->parser->addBacktrace(array('Body', ''));
            $subres = $this->parser->matchRule($result, 'Body', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Body', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $this->Template_nodes($result, $subres);
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, 'Template', $error);
            }
            $valid = true;
            // End 'nodes:Body?'
            if (!$valid) {
                $this->parser->matchError($error1, 'SequenceElement', $error);
                $error = $error1;
                break;
            }
            $error = array();
            // Start 'Unexpected?' min '0' max '1'
            $error = array();
            $this->parser->addBacktrace(array('Unexpected', ''));
            $subres = $this->parser->matchRule($result, 'Unexpected', $error);
            $remove = array_pop($this->parser->backtrace);
            if ($subres) {
                $this->parser->successNode(array('Unexpected', $subres['_text']));
                $result['_text'] .= $subres['_text'];
                $valid = true;
            } else {
                $valid = false;
                $this->parser->failNode($remove);
            }
            if (!$valid) {
                $this->parser->logOption($errorResult, 'Template', $error);
            }
            $valid = true;
            // End 'Unexpected?'
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
        // End 'Template'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Template');
        }
        return $result;
    }

    public function Template___START(&$result, $previous)
    {
        $result['node'] = new Node\Template($this->parser, $result);
    }

    public function Template_nodes(&$result, $subres)
    {
        $result['node']->templateBodyNode = $subres['node'];
        $result['node']->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
        $result['node']->templateBodyNode->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
    }

    /**
     * Parser rules and action for node 'Bom'
     *  Rule:
     * <node Bom>
     * <rule>/^(\xEF\xBB\xBF)|(\xFE\xFF)|(\xFF\xFE)/</rule>
     * </node>


     */
    public function matchNodeBom($previous, &$errorResult)
    {
        $result = $this->parser->resultDefault;
        $error = array();
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        // Start '/^(\xEF\xBB\xBF)|(\xFE\xFF)|(\xFF\xFE)/' min '1' max '1'
        $regexp = "/^(\\xEF\\xBB\\xBF)|(\\xFE\\xFF)|(\\xFF\\xFE)/";
        $pos = $this->parser->pos;
        if (isset($this->parser->regexpCache['Bom2'][$pos])) {
            $subres = $this->parser->regexpCache['Bom2'][$pos];
        } else {
            if (preg_match($regexp . 'Sxs', $this->parser->source, $match, PREG_OFFSET_CAPTURE, $pos)) {
                $subres = array('_silent' => 0, '_text' => $match[0][0], '_startpos' => $match[0][1], '_endpos' => $match[0][1] + strlen($match[0][0]), '_matchres' => array());
                if ($subres['_startpos'] != $pos) {
                    $this->parser->regexpCache['Bom2'][$subres['_startpos']] = $subres;
                    $this->parser->regexpCache['Bom2'][$pos] = false;
                    $subres = false;
                }
            } else {
                $this->parser->regexpCache['Bom2'][$pos] = false;
                $subres = false;
            }
        }
        if ($subres) {
            $subres['_lineno'] = $this->parser->line;
            $this->parser->pos = $subres['_endpos'];
            $this->parser->line += substr_count($subres['_text'], "\n");
            $subres['_tag'] = false;
            $subres['_name'] = 'Bom';
            $valid = true;
        } else {
            $valid = false;
        }
        if ($valid) {
            $result['_text'] .= $subres['_text'];
        } else {
            $this->parser->matchError($error, 'rx', "/^(\\xEF\\xBB\\xBF)|(\\xFE\\xFF)|(\\xFF\\xFE)/");
        }
        // End '/^(\xEF\xBB\xBF)|(\xFE\xFF)|(\xFF\xFE)/'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
            $this->parser->matchError($errorResult, 'token', $error, 'Bom');
        }
        return $result;
    }
}

