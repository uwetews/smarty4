<?php
namespace Smarty\Parser\Source\Shared\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Value\Number;
use Smarty\Parser\Source\Language\Smarty\Node\Value\String;
use Smarty\Parser\Source\Language\Smarty\Node\Value\DoubleQuoted;
use Smarty\Parser\Source\Language\Smarty\Node\Value\Boolean;
use Smarty\Parser\Source\Language\Smarty\Node\Value\Null;
use Smarty\Parser\Source\Language\Smarty\Node\Value\Variable;
use Smarty\Parser\Source\Language\Smarty\Node\Value\Subexpression;
use Smarty\Parser\Source\Language\Smarty\Node\Value\FunctionCall;
use Smarty\Parser\Source\Language\Smarty\Node\Value\ArrayValue;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Math;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Unimath;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Unilog;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Condition;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Logical;
use Smarty\Parser\Source\Language\Smarty\Node\Tag\TagStatement;
use Smarty\Parser\Peg\RuleRoot;

/**
 * Class ExpressionParser
 *
 * @package Smarty\Parser\Source\Shared\Parser
 */
class ExpressionParser extends RuleRoot
{
    /**
     * Currently not used

     */

    /*!*
    <pegparser Expression>

        <token Id>
            <rule>/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]* /</rule>
        </token>

        <node Number>
            <attribute>hash</attribute>
            <rule>/\[0-9]+(?:\.[0-9]+)?/</rule>
            <action _finish>
            {
                $nodeRes['node'] = new Number($this->parser);
                $nodeRes['node']->setValue($nodeRes['_text'])->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
            }
            </action>
        </node>

        <node Boolean>
            <attribute>hash</attribute>
            <rule>/(true|false)(?![^a-zA-Z0-9])/</rule>
            <action _finish>
            {
            $nodeRes['node'] = new Boolean($this->parser);
            $nodeRes['node']->setValue($nodeRes['_text'])->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
            }
            </action>
        </node>

        <node Null>
            <attribute>hash</attribute>
            <rule>/null(?![^a-zA-Z0-9])/</rule>
            <action _finish>
            {
                $nodeRes['node'] = new Null($this->parser);
                $nodeRes['node']->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
            }
            </action>
        </node>

        <node DoubleQuoted>
            <rule> '"' ( ( '$' simpleVar:Id ) | ( '`' variable:Variable '`' ) | ( '{' expression:Expr '}' ) | dq:'\"' | text:/(([\s\S])*?(?=(\{|\$|(`\$)|(\\")|")))/ )* '"' </rule>
            <action simpleVar>
            {
                $var = new Variable($this->parser);
                $node = new String($this->parser);
                $var->addSubTree($node->setValue($matchRes['_text'], true)->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']), 'name', true);
                $nodeRes['nodes'][] = $var;
            }
            </action>
            <action variable>
            {
                $nodeRes['nodes'][] = $matchRes['node'];
            }
            </action>
            <action expression>
            {
                $nodeRes['nodes'][] = $matchRes['node'];
            }
            </action>
            <action dq>
            {
                $node = new String($this->parser);
                $node->setValue('"', false, false);
                $nodeRes['nodes'][] = $node;
            }
            </action>
            <action text>
            {
                $node = new String($this->parser);
                $node->setValue($matchRes['_text']);
                $nodeRes['nodes'][] = $node;
            }
            </action>
            <action _finish>
            {
                if (!isset($nodeRes['nodes'])) {
                    $node = new String($this->parser);
                    $node->setValue('')->setTraceInfo($nodeRes['_lineno'], '', $nodeRes['_startpos'], $nodeRes['_endpos']);
                    $nodeRes['nodes'][] = $node;
                }
                $node =  new DoubleQuoted($this->parser);
                $node->setTextSegmentsNodes($nodeRes['nodes']);
                unset($nodeRes['nodes']);
                $nodeRes['node'] = $node;
            }
            </action>
            <action _init(getLdel)>
                {
                    return $this->parser->Ldel;
                }
            </action>
        </node>

        <node String>
            <attribute>hash</attribute>
            <rule>/'[^'\\]*(?:\\.[^'\\]*)*'/</rule>
            <action _finish>
            {
                $nodeRes['node'] = new String($this->parser);
                $nodeRes['node']->setValue($nodeRes['_text'])->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
            }
            </action>
        </node>

        <token AnyLiteral>
            # This combination of basic nodes is implemented for speed optimization
            <attribute>hash</attribute>
            <rule>/(?<number>([0-9]+(?:\.[0-9]+)?))|(?<string>('[^'\\]*(?:\\.[^'\\]*)*'))|(((?<null>null)|(?<bool>(true|false)))(?![_a-zA-Z0-9]))/</rule>
            <action _start> {
                $i = 1;
            }
            </action>
            <action number>
            {
                $nodeRes['node'] = new Number($this->parser);
                $nodeRes['node']->setValue($matchRes['_text'])->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
            }
            </action>
            <action string>
            {
                $nodeRes['node'] = new String($this->parser);
                $nodeRes['node']->setValue($matchRes['_text'])->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
            }
            </action>
            <action bool>
            {
                $nodeRes['node'] = new Boolean($this->parser);
                $nodeRes['node']->setValue($matchRes['_text'])->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
            }
            </action>
            <action null>
            {
                $nodeRes['node'] = new Null($this->parser);
                $nodeRes['node']->setValue($matchRes['_text'])->setTraceInfo($matchRes['_lineno'], $matchRes['_text'], $matchRes['_startpos'], $matchRes['_endpos']);
            }
            </action>
        </token>

        <token ArrayValue>
            <rule> ( /\s*array\s*[(]\s* / item:ArrayItem ( /\s*,\s* / item:ArrayItem)* /\s*,?\s*[)]/ ) | (/\s*\[\s* / item:ArrayItem (/\s*,\s* / item:ArrayItem)* /\s*,?\s*\]/ )</rule>
            <action item>
            {
                $nodeRes['arrayItems'][] = array($matchRes['index'], $matchRes['value']);
            }
            </action>
           <action _finish>
            {
                $nodeRes['node'] = new ArrayValue($this->parser);
                $nodeRes['node']->setKeyValueNodes($nodeRes['arrayItems']);
                $nodeRes['node']->setValue($nodeRes['_text'])->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
            }
            </action>
        </token>

        <token  ArrayItem>
           <rule> ( index:Value /\s*=>\s* / )? value:Value  </rule>
            <action index>
            {
                $nodeRes['index'] = $matchRes['node'];
            }
            </action>
            <action value>
            {
                if (!isset($nodeRes['index'])) {
                    $nodeRes['index'] = null;
                }
                $nodeRes['value'] = $matchRes['node'];
            }
            </action>
        </token>




        <node FunctionCall>
            <rule>(name:Id | namevar:Variable) param:Parameter</rule>
            <action name>
            {
                $nodeRes['name'] = $matchRes['_text'];
            }
            </action>
            <action namevar>
            {
                $nodeRes['namevar'] = $matchRes['node'];
            }
            </action>
            <action param>
            {
                $nodeRes['node'] = new FunctionCall($this->parser);
                if (isset($nodeRes['name'])) {
                    $string = new String($this->parser);
                    $string->setValue($nodeRes['name'], true);
                    $nodeRes['node']->setNameNode($string);
                } else {
                    $nodeRes['node']->setNameNode($nodeRes['namevar']);
                }
                $nodeRes['node']->setParameterNodes(isset($matchRes['param']) ? $matchRes['param'] : null);
            }
            </action>
        </node>

        <token Parameter>
            <rule> '(' ( param:Expr ( ',' param:Expr)*)? ')' </rule>
            <action param>
            {
                $nodeRes['param'][] = $matchRes['node'];
            }
            </action>
            <action _finish>
            {
                if (!isset($nodeRes['param'])) {
                    $nodeRes['param'] = array();
                }
            }
            </action>
        </token>


        <token Value>
            <attribute>hash</attribute>
            <rule> value:AnyLiteral | (&'$' value:Variable !'(') | ( &'"' value:DoubleQuoted ) | ( '(' subexpr:Expr ')' ) | value:ArrayValue | value:FunctionCall  </rule>
            <action value>
            {
                $nodeRes['node'] = $matchRes['node'];
            }
            </action>
            <action subexpr>
            {
                $nodeRes['node'] = new Subexpression($this->parser, $matchRes['node']);
            }
            </action>
        </token>


        <token Statement>
            <rule> var:Variable /(?<arr>(\[\s*\]))?\s*(?<append>[.])?=\s* / value:Expr _? </rule>
            <action var>
            {
                $nodeRes['node'] = new TagStatement($this->parser);
                $nodeRes['var'] = $matchRes['node'];
            }
            </action>
            <action arr>
            {
                $nodeRes['var']->addSubTree(array('type' => 'arrayelement', 'node' => null) , 'suffix', true);
            }
            </action>
            <action value>
            {
                $nodeRes['node']->setTagAttribute(array('value', $matchRes['node']));
            }
            </action>
            <action append>
            {
                $nodeRes['node']->setTagAttribute(array('append', true));
            }
            </action>
            <action _finish>
            {
                $nodeRes['node']->setTagAttribute(array('variable', $nodeRes['var']));
            }
            </action>
        </token>



        <token ModifierValue>
            <attribute>hash</attribute>
             <rule> value:Value addmodifier:('|' name:Id (':' param:Value)*)* </rule>
             <action value>
            {
               $nodeRes['node'] = $matchRes['node'];
            }
            </action>
            <action addmodifier>
            {
                if (isset($matchRes['name'])) {
                        $value = $nodeRes['node'];
                        $nodeRes['node'] = new Node($this->parser, 'Modifier');
                        $nodeRes['node']->addSubTree($value, 'value');
                        $nodeRes['node']->addSubTree($matchRes['name'], 'name');
                        $nodeRes['node']->addSubTree(isset($matchRes['param']) ? $matchRes['param'] : false, 'param');
                }
            }
            </action>
            <action param>
            {
               $nodeRes['param'][] = $matchRes['node'];
            }
            </action>
            <action name>
            {
               $string = new String($this->parser);
               $string->setValue($matchRes['_text'], true);
               $nodeRes['name'] = $string;
            }
            </action>
        </node>

       <token Expr>
            <rule> value:Mathexpr | value:Logexpr  </rule>
             <action _all>
            {
               $nodeRes['node'] = $matchRes['node'];
            }
            </action>
       </token>

        <token Mathexpr>
            <rule> (operator:Unimath left:ModifierValue) | (left:ModifierValue)  (operator:Unimath | (operator:Math operator:Unimath?) right:ModifierValue )* </rule>
            <action _all>
            {
                if (!isset($nodeRes['node'])) {
                    $nodeRes['node'] = array();
                }
                $nodeRes['node'][] = $matchRes['node'];
            }
            </action>
        </token>

        <token Logexpr>
            <rule> (operator:Unilog left:ModifierValue)|(left:ModifierValue operator:NamedCondition?) ( operator:Logical | (operator:Condition|operator:NamedCondition2) (operator:Unilog right:ModifierValue)|(right:ModifierValue operator:NamedCondition?) )* </rule>
            <action _all>
            {
                if (!isset($nodeRes['node'])) {
                    $nodeRes['node'] = array();
                }
                $nodeRes['node'][] = $matchRes['node'];
            }
            </action>
        </token>



        <token Condition>
            <attribute>matchall</attribute>
            <rule>/(\s*(===|!==|==|!=|<>|<=|<|>=|>)\s*)|(\s+(eq|ne|ge|gte|gt|le|lte|lt|instanceof)\s+)/ </rule>
            <action _finish>
            {
                $nodeRes['node'] = new Condition($this->parser);
                $nodeRes['node']->setValue($nodeRes['_text'])->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
            }
            </action>
        </token>

        <token NamedCondition>
            <attribute>matchall</attribute>
            <rule>/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/ </rule>
        </token>

       <token NamedCondition2>
            <attribute>matchall</attribute>
            <rule>/\s+is\s+(not\s+)?(((odd|even|div)\s+by)|in)\s+/</rule>
        </token>

        <token Logical>
            <attribute>matchall</attribute>
            <rule>/\s*((\|\||&&)\s*)|((and|or|xor)\s+)/</rule>
            <action _finish>
            {
                $nodeRes['node'] = new Logical($this->parser);
                $nodeRes['node']->setValue($nodeRes['_text'])->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
            }
            </action>
        </token>

        <node Math>
            <attribute>matchall</attribute>
            <rule>/(\s*(\*|\/|%|&|\|^|>>|<<)\s*)|(\s+mod\s+)/</rule>
            <action _finish>
            {
                $nodeRes['node'] = new Math($this->parser);
                $nodeRes['node']->setValue($nodeRes['_text'])->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
            }
            </action>
        </node>

        <node Unimath>
            <attribute>matchall</attribute>
            <rule>/\s*(\+|-|~)\s* /</rule>
            <action _finish>
            {
                $nodeRes['node'] = new Unimath($this->parser);
                $nodeRes['node']->setValue($nodeRes['_text'])->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
            }
            </action>
         </node>


        <node Unilog>
            <attribute>matchall</attribute>
            <rule>/((!|~)\s*)|(not\s+)/</rule>
            <action _finish>
            {
                $nodeRes['node'] = new Unilog($this->parser);
                $nodeRes['node']->setValue($nodeRes['_text'])->setTraceInfo($nodeRes['_lineno'], $nodeRes['_text'], $nodeRes['_startpos'], $nodeRes['_endpos']);
            }
            </action>
        </node>



    </pegparser>
    */

}

