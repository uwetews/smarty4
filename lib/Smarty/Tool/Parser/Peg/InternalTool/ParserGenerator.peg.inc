<?php
namespace Smarty\Tool\Parser\Peg;

Use Smarty\Template\Context;
Use Smarty\Compiler;
Use Smarty\Parser;
use Smarty\Parser\Exception\NoRule;
/**
 * Class RuleRoot;
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
     * Flag if rules shall ba compiled as array
     *
     * @var bool
     */
    public $asArray = false;

    /*!*
        <pegparser RuleRoot;>

            <node Root>
                <rule>(.text:Text .parser:Parser*)*</rule>
                <action _start>
                    {
                        $nodeRes['_node']= new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Root;
                    }
                </action>
                <action text>
                    {
                        if (isset($matchRes['_node'])) {
                            $nodeRes['_node']->addNode($matchRes['_node']);
                        }
                    }
                </action>
                <action parser>
                    {
                        if ($this->asArray) {

                        } else {
                            if (isset($matchRes['_node'])) {
                                $nodeRes['_node']->addNode($matchRes['_node']);
                            }
                        }
                    }
                </action>
            </node>

            <node Text>
                <rule>/([\S\s]+(?=([^\S\r\n]\/\*!\*)))|[\S\s]+/</rule>
                <action _start>
                    {
                        $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Text ($this, null);
                    }
                </action>
                <action _all>
                    {
                        $nodeRes['_node']->addText($matchRes['_text']);
                    }
                </action>
            </node>


            <node Parser>
                <rule>..Header .._? '<pegparser' _ name:Name '>' attr:Attribute* node:Node* .._? '</pegparser>' .._? End?</rule>
                <action _start>
                    {
                            $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\PegParser;
                        }
                </action>
                <action name>
                    {
                            $nodeRes['_node']->setName($matchRes['_text']);
                        }
                </action>
                <action attr>
                    {
                            $nodeRes['_node']->addAttribute($matchRes['_node']);
                        }
                </action>
                <action node>
                    {
                            $nodeRes['_node']->addNode($matchRes['_node']);
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

            <node AttrValue>
                <rule> .._? ( /(?<true>true)|(?<false>false)|(?<null>null)|(?<v1>(('[^']*')|("[^"]*")|\d+|\w+))/ | ( '(' sub:AttrEntry ( ',' sub:AttrEntry )* ')' ) )</rule>
                <action sub>
                    {
                        if(!isset($nodeRes['value'])) {
                            $nodeRes['value'] = $matchRes['value'];
                        } else {
                            if (!is_array($nodeRes['value'])) {
                                $nodeRes['value'] = array($nodeRes['value']);
                            }
                            $nodeRes['value'] = array_merge($nodeRes['value'],$matchRes['value']);
                        }
                    }
                </action>
                <action _finish>
                    {
                        $mr = $nodeRes['_pregMatch'];
                        if (isset($mr['v1']) && !empty($mr['v1'])) {
                            $nodeRes['value'] = trim($mr['v1'], "'\"");
                        }
                        if (isset($mr['true']) && !empty($mr['true'])) {
                            $nodeRes['value'] = true;
                        }
                        if (isset($mr['false']) && !empty($mr['false'])) {
                            $nodeRes['value'] = false;
                        }
                        if (isset($mr['null']) && !empty($mr['null'])) {
                            $nodeRes['value'] = null;
                        }
                        $nodeRes['_pregMatch'] = array();
                    }
                </action>
            </node>


            <node AttrEntry>
                <rule> .._? key:Name .._? ( '=' .._? val:AttrValue)? </rule>
                <action key>
                {
                    $nodeRes['key'] = $matchRes['_text'];
                    $nodeRes['value'] = array($nodeRes['key'] => true);
                }
                </action>
                <action val>
                {
                    $nodeRes['value'][$nodeRes['key']] = $matchRes['value'];
                }
                </action>
             </node>


            <node Attribute>
                <attribute>importNode</attribute>
                <rule>.._? '<attribute>' attr:AttrEntry (',' attr:AttrEntry)* '</attribute>' .._?</rule>
                <action _start>
                    {
                        $nodeRes['_previousNode'] = $previous['_node'];
                    }
                </action>
                <action attr>
                    {
                        $nodeRes['_previousNode']->addAttribute($matchRes['value']);
                    }
                </action>
            </node>

            <node Node>
                <rule>.._?  instance:/\s*\<(?<type>(node|token))\s+(?<nodeName>[a-zA-Z_0-9]+)\>/  Attribute* Rule .Action* /<\/(node|token)>/ .._?</rule>
                <action _start>
                    {
                        $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Node;
                        $regexp = substr($this->parser->whitespacePattern, 0, strlen($this->parser->whitespacePattern) -1);
                        $regexp .= '\s*\<(node|token)\s+[a-zA-Z_]+\>[\s\S]*?\<\/(node|token)\>[\s\S]*?[\n]/';
                        if (preg_match($regexp, $this->source, $match, 0, $this->pos )) {
                            $nodeRes['definition'] = $match[0];
                        }
                    }
                </action>
                <action instance>
                    {
                        $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Node;
                        $nodeRes['_node']->setDefinition($nodeRes['definition']);
                    }
                </action>
                <action type>
                 {
                        $nodeRes['_node']->setType($matchRes['_pregMatch']['type']);
                 }
                </action>
                <action nodeName>
                    {
                        $nodeRes['_node']->setName($matchRes['_pregMatch']['nodeName']);
                    }
                </action>
            </node>


            <node Rule>
                <attribute>importNode</attribute>
                <rule>.._? '<rule>' .._? seq:Sequence .._? '</rule>' .._?</rule>
                <action _start>
                    {
                        $nodeRes['_previousNode'] = $previous['_node'];
                    }
                </action>
                <action seq>
                    {
                        $nodeRes['_previousNode']->setRule($matchRes['_node']);
                    }
                </action>
            </node>

            <node Action>
                <attribute>importNode</attribute>
                <rule>.._? instance:/\<action\s+(?<actionName>\w+)(\((?<argument>\w+)\))?\>/ .._? code:/(\{(?:(?>[^{}]+|(?R))*)?\})/ .._? '</action>' .._?</rule>
                <action _start>
                    {
                        $nodeRes['_previousNode'] = $previous['_node'];
                    }
                </action>
                <action instance>
                    {
                        $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Action;
                    }
                </action>
                <action actionName>
                    {
                        $nodeRes['_node']->setName($matchRes['_pregMatch']['actionName']);
                    }
                </action>
                <action argument>
                    {
                        $nodeRes['_node']->setArgument($matchRes['_pregMatch']['argument']);
                    }
                </action>
                <action code>
                    {
                        $nodeRes['_node']->setCode($matchRes['_text']);
                    }
                </action>
                <action _finish>
                    {
                        $nodeRes['_previousNode']->addAction($nodeRes['_node']);
                    }
                </action>
            </node>

            <node Option>
                <rule> _? token:RuleToken ( _? '|' _? token:RuleToken)*</rule>
                <action token>
                    {
                        $nodeRes['optionNodes'][] = $matchRes['_node'];
                    }
                </action>
                <action _finish>
                    {
                        if (count($nodeRes['optionNodes']) == 1) {
                           $nodeRes['_node'] = $nodeRes['optionNodes'][0];
                        } else {
                           $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Option;
                           $nodeRes['_node']->addOptionNodes($nodeRes['optionNodes']);
                        }
                    }
                </action>
            </node>

            <node Sequence>
                <rule>token:Option  token:Option*</rule>
                <action token>
                    {
                        $nodeRes['sequenceNodes'][] = $matchRes['_node'];
                    }
                </action>
                <action _finish>
                    {
                        if (count($nodeRes['sequenceNodes']) == 1) {
                           $nodeRes['_node'] = $nodeRes['sequenceNodes'][0];
                        } else {
                           $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Sequence;
                           $nodeRes['_node']->addSequenceNodes($nodeRes['sequenceNodes']);
                        }
                    }
                </action>
             </node>


            <node RuleToken>
                <rule>/((?<silent>\.+)|(?<pla>&)|(?<nla>\!))?((?<tag>\w+):)?/? ( /(?<rx>\G(\/|~|@|%|§)(((\\\\)*\\\2)|.*?(?=(\\|\2)))*\2)|((?<wsp>_)(?<wspOptional>\?)?)|(?<matchToken>\w+)|(?<literal>("[^"]*")|('[^']*'))|(\$(?<expression>\w+))/ | ('(' .._? seq:Sequence .._? ')')) /((?<quest>\?)|(?<any>\*)|(?<must>\+?)|(\{(?<min>\d+)?,(?<max>\d+)?\}))?/?</rule>
                <action _start>
                    {
                        if (!isset($nodeRes['_node'])) {
                            $nodeRes['_node'] = new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Token;
                        }
                    }
               </action>
               <action silent>
                    {
                        $nodeRes['_node']->setSilent(strlen($matchRes['_pregMatch']['silent']));
                    }
               </action>
               <action pla>
                    {
                            $nodeRes['_node']->setPla();
                            $nodeRes['_node']->setSilent(1);
                        }
               </action>
               <action nla>
                    {
                            $nodeRes['_node']->setNla();
                            $nodeRes['_node']->setSilent(1);
                        }
               </action>
               <action tag>
                    {
                            $nodeRes['_node']->setTag($matchRes['_pregMatch']['tag']);
                        }
               </action>
               <action rx>
                    {
                            $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\RegExpr($matchRes['_pregMatch']['rx']));
                        }
               </action>
               <action wsp>
                    {
                            $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\WhiteSpace(isset($matchRes['_pregMatch']['wspOptional']) ? true : false));
                        }
               </action>
               <action matchToken>
                    {
                            $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\MatchToken($matchRes['_pregMatch']['matchToken']));
                    }
               </action>
               <action literal>
                    {
                        $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Literal($matchRes['_pregMatch']['literal']));
                    }
               </action>
               <action expression>
                    {
                        $nodeRes['_node']->setRuleToken(new \Smarty\Parser\Peg\Generator\Compiler\Nodes\Expression($matchRes['_pregMatch']['expression']));
                    }
               </action>
               <action seq>
                    {
                        $nodeRes['_node']->setRuleToken($matchRes['_node']);
                    }
               </action>
               <action quest>
                    {
                        $nodeRes['_node']->setMin(0);
                    }
               </action>
               <action any>
                    {
                        $nodeRes['_node']->setMin(0);
                        $nodeRes['_node']->setMax(null);
                    }
               </action>
               <action must>
                    {
                        $nodeRes['_node']->setMax(null);
                    }
               </action>
               <action min>
                    {
                        $nodeRes['_node']->setMin($matchRes['_pregMatch']['min']);
                        if (isset($matchRes['_pregMatch']['max'])) {
                            $nodeRes['_node']->setMax($matchRes['_pregMatch']['max']);
                            unset($matchRes['_pregMatch']['max']);
                        } else {
                            $nodeRes['_node']->setMax($matchRes['_pregMatch']['max']);
                        }
                    }
               </action>
               <action max>
                    {
                        $nodeRes['_node']->setMax($matchRes['_pregMatch']['max']);
                    }
               </action>
               <action _finish>
                    {
                        $nodeRes['_node']->setRuleText($nodeRes['_text']);
                        $nodeRes['_pregMatch'] = array();
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
        $this->context = $context;
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

