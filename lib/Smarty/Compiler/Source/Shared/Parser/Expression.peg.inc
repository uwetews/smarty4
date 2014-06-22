<?php
namespace Smarty\Compiler\Source\Shared\Parser;

use Smarty\Node;

/**
 * Class PegParser
 *
 * @package Smarty\Nodes\Core
 */
class ExpressionParser
{
    /*!*
    <pegparser Expression>

        <node Number>
            <attribute>hash</attribute>
            <rule>/-?[0-9]+(?:\.[0-9]+)?/</rule>
            <action _finish>
            {
                $result['node'] = new Node\Value\Number($result['_parser']);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

        <node String>
            <attribute>hash</attribute>
            <rule>/'[^'\\]*(?:\\.[^'\\]*)*'/</rule>
            <action _finish>
            {
                $result['node'] = new Node\Value\String($result['_parser']);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

        <node Boolean>
            <attribute>hash</attribute>
            <rule>/(true|false)(?![^a-zA-Z0-9])/</rule>
            <action _finish>
            {
                $result['node'] = new Node\Value\Boolean($result['_parser']);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

        <node Null>
            <attribute>hash</attribute>
            <rule>/null(?![^a-zA-Z0-9])/</rule>
            <action _finish>
            {
                $result['node'] = new Node\Value\Null($result['_parser']);
                $result['node']->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

        <token AnyLiteral>
            # This combination of basic nodes is implemented for speed optimization
            <attribute>hash</attribute>
            <rule>/(?<number>(-?[0-9]+(?:\.[0-9]+)?))|(?<string>('[^'\\]*(?:\\.[^'\\]*)*'))|(((?<null>null)|(?<bool>(true|false)))(?![_a-zA-Z0-9]))/</rule>
            <action _start> {
                $i = 1;
            }
            </action>
            <action _finish>
            {
                if (isset($result['_matchres']['number'])) {
                    $result['node'] = new Node\Value\Number($result['_parser']);
                } elseif (isset($result['_matchres']['string'])) {
                    $result['node'] = new Node\Value\String($result['_parser']);
                } elseif (isset($result['_matchres']['bool'])) {
                    $result['node'] = new Node\Value\Boolean($result['_parser']);
                } else {
                    $result['node'] = new Node\Value\Null($result['_parser']);
                }
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </token>

        <token Array>
            <rule> ( 'array' _? '(' item:Arrayitem (',' item:Arrayitem)* ','? ')' ) | ('[' item:Arrayitem (',' item:Arrayitem)* ','? ']')</rule>
        </token>

        <token  Arrayitem>
           <rule> ( index:Value _? '=>' _?)? value:Value  </rule>
        </token>




        <node Functioncall>
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
                $result['node'] = new Node($result['_parser'], 'Functioncall');
                if (isset($result['name'])) {
                    $string = new Node\Value\String($result['_parser']);
                    $string->setValue($result['name'], true);
                    $result['node']->addSubTree($string, 'name');
                } else {
                    $result['node']->addSubTree($result['namevar'], 'name');
                }
                $result['node']->addSubTree(isset($subres['funcpar']) ? $subres['funcpar'] : false, 'param');
            }
            </action>
        </node>

        <token Parameter>
            <rule> '(' ( param:Expr ( ',' param:Expr)*)? ')' </rule>
            <action param>
            {
                $result['funcpar'][] = $subres['node'];
            }
            </action>
        </token>


        <token Value>
            <attribute>hash</attribute>
            <rule>  (value:Variable !'(') | value:AnyLiteral | ( '(' subexpr:Expr ')' ) | value:Functioncall  | value:Array </rule>
            <action value>
            {
                $result['node'] = $subres['node'];
            }
            </action>
            <action subexpr>
            {
                $result['node'] = new Node\Value\Subexpression($result['_parser'], $subres['node']);
            }
            </action>
        </token>


        <token Statement>
            <rule> var:Variable '=' value:Expr _? </rule>
        </token>



        <token ModifierValue>
            <attribute>hash</attribute>
             <rule> .value:Value .addmodifier:('|' name:Id (':' param:Value)*)* </rule>
             <action value>
            {
               $result['node'] = $subres['node'];
            }
            </action>
            <action addmodifier>
            {
                if (isset($subres['name'])) {
                        $value = $result['node'];
                        $result['node'] = new Node($result['_parser'], 'Modifier');
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
               $string = new Node\Value\String($result['_parser']);
               $string->setValue($subres['_text'], true);
               $result['name'] = $string;
            }
            </action>
        </node>

       <token Expr>
            <rule> value:Mathexpr | value:Logexpr _? </rule>
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
            <rule> (operator:Unilog left:ModifierValue)|(left:ModifierValue operator:NamedCondition?) ( (operator:Condition|operator:NamedCondition2) (operator:Unilog right:ModifierValue)|(right:ModifierValue operator:NamedCondition?) )* </rule>
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
            <rule>/(\s*(?<op>(===|!==|==|!=|<>|<=|<|>=|>))\s*)|(\s+(?<op2>(eq|ne|ge|gte|gt|le|lte|lt|instanceof))\s+)/ </rule>
            <action op>
            {
                $result->_type = 'operator';
                $result->_subtype = 'bool';
                switch ($subres['_matchres']['op']) {
                        case '<>':
                            $result->_compile = '!=';
                            break;
                        default:
                            $result->_compile = $subres['_matchres']['op'];
                            break;
                }
                $result->_compile = ' ' . $result->_compile . ' ';
                unset($subres['_matchres']['op']);
            }
            </action>
            <action op2>
            {
                $result->_type = 'operator';
                $result->_subtype = 'bool';
                switch ($subres['_matchres']['op2']) {
                       case 'eq':
                            $result->_compile = '==';
                            break;
                        case 'ne':
                            $result->_compile = '==';
                            break;
                        case 'ge':
                        case 'gte':
                            $result->_compile = '>=';
                            break;
                        case 'gt':
                            $result->_compile = '>';
                            break;
                        case 'le':
                        case 'lte':
                            $result->_compile = '<=';
                            break;
                        case 'lt':
                            $result->_compile = '<';
                            break;
                        case 'lt':
                            $result->_compile = 'instanceof';
                            break;
                        default:
                            $result->_compile = $subres['_matchres']['op2'];
                            break;
                }
                $result->_compile = ' ' . $result->_compile . ' ';
                unset($subres['_matchres']['op2']);
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

        <token Logop>
            <attribute>matchall</attribute>
            <rule>/\s*((\|\||\|&&|&|^)\s*)|((and|or|xor)\s+)/</rule>
        </token>

        <node Math>
            <attribute>matchall</attribute>
            <rule>/(\s*(\*|\/|%)\s*)|(\s+mod\s+)/</rule>
            <action _finish>
            {
                $result['node'] = new Node\Operator\Math($result['_parser']);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>

        <node Unimath>
            <attribute>matchall</attribute>
            <rule>/\s*(\+|-)\s* /</rule>
            <action _finish>
            {
                $result['node'] = new Node\Operator\Unimath($result['_parser']);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
         </node>


        <node Unilog>
            <attribute>matchall</attribute>
            <rule>/((!|~)\s*)|(not\s+)/</rule>
            <action _finish>
            {
                $result['node'] = new Node\Operator\Unilog($result['_parser']);
                $result['node']->setValue($result['_text'])->setTraceInfo($result['_lineno'], $result['_text'], $result['_startpos'], $result['_endpos']);
            }
            </action>
        </node>



    </pegparser>
    */
}

