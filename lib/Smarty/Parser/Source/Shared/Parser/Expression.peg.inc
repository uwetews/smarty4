<?php
namespace Smarty\Parser\Source\Shared\Parser;

use Smarty\Parser\Source\Language\Smarty\Node\Value\Number;
use Smarty\Parser\Source\Language\Smarty\Node\Value\String;
use Smarty\Parser\Source\Language\Smarty\Node\Value\Boolean;
use Smarty\Parser\Source\Language\Smarty\Node\Value\Subexpression;
use Smarty\Parser\Source\Language\Smarty\Node\Value\FunctionCall;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Math;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Unimath;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Unilog;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Condition;
use Smarty\Parser\Source\Language\Smarty\Node\Operator\Logical;
use Smarty\Parser\Source\Language\Smarty\Node\Tag\TagStatement;
use Smarty\PegParser;

/**
 * Class ExpressionParser
 *
 * @package Smarty\Parser\Source\Shared\Parser
 */
class ExpressionParser extends PegParser
{

    /*!*
    <pegparser Expression>

        <node Number>
            <attribute>hash</attribute>
            <rule>/\[0-9]+(?:\.[0-9]+)?/</rule>
            <action _finish>
            {
                $result['node'] = new Number($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

        <node String>
            <attribute>hash</attribute>
            <rule>/'[^'\\]*(?:\\.[^'\\]*)*'/</rule>
            <action _finish>
            {
                $result['node'] = new String($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

        <node Boolean>
            <attribute>hash</attribute>
            <rule>/(true|false)(?![^a-zA-Z0-9])/</rule>
            <action _finish>
            {
                $result['node'] = new Boolean($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

        <node Null>
            <attribute>hash</attribute>
            <rule>/null(?![^a-zA-Z0-9])/</rule>
            <action _finish>
            {
                $result['node'] = new Null($this->parser);
                $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
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
                $result['node'] = new Number($this->parser);
                $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            }
            </action>
            <action string>
            {
                $result['node'] = new String($this->parser);
                $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            }
            </action>
            <action bool>
            {
                $result['node'] = new Boolean($this->parser);
                $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            }
            </action>
            <action null>
            {
                $result['node'] = new Null($this->parser);
                $result['node']->setValue($subres['_text'])->setTraceInfo($subres['_lineno'], $subres['_text'], $subres['_startpos'], $subres['_endpos']);
            }
            </action>
        </token>

        <token Array>
            <rule> ( 'array' _? '(' item:Arrayitem (',' item:Arrayitem)* ','? ')' ) | ('[' item:Arrayitem (',' item:Arrayitem)* ','? ']')</rule>
        </token>

        <token  Arrayitem>
           <rule> ( index:Value _? '=>' _?)? value:Value  </rule>
        </token>




        <node FunctionCall>
            <rule>(name:Id | namevar:Variable) param:Parameter</rule>
            <action name>
            {
                $result['name'] = $subres['_text'];
            }
            </action>
            <action namevar>
            {
                $result['namevar'] = $subres['node'];
            }
            </action>
            <action param>
            {
                $result['node'] = new FunctionCall($this->parser);
                if (isset($result['name'])) {
                    $string = new String($this->parser);
                    $string->setValue($result['name'], true);
                    $result['node']->setNameNode($string);
                } else {
                    $result['node']->setNameNode($result['namevar']);
                }
                $result['node']->setParameterNodes(isset($subres['param']) ? $subres['param'] : null);
            }
            </action>
        </node>

        <token Parameter>
            <rule> '(' ( param:Expr ( ',' param:Expr)*)? ')' </rule>
            <action param>
            {
                $result['param'][] = $subres['node'];
            }
            </action>
        </token>


        <token Value>
            <attribute>hash</attribute>
            <rule> value:AnyLiteral | (value:Variable !'(') | ( '(' subexpr:Expr ')' ) | value:FunctionCall  | value:Array </rule>
            <action value>
            {
                $result['node'] = $subres['node'];
            }
            </action>
            <action subexpr>
            {
                $result['node'] = new Subexpression($this->parser, $subres['node']);
            }
            </action>
        </token>


        <token Statement>
            <rule> var:Variable arr:'[]'? _? append:'.'? '=' _? value:Expr _? </rule>
            <action var>
            {
                $result['node'] = new TagStatement($this->parser);
                $result['var'] = $subres['node'];
            }
            </action>
            <action arr>
            {
                $result['var']->addSubTree(array('type' => 'arrayelement', 'node' => null) , 'suffix', true);
            }
            </action>
            <action value>
            {
                $result['node']->setTagAttribute(array('value', $subres['node']));
            }
            </action>
            <action append>
            {
                $result['node']->setTagAttribute(array('append', true));
            }
            </action>
            <action _finish>
            {
                $result['node']->setTagAttribute(array('variable', $result['var']));
            }
            </action>
        </token>



        <token ModifierValue>
            <attribute>hash</attribute>
             <rule> value:Value addmodifier:('|' name:Id (':' param:Value)*)* </rule>
             <action value>
            {
               $result['node'] = $subres['node'];
            }
            </action>
            <action addmodifier>
            {
                if (isset($subres['name'])) {
                        $value = $result['node'];
                        $result['node'] = new Node($this->parser, 'Modifier');
                        $result['node']->addSubTree($value, 'value');
                        $result['node']->addSubTree($subres['name'], 'name');
                        $result['node']->addSubTree(isset($subres['param']) ? $subres['param'] : false, 'param');
                }
            }
            </action>
            <action param>
            {
               $result['param'][] = $subres['node'];
            }
            </action>
            <action name>
            {
               $string = new String($this->parser);
               $string->setValue($subres['_text'], true);
               $result['name'] = $string;
            }
            </action>
        </node>

       <token Expr>
            <rule> value:Mathexpr | value:Logexpr  </rule>
             <action _all>
            {
               $result['node'] = $subres['node'];
            }
            </action>
       </token>

        <token Mathexpr>
            <rule> (operator:Unimath left:ModifierValue) | (left:ModifierValue)  (operator:Unimath | (operator:Math operator:Unimath?) right:ModifierValue )* </rule>
            <action _all>
            {
                if (!isset($result['node'])) {
                    $result['node'] = array();
                }
                $result['node'][] = $subres['node'];
            }
            </action>
        </token>

        <token Logexpr>
            <rule> (operator:Unilog left:ModifierValue)|(left:ModifierValue operator:NamedCondition?) ( operator:Logical | (operator:Condition|operator:NamedCondition2) (operator:Unilog right:ModifierValue)|(right:ModifierValue operator:NamedCondition?) )* </rule>
            <action _all>
            {
                if (!isset($result['node'])) {
                    $result['node'] = array();
                }
                $result['node'][] = $subres['node'];
            }
            </action>
        </token>



        <token Condition>
            <attribute>matchall</attribute>
            <rule>/(\s*(===|!==|==|!=|<>|<=|<|>=|>)\s*)|(\s+(eq|ne|ge|gte|gt|le|lte|lt|instanceof)\s+)/ </rule>
            <action _finish>
            {
                $result['node'] = new Condition($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
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
                $result['node'] = new Logical($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </token>

        <node Math>
            <attribute>matchall</attribute>
            <rule>/(\s*(\*|\/|%|&|\|^|>>|<<)\s*)|(\s+mod\s+)/</rule>
            <action _finish>
            {
                $result['node'] = new Math($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

        <node Unimath>
            <attribute>matchall</attribute>
            <rule>/\s*(\+|-|~)\s* /</rule>
            <action _finish>
            {
                $result['node'] = new Unimath($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
         </node>


        <node Unilog>
            <attribute>matchall</attribute>
            <rule>/((!|~)\s*)|(not\s+)/</rule>
            <action _finish>
            {
                $result['node'] = new Unilog($this->parser);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>



    </pegparser>
    */

}

