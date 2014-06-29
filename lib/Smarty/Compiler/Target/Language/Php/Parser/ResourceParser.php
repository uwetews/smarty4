<?php
namespace Smarty\Compiler\Target\Language\Php\Parser;

use Smarty\Nodes;
use Smarty\PegParser;

/**
 * Class ResourceParser
 *
 * @package Smarty\Compiler\Target\Language\Php\Parser
 */
class ResourceParser extends PegParser
{

   
    /**
     *
     * Parser generated on 2014-06-29 20:34:38
     *  Rule filename 'C:\wamp\www\smarty4\lib\Smarty/Compiler/Target/Language/Php/Parser/Resource.peg.inc' dated 2014-06-28 02:53:31
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
            "Resource" => "matchNodeResource"
        );

    /**
     * Array of node attributes
     *
     * @var array
     */
    public $nodeAttributes = array(
            "Resource" => array(
                    "_nodetype" => "node"
                )
        );
    /**
     *
     * Parser rules and action for node 'Resource'
     *
     *  Rule:
    
            <node Resource>
                <rule>main:Template</rule>
                <action _start>
                {
                    $result['node'] = $previous['node'];
                }
                </action>
                <action main>
                {
                    $result['node']->templateNode = $subres['node'];
                }
                </action>
            </node>

     *
    */
    public function matchNodeResource($previous){
        $result = $this->parser->resultDefault;
        $pos0 = $result['_startpos'] = $result['_endpos'] = $this->parser->pos;
        $result['_lineno'] = $this->parser->line;
        $this->Resource___START($result, $previous);
        // Start 'main:Template' tag 'main' min '1' max '1'
        $this->parser->addBacktrace(array('Template', $result));
        $subres = $this->parser->matchRule($result, 'Template');
        $remove = array_pop($this->parser->backtrace);
        if ($subres) {
            $this->parser->successNode(array('Template',  $subres));
            $result['_text'] .= $subres['_text'];
            $this->Resource_main($result, $subres);
            $valid = true;
        } else {
            $valid = false;
            $this->parser->failNode($remove);
        }
        // End 'main:Template'
        if ($valid) {
            $result['_endpos'] = $this->parser->pos;
            $result['_endline'] = $this->parser->line;
        }
        if (!$valid) {
            $result = false;
        }
        return $result;
    }

    public function Resource___START (&$result, $previous) {
        $result['node'] = $previous['node'];
    }


    public function Resource_main (&$result, $subres) {
        $result['node']->templateNode = $subres['node'];
    }




}

