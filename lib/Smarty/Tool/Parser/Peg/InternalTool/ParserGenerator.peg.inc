<?php
namespace Smarty\Tool\Parser\Peg;

Use Smarty\Tool\Parser\Peg\Root;
Use Smarty\Tool\Parser\Peg\Rules\Result;
Use Smarty\Template\Context;
Use Smarty\Compiler;
Use Smarty\Parser;

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

    /*!*
        <pegparser PEGparser>


            <node attrvalue>
                <rule> .._? ( /(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|("[^"]*")|\d+|\w+))/ | ( '(' sub:attr ')' ) )</rule>
                <action sub> {
                        $result['value'] = $subres['_attr'];
                    }
                </action>
                <action _finish>
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
                </action>
            </node>


            <node attrentry>
                <rule> .._? key:Name .._? ( '=' .._? val:attrvalue)? </rule>
                <action key>
                {
                    $result['key'] = $subres['_text'];
                    $result['value'] = array($result['key'] => true);
                }
                </action>
                <action val>
                {
                    $result['value'][$result['key']] = $subres['value'];
                }
                </action>
             </node>

            <node attr>
                <rule> attrentry (',' attrentry)*</rule>
                <action _all>
                {
                    if (!isset($result['_attr'])) {
                        $result['_attr'] = array();
                    }
                    $result['_attr'] = array_merge($result['_attr'], $subres['value']);
                }
                </action>
            </node>

            <node Name>
                <rule>/\w+/</rule>
            </node>

            <node Header>
                <rule>/\s*\/\*!\* /</rule>
            </node>

            <node End>
                <rule>./\s*\*\//</rule>
            </node>

            <node Comment>
                <rule>/[\s\t]*(([#][^\r\n]*)?([\r\n]+[\s\t]*))* /</rule>
            </node>

            <node Text>
                <rule>/([\S\s]+(?=([^\S\r\n]\/\*!\*)))|[\S\s]+/</rule>
                <action _start>
                    {
                        $result['_node'] = new \Smarty\Tool\Parser\Peg\Nodes\Text ($this, null);
                    }
                </action>
                <action _all>
                    {
                        $result['_node']->_text = $subres['_text'];
                    }
                </action>
            </node>


            <node Parser>
                <rule>..Header .._? '<pegparser' _ Name '>' Attribute* Node* .._? '</pegparser>' .._? End?</rule>
                <action _start>
                    {
                        $result['_node'] = new \Smarty\Tool\Parser\Peg\Nodes\Pegparser ($this, null);
                    }
                </action>
                <action Attribute>
                    {
                        if (!isset($result['_attr'])) {
                            $result['_attr'] = array();
                        }
                        $result['_attr'] = array_merge($result['_attr'], $subres['_attr']);
                    }
                </action>
                <action Node>
                    {
                        $subres['_nodedef']['rule']['_name'] = $subres['_nodedef']['name'];
                        ksort($subres['_nodedef']['rule']);
                        $result['_node']->nodes[$subres['_nodedef']['name']] = $subres['_nodedef']['rule'];
                        $result['_node']->comments[$subres['_nodedef']['name']] = $subres['_text'];
                        if (isset($subres['_attr'])) {
                            $result['_node']->attributes[$subres['_nodedef']['name']] = $subres['_attr'];
                        }
                        if (isset($subres['_nodedef']['actions'])) {
                            $result['_node']->actions[$subres['_nodedef']['name']] = $subres['_nodedef']['actions'];
                        }
                    }
                </action>
            </node>

            <node Attribute>
                <rule>.._? '<attribute>' attr '</attribute>' .._?</rule>
                <action attr>
                    {
                        $result['_attr'] = $subres['_attr'];
                    }
                </action>
            </node>

            <node Node>
                <rule>.._?  /\s*\<(?<type>(node|token))\s+(?<nodename>[a-zA-Z_0-9]+)\>/  Attribute* Rule .Action* /<\/(node|token)>/ .._?</rule>
                 <action type>
                 {
                        $result['_nodedef']['rule']['_attr'] = array('_nodetype' => $subres['_matchres']['type']);
                 }
                </action>
                 <action nodename>
                    {
                        $result['nodename'] = $subres['_matchres']['nodename'];
                        $result['_nodedef']['name'] = $result['nodename'];
                        unset($subres['_matchres']);
                    }
                </action>
                <action Attribute>
                    {
                         $result['_nodedef']['rule']['_attr'] = array_merge($result['_nodedef']['rule']['_attr'], $subres['_attr']);
                    }
                </action>
                <action Rule>
                    {
                        $subres['_rule']['_name'] = $result['nodename'];
                        $result['_nodedef']['rule'] = array_merge($result['_nodedef']['rule'], $subres['_rule']);
                    }
                </action>
                <action Action>
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
                </action>
                <action _finish>
                    {
                        ksort($result['_nodedef']['rule']);
                    }
                </action>
            </node>


            <node Rule>
                <rule>.._? '<rule>' .._? Sequence .._? '</rule>' .._?</rule>
                <action Sequence>
                    {
                        $result['_rule'] = $subres['_rule'];
                    }
                </action>
            </node>

            <node Action>
                <rule>.._? /\<action\s+(?<funcname>\w+)(\((?<argument>\w+)\))?\>/ .._? code:/(\{(?:(?>[^{}]+|(?R))*)?\})/ .._? '</action>' .._?</rule>
                <action code>
                    {
                        $result['code'] = $subres['_text'];
                    }
                </action>
            </node>

            <node PHP>
                 <rule>/.[\n\t ]* / .b:/(\{|\}|[^\n\}\{]+)* / </rule>
                 <action b>
                    {
                        $result['_text'] = trim($subres['_text']);
                    }
                </action>
            </node>

            <node Arguments>
                <rule>'(' attr:Name ( '=' value:Name | value:Arguments )? (',' attr:Name ( '=' value:Name | value:Arguments )?)* ')'</rule>
            </node>

            <node Option>
                <rule> _? result:RuleToken ( _? '|' _? option:RuleToken)*</rule>
                <action result>
                    {
                        $result['_rule'] = $subres['_rule'];
                    }
                </action>
                <action option>
                    {
                        ksort($subres['_rule']);
                        if(isset($result['_rule']['_type']) && $result['_rule']['_type'] != 'option') {
                            ksort($result['_rule']);
                            $r = $result['_rule'];
                            $result['_rule'] = array('_type' => 'option', '_param' => array($r, $subres['_rule']));
                        } else {
                            $result['_rule']['_param'][] = $subres['_rule'];
                        }
                    }
                </action>
            </node>

            <node Sequence>
                <rule>result:Option  sequence:Option*</rule>
                <action result>
                    {
                        $result['_rule'] = $subres['_rule'];
                    }
               </action>
               <action sequence>
                    {
                        ksort($subres['_rule']);
                        if(isset($result['_rule']['_type']) && $result['_rule']['_type'] != 'sequence') {
                            ksort($result['_rule']);
                            $r = $result['_rule'];
                            $result['_rule'] = array('_type' => 'sequence', '_param' => array($r, $subres['_rule']));
                        } else {
                            $result['_rule']['_param'][] = $subres['_rule'];
                        }
                    }
               </action>
            </node>


            <node RuleToken>
                <rule>/((?<silent>\.+)|(?<pla>&)|(?<nla>\!))?((?<tag>\w+):)?/ ( /(?<rx>\G(\/|~|@|%|§)(((\\\\)*\\\2)|.*?(?=(\\|\2)))*\2)|((?<osp>_\?)|(?<wsp>_))|(?<node>\w+)|(?<literal>("[^"]*")|('[^']*'))|(\$(?<expression>\w+))/ | ('(' .._? Sequence .._? ')')) /((?<quest>\?)|(?<any>\*)|(?<must>\+?)|(\{(?<min>\d+)?,(?<max>\d+)?\}))?/</rule>
                <action _start>
                    {
                        $result['_rule'] = array();
                    }
               </action>
                <action Sequence>
                    {
                        $result['_rule'] = $subres['_rule'];
                    }
               </action>
               <action _finish>
                    {
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
                            $result['_rule']['_param'] = trim($mr['literal'],"'\"");
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
                            $result['_rule']['_tag'] =$mr['tag'];
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
                </action>
            </node>

            <node File>
                <rule>(.Text .Parser*)*</rule>
                <action _start>
                    {
                        $result['_nodes']= array();
                    }
                </action>
                <action _all>
                    {
                        if (isset($subres['_node'])) {
                            $result['_nodes'][] = $subres['_node'];
                        }
                    }
                </action>
            </node>

       </pegparser>
    */

    /**
     * Constructor
     *
     * @param \Smarty_Compiler|\Smarty_Compiler_CompilerCore $compiler compiler object
     * @param \Smarty_Template_Context                       $context
     */
    function __construct(Compiler $compiler, Context $context)
    {
        $this->parser = $this;
        if ($this->trace) {
            $this->traceFile = fopen('php://output', 'w');
        }
     }

    /**
     * @param $ruleName
     *
     * @return mixed
     * @throws \Smarty_Parser_Peg_Exception_NoRule
     */
    public function getRuleNode($ruleName)
    {
        if (isset($this->rules[$ruleName])) {
            $rule = $this->rules[$ruleName];
            $rule['_ruleParser'] = $this;
        } else {
            throw new \Smarty_Parser_Peg_Exception_NoRule($ruleName, 0, $this->context);
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
}

